<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-indigo-600 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full mx-auto" style="max-width: 500px;">
        <!-- Success Banner -->
        <div class="text-center mb-8" style="text-align: center; margin-bottom: 2rem;">
            <h1 class="text-3xl font-black" style="font-size: 1.8rem; font-weight: 900; margin-bottom: 0.5rem;">Pembayaran Berhasil!</h1>
            <p class="text-indigo-100 mt-2" style="color: #e0e7ff;">Tiket Anda telah terbit dan siap digunakan.</p>
        </div>

        <!-- Ticket Card -->
        <div class="bg-white text-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl relative" style="background: white; border-radius: 2.5rem; color: #0f172a;">
            <!-- Ticket Header -->
            <div class="p-8 bg-indigo-50 border-b-4 border-dashed border-indigo-100 text-center relative" style="padding: 2rem; background: #eef2ff; border-bottom: 4px dashed #c7d2fe; text-align: center;">
                <p class="text-indigo-600 font-bold uppercase tracking-widest text-xs mb-2" style="color: #4f46e5; font-weight: bold; letter-spacing: 0.1em; font-size: 0.75rem;">E-Ticket Resmi</p>
                <h2 class="text-2xl font-black leading-tight" style="font-size: 1.5rem; font-weight: 900;">{{ $transaction->event->title }}</h2>
            </div>

            <!-- Ticket Body -->
            <div class="p-8 space-y-8" style="padding: 2rem;">
                <div class="grid grid-cols-2 gap-6" style="display: flex; justify-content: space-between; flex-wrap: wrap; margin-bottom: 2rem;">
                    <div style="width: 45%; margin-bottom: 1rem;">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1" style="color: #94a3b8; font-size: 0.75rem; font-weight: bold;">Nama Pembeli</p>
                        <p class="font-bold text-lg" style="font-weight: bold; font-size: 1.125rem;">{{ $transaction->customer_name }}</p>
                    </div>
                    <div style="width: 45%; margin-bottom: 1rem;">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1" style="color: #94a3b8; font-size: 0.75rem; font-weight: bold;">Tanggal & Waktu</p>
                        <p class="font-bold text-lg" style="font-weight: bold; font-size: 1.125rem;">{{ $transaction->event->date->format('d M y, H:i') }}</p>
                    </div>
                    <div style="width: 45%; margin-bottom: 1rem;">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1" style="color: #94a3b8; font-size: 0.75rem; font-weight: bold;">Order ID</p>
                        <p class="font-bold" style="font-weight: bold;">{{ $transaction->order_id }}</p>
                    </div>
                    <div style="width: 45%; margin-bottom: 1rem;">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1" style="color: #94a3b8; font-size: 0.75rem; font-weight: bold;">Lokasi</p>
                        <p class="font-bold" style="font-weight: bold;">{{ $transaction->event->location }}</p>
                    </div>
                </div>

                <div class="bg-slate-100 p-6 rounded-3xl flex flex-col items-center" style="background: #f1f5f9; padding: 1.5rem; border-radius: 1.5rem; text-align: center;">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-4" style="color: #94a3b8; font-size: 0.75rem; font-weight: bold;">Simpan QR/KODE ini</p>
                    <div class="w-48 h-48 bg-white p-4 rounded-xl shadow-inner flex items-center justify-center cursor-pointer" style="background: white; padding: 1rem; border-radius: 0.75rem; width: 200px; margin: 0 auto; min-height: 200px;">
                        <!-- QR Code PlaceHolder -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $transaction->order_id }}" alt="QR Code" style="width: 100%; height: auto;">
                    </div>
                </div>
            </div>

            <div class="px-8 pb-8" style="padding: 0 2rem 2rem 2rem;">
                <p class="text-center mt-4 text-slate-500 font-bold" style="text-align: center; color: #64748b; font-weight: bold;">Silakan tunjukkan tiket ini pada saat memasuki area event.</p>
            </div>
        </div>
    </div>

</body>
</html>
