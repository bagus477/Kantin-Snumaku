<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual - Kantin Digital</title>
    <link rel="stylesheet" href="{{ asset('css/buyer-dashboard.css') }}">
</head>
<body>
<div class="page">
    <header class="navbar">
        <div class="navbar-logo">Kantin Digital</div>
        <nav class="navbar-menu">
            <a href="{{ route('penjual.pesanan') }}">Pesanan ({{ $ordersCount ?? 0 }})</a>
            <a href="{{ route('penjual.terjadwal') }}" class="{{ ($activeTab ?? '') === 'terjadwal' ? 'active' : '' }}">Terjadwal</a>
            @if(!empty($latestReadyOrder))
                <a href="{{ route('penjual.pesanan.detail', $latestReadyOrder->id) }}">Detail Pesanan</a>
            @else
                <a href="#" style="opacity:0.6; cursor: default;">Detail Pesanan</a>
            @endif
            <a href="{{ route('penjual.dashboard') }}" class="active">Profile</a>
        </nav>
        <div class="navbar-icons" style="display:flex; align-items:center; gap:8px;">
            <div class="user-avatar">{{ substr(auth()->user()->name ?? 'P', 0, 1) }}</div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" style="padding:4px 10px; border-radius:999px; border:1px solid #d4d4d4; background:#ffffff; font-size:0.8rem; cursor:pointer;">Logout</button>
            </form>
        </div>
    </header>

    <main class="content" style="padding-top: 32px;">
        <section style="max-width: 720px; margin: 0 auto; text-align: center;">
            <img src="{{ asset('assets/images/mamigibtar.jpg') }}" alt="Kantin Mamah Giblar" style="width: 140px; height: 140px; border-radius: 999px; object-fit: cover; margin: 16px auto 12px;">
            <h2 style="font-size: 1.4rem; font-weight: 600; margin-bottom: 32px;">
                Kantin mama Gibtar
            </h2>

            <div style="text-align:left; margin-top: 16px;">
                <div style="margin-bottom: 18px;">
                    <div style="font-weight: 600; margin-bottom: 6px;">Lokasi</div>
                    <input type="text" value="SMK NU MAARIF KUDUS, JAWA TENGAH" readonly
                           style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #d4d4d4; font-size: 0.95rem;">
                </div>

                <div style="margin-bottom: 24px;">
                    <div style="font-weight: 600; margin-bottom: 6px;">Tanggal bergabung</div>
                    <input type="text" value="19 Mei 2021" readonly
                           style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #d4d4d4; font-size: 0.95rem;">
                </div>

                <div style="margin-top: 24px; text-align: center;">
                    <button type="button" style="border-radius: 999px; padding: 10px 24px; border: 1px solid #d4d4d4; background:#ffffff; cursor: default;">
                        Skor performa resto
                        <span style="display:block; font-weight: 600; color:#16a34a; margin-top: 4px;">95/100</span>
                    </button>
                </div>
            </div>
        </section>
    </main>

    @include('dashboards.partials.footer-pembeli')
</div>

</body>
</html>
