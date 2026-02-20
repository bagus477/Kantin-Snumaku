<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Kantin Digital</title>
    <link rel="stylesheet" href="{{ asset('css/buyer-dashboard.css') }}">
</head>
<body>
<div class="page">
    <header class="navbar">
        <div class="navbar-logo">Kantin Digital</div>
        <nav class="navbar-menu">
            <a href="{{ route('penjual.pesanan') }}">Pesanan ({{ $ordersCount ?? 0 }})</a>
            <a href="{{ route('penjual.terjadwal') }}">Terjadwal</a>
            <a href="#" class="active">Detail Pesanan</a>
            <a href="{{ route('penjual.dashboard') }}">Profile</a>
        </nav>
        <div class="navbar-icons" style="display:flex; align-items:center; gap:8px;">
            <div class="user-avatar">{{ substr(auth()->user()->name ?? 'P', 0, 1) }}</div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" style="padding:4px 10px; border-radius:999px; border:1px solid #d4d4d4; background:#ffffff; font-size:0.8rem; cursor:pointer;">Logout</button>
            </form>
        </div>
    </header>

    <main class="content" style="padding: 24px 0 40px;">
        <section style="max-width: 900px; margin: 0 auto;">
            {{-- Status terjadwal di atas --}}
            <article style="border:1px solid #d4d4d4; border-radius: 12px; padding: 14px 18px; margin-bottom: 16px; background:#ffffff;">
                <div style="margin-bottom:8px;">
                    <span style="display:inline-block; padding:4px 12px; border-radius:999px; background:#bbf7d0; color:#166534; font-size:0.8rem; font-weight:600; text-transform:lowercase;">terjadwal</span>
                </div>
                <div style="display:flex; align-items:center; gap:6px; font-size:0.85rem; color:#4b5563; margin-top:4px;">
                    <span style="display:inline-flex; width:16px; height:16px; border-radius:999px; border:2px solid #4b5563; align-items:center; justify-content:center; font-size:0.6rem;">🕒</span>
                    <span>Akan dijemput hari ini Pukul</span>
                    <span style="padding:2px 8px; border-radius:999px; background:#e5e7eb; font-size:0.8rem; color:#111827;">{{ optional($order->updated_at)->addMinutes(10)->format('H.i') }} WIB</span>
                </div>
                <ul style="margin-top:8px; padding-left:1.1rem; font-size:0.8rem; color:#4b5563;">
                    <li>Usahakan pesanan siap sesuai jadwal agar pelanggan puas</li>
                </ul>
            </article>

            {{-- Info pemesan --}}
            <article style="border:1px solid #d4d4d4; border-radius: 12px; padding: 14px 18px; margin-bottom: 16px; background:#ffffff; font-size:0.95rem;">
                <div style="color:#6b7280; margin-bottom:4px;">Dipesan oleh</div>
                <div style="font-weight:600;">{{ $order->user->name ?? 'Pembeli' }}</div>
            </article>

            {{-- Rincian menu --}}
            <article style="border:1px solid #d4d4d4; border-radius: 12px; padding: 16px 18px; margin-bottom: 24px; background:#ffffff;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                    <div>
                        <div style="font-weight:600;">{{ $order->qty }}x &nbsp; {{ $order->menu_name }}</div>
                        
                    </div>
                    <div style="font-weight:600;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                </div>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:10px 0;">

                <div style="font-size:0.9rem; color:#4b5563;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span>Biaya bungkus</span>
                        <span>Rp0</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span>Subtotal ({{ $order->qty }} item)</span>
                        <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-weight:600; margin-top:6px;">
                        <span>Harga total</span>
                        <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </article>

            {{-- Tombol Pesanan siap (menandai pesanan selesai) --}}
            <article style="border:1px solid #d4d4d4; border-radius: 12px; padding: 16px 18px; margin-bottom: 24px; background:#ffffff; text-align:center;">
                <form method="POST" action="{{ route('penjual.pesanan.updateStatus') }}" style="margin:0;">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" style="min-width:180px; padding:10px 0; border-radius:999px; border:none; background:#16a34a; color:#ffffff; font-weight:600; cursor:pointer;">Pesanan siap</button>
                </form>
            </article>
        </section>
    </main>

    @include('dashboards.partials.footer-pembeli')
</div>

@if(session('order_status_popup'))
    <script>
        (function () {
            var status = @json(session('order_status_popup'));
            if (status === 'selesai') {
                alert('Pesanan telah selesai. Silakan serahkan ke pembeli sesuai jadwal.');
            }
        })();
    </script>
@endif

</body>
</html>
