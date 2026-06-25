# AmikomEventHub - Pertemuan 10

Implementasi latihan/tugas modul **PERTEMUAN 10 - Checkout Logic & Transaksi** untuk aplikasi Laravel AmikomEventHub.

## Implementasi Plan

1. Menyiapkan model transaksi
   - Menambahkan `$fillable` pada `App\Models\Transaction` agar `Transaction::create()` dapat menyimpan data checkout.
   - Menambahkan relasi `event()` agar laporan admin bisa menampilkan judul event dari setiap transaksi.

2. Membuat alur guest checkout
   - Route `GET /checkout/{event}` menampilkan form checkout untuk tamu.
   - Route `POST /checkout/{event}` memvalidasi nama, email, dan nomor WhatsApp.
   - Sistem menolak checkout jika `stock` event bernilai `0` atau kurang.
   - Sistem membuat `order_id` unik dengan format `TRX-{timestamp}-{random}`.
   - Sistem menyimpan transaksi dengan status awal `Pending`.

3. Menghitung total pembayaran dummy
   - Harga tiket diambil dari `events.price`.
   - Biaya layanan tetap ditambahkan sebesar `Rp 5.000`.
   - Total transaksi disimpan pada kolom `total_price`.

4. Menyiapkan laporan transaksi admin
   - Route admin `GET /admin/transactions` mengambil transaksi terbaru dengan eager loading relasi `event`.
   - View admin menampilkan Order ID, detail pembeli, event, tanggal transaksi, status, dan total tagihan.
   - UI tabel ditingkatkan dengan kartu ringkasan total transaksi, transaksi pending, dan omzet pada halaman aktif.

5. Menambahkan dokumentasi dan verifikasi
   - README ini menjelaskan detail pengerjaan.
   - Feature test ditambahkan untuk membuktikan checkout berhasil dan checkout stok habis ditolak.

## File Utama

- `app/Models/Transaction.php`
- `app/Http/Controllers/CheckoutController.php`
- `app/Http/Controllers/Admin/TransactionController.php`
- `resources/views/checkout/create.blade.php`
- `resources/views/admin/transactions/index.blade.php`
- `resources/views/layouts/app.blade.php`
- `routes/web.php`
- `tests/Feature/CheckoutTest.php`

## Alur Penggunaan Manual

1. Jalankan migrasi dan seeder jika database belum siap:

```bash
php artisan migrate:fresh --seed
```

2. Jalankan server lokal:

```bash
php artisan serve
```

3. Buka halaman event, pilih salah satu event, lalu klik tombol pembelian menuju checkout.
4. Isi form checkout:
   - Nama lengkap
   - Email aktif
   - Nomor WhatsApp
5. Klik **Simpan Pesanan**.
6. Jika stok masih tersedia, sistem mencatat transaksi dan menampilkan pesan sukses di beranda.
7. Login admin melalui `/admin/login`, lalu buka menu **Laporan Transaksi**.
8. Pastikan data dummy muncul dengan total `harga tiket + Rp 5.000`.

## Kredensial Admin Seeder

```text
Email: admin@amikom.ac.id
Password: password
```

## Route Terkait

```php
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});
```

## Verifikasi Otomatis

Jalankan:

```bash
php artisan test --filter=CheckoutTest
```

Yang diverifikasi:

- Guest checkout valid membuat transaksi `Pending`.
- `total_price` berisi harga tiket ditambah biaya layanan `Rp 5.000`.
- `order_id` diawali `TRX-`.
- Checkout event dengan stok habis ditolak dan tidak membuat transaksi.

## Catatan

Fokus pengerjaan ini adalah Pertemuan 10, sehingga checkout disimpan sebagai transaksi dummy dan belum memakai payment gateway. Integrasi Midtrans masuk ke materi Pertemuan 11.
