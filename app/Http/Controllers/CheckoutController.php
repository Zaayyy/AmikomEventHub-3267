<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private MidtransService $midtrans)
    {
    }

    public function create(Event $event)
    {
        $categories = \App\Models\Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()
                ->withInput()
                ->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price + 5000;

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => 'Pending',
        ]);

        

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
            'item_details' => [
                [
                    'id' => 'EVENT-' . $event->id,
                    'price' => $event->price,
                    'quantity' => 1,
                    'name' => Str::limit($event->title, 45, ''),
                ],
                [
                    'id' => 'SERVICE-FEE',
                    'price' => 5000,
                    'quantity' => 1,
                    'name' => 'Biaya Layanan',
                ],
            ],
        ];

        try {
            $snapToken = $this->midtrans->createSnapToken($params);

            $transaction->update([
                'snap_token' => $snapToken,
                'status' => 'pending',
            ]);

            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            $transaction->update(['status' => 'failed']);

            return back()
                ->withInput()
                ->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    public function payment(string $order_id)
    {
        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        if (! $transaction->snap_token) {
            return redirect()
                ->route('home')
                ->with('error', 'Snap Token untuk transaksi ini belum tersedia.');
        }

        return view('checkout.payment', compact('transaction'));
    }

    public function success(string $order_id)
    {
        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        try {
            $transactionStatus = $this->midtrans->getTransactionStatus($order_id);

            if (in_array($transactionStatus, ['capture', 'settlement'], true)) {
                $transaction->update(['status' => 'success']);
            } elseif ($transactionStatus === 'pending') {
                $transaction->update(['status' => 'pending']);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire', 'failure'], true)) {
                $transaction->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction'));
    }
}
