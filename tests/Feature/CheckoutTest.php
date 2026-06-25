<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_create_pending_checkout_transaction(): void
    {
        $this->mock(MidtransService::class, function ($mock) {
            $mock->shouldReceive('createSnapToken')
                ->once()
                ->andReturn('dummy-snap-token');
        });

        $category = Category::create([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Laravel Checkout Class',
            'description' => 'Latihan checkout.',
            'date' => '2026-07-01 10:00:00',
            'location' => 'Lab SI',
            'price' => 50000,
            'stock' => 10,
        ]);

        $response = $this->post(route('checkout.store', $event), [
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'budi@example.com',
            'customer_phone' => '081234567890',
        ]);

        $transaction = Transaction::first();

        $response
            ->assertRedirect(route('checkout.payment', $transaction->order_id));

        $this->assertDatabaseHas('transactions', [
            'event_id' => $event->id,
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'budi@example.com',
            'customer_phone' => '081234567890',
            'total_price' => 55000,
            'status' => 'pending',
            'snap_token' => 'dummy-snap-token',
        ]);

        $this->assertStringStartsWith('TRX-', $transaction->order_id);
    }

    public function test_guest_cannot_checkout_when_event_stock_is_empty(): void
    {
        $category = Category::create([
            'name' => 'Seminar',
            'slug' => 'seminar',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Sold Out Event',
            'description' => 'Tiket habis.',
            'date' => '2026-07-02 10:00:00',
            'location' => 'Auditorium',
            'price' => 75000,
            'stock' => 0,
        ]);

        $response = $this->from(route('checkout.create', $event))->post(route('checkout.store', $event), [
            'customer_name' => 'Siti Aminah',
            'customer_email' => 'siti@example.com',
            'customer_phone' => '089876543210',
        ]);

        $response
            ->assertRedirect(route('checkout.create', $event))
            ->assertSessionHas('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_success_page_updates_transaction_status_from_midtrans(): void
    {
        $this->mock(MidtransService::class, function ($mock) {
            $mock->shouldReceive('getTransactionStatus')
                ->once()
                ->andReturn('settlement');
        });

        $category = Category::create([
            'name' => 'Seminar',
            'slug' => 'seminar-status',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Midtrans Settlement Event',
            'description' => 'Status settlement.',
            'date' => '2026-07-03 10:00:00',
            'location' => 'Auditorium',
            'price' => 75000,
            'stock' => 20,
        ]);

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'TRX-STATUS-12345',
            'customer_name' => 'Rina',
            'customer_email' => 'rina@example.com',
            'customer_phone' => '081111111111',
            'total_price' => 80000,
            'status' => 'pending',
            'snap_token' => 'dummy-snap-token',
        ]);

        $this->get(route('checkout.success', $transaction->order_id))
            ->assertOk()
            ->assertSee('Terima Kasih!');

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'success',
        ]);
    }
}
