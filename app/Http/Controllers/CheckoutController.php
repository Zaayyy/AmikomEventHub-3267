<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Mail\EventTicketMail;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct(private MidtransService $midtrans)
    {
    }

    public function create(Event $event)
{
    // Cek event sudah selesai
    if ($event->date->isPast()) {
        return redirect()
            ->route('events.show', $event)
            ->with('error', 'Event telah selesai.');
    }

    // Cek stok tiket
    if ($event->stock <= 0) {
        return redirect()
            ->route('events.show', $event)
            ->with('error', 'Tiket sudah habis.');
    }

    // Cegah pembelian tiket dua kali
    if (auth()->check()) {

        $alreadyBought = Transaction::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'success', 'settlement'])
            ->exists();

        if ($alreadyBought) {
            return redirect()
                ->route('events.show', $event)
                ->with('error', 'Anda sudah memiliki tiket event ini.');
        }
    }

    $categories = \App\Models\Category::all();

    return view('checkout.create', compact('event', 'categories'));
}

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|regex:/^08[0-9]{8,11}$/',
        ], [
            'customer_phone.regex' => 'Nomor HP harus diawali 08 dan berjumlah 10-13 digit.',
        ]);

        // Cegah pembelian tiket dua kali melalui POST
if (Auth::check()) {

    $alreadyBought = Transaction::where('event_id', $event->id)
        ->where('user_id', Auth::id())
        ->whereIn('status', ['pending', 'success', 'settlement'])
        ->exists();

    if ($alreadyBought) {
        return back()
            ->withInput()
            ->with('error', 'Anda sudah mempunyai tiket event ini.');
    }

}

        if ($event->stock <= 0) {
            return back()
                ->withInput()
                ->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        $isFreeEvent = (int) $event->price === 0;
        $totalPrice = $isFreeEvent ? 0 : $event->price + 5000;

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'user_id' => Auth::check() ? Auth::id() : null,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => $isFreeEvent ? 'success' : 'pending',
        ]);

        if ($isFreeEvent) {
            $this->issueTicket($transaction);

            return redirect()->route('checkout.success', $transaction->order_id);
        }

        

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

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        if (in_array($transaction->status, ['success', 'settlement'], true)) {
            return view('checkout.success', compact('transaction', 'categories'));
        }
        
        // Konfigurasi Midtrans untuk mengecek status transaksi langsung ke API
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // Mengecek status pesanan secara mandiri (Bypass)
            $status = \Midtrans\Transaction::status($order_id);
            
            if ($status) {
                // Mengambil nilai status transaksi
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');
                
                // Jika API Midtrans mengonfirmasi bahwa transaksi telah berhasil (settlement / capture)
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    // Hanya lakukan update jika status di database lokal masih 'pending' (indikasi Webhook tidak masuk)
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'success']);
                        
                        if ($transaction->event && $transaction->event->stock > 0) {
                            $transaction->event->stock = $transaction->event->stock - 1;
                            $transaction->event->save();
                            
                            $this->sendTicketMail($transaction);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika terjadi error dari API Midtrans (transaksi tidak valid), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }

    private function issueTicket(Transaction $transaction): void
    {
        $transaction->loadMissing('event');

        if ($transaction->event && $transaction->event->stock > 0) {
            $transaction->event->decrement('stock');
        }

        $this->sendTicketMail($transaction);
    }

    private function sendTicketMail(Transaction $transaction): void
    {
        try {
            Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
        }
    }
}