<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Digital - Pesanan Saya</title>
    <link rel="stylesheet" href="{{ asset('css/buyer-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pembeli-menu.css') }}">
</head>
<body>
    <div class="page">
        <header class="navbar">
            <div class="navbar-logo">Kantin Digital</div>
            <nav class="navbar-menu">
                <a href="{{ route('pembeli.dashboard') }}">Home</a>
                <a href="{{ route('pembeli.menu') }}">Menu</a>
                <a href="{{ route('pembeli.profile') }}">Profile</a>
            </nav>
            <div class="navbar-icons" style="position:relative;">
                <a href="{{ route('pembeli.pembayaran') }}" class="cart-icon" style="cursor:pointer; text-decoration:none; color:inherit;">
                    <img src="{{ asset('assets/icons/cart-white.svg') }}" alt="Cart" style="width:18px; height:18px;">
                    <span id="cart-count" style="font-size:0.8rem; font-weight:600; color:#fff;">0</span>
                </a>
                <div class="user-menu" style="position:relative;">
                    <div class="user-avatar" id="user-menu-toggle" style="cursor:pointer;">{{ substr(auth()->user()->name ?? 'P', 0, 1) }}</div>
                    <div id="user-menu-dropdown" style="display:none; position:absolute; right:0; margin-top:8px; background:#ffffff; border-radius:0.5rem; box-shadow:0 4px 10px rgba(0,0,0,0.12); overflow:hidden; min-width:150px; z-index:20;">
                        <a href="{{ route('pembeli.pesanan') }}" style="display:block; padding:0.6rem 0.9rem; font-size:0.9rem; color:#111827; text-decoration:none;">Pesanan Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="width:100%; border:none; background:#fef2f2; color:#b91c1c; padding:0.6rem 0.9rem; font-size:0.9rem; text-align:left; cursor:pointer;">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            <section class="menu-page">
                <div class="kantin-header">
                    <img src="{{ asset('assets/images/mamigibtar.jpg') }}" alt="Kantin Mamah Giblar" class="kantin-logo-placeholder">
                    <div class="kantin-name">Kantin Mamah Giblar</div>
                </div>

                <h2 class="section-heading">Pesanan Saya</h2>
                <p>Berikut daftar seluruh pesanan Anda:</p>

                @if($orders->isEmpty())
                    <p style="margin-top:16px;">Belum ada pesanan yang tercatat.</p>
                @else
                    <div class="menu-row">
                        @foreach($orders as $order)
                            <article class="menu-card">
                                <div class="menu-card-body">
                                    <div class="menu-card-title">{{ $order->menu_name }}</div>
                                    <div class="menu-card-desc">
                                        Qty: {{ $order->qty }} &middot;
                                        Metode: {{ strtoupper($order->payment_method) }}
                                    </div>
                                    <div class="menu-card-bottom">
                                        <span class="menu-card-price">
                                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                        </span>
                                        <div style="text-align:right; font-size:0.85rem;">
                                            <div style="font-weight:600; color:#f97316;">
                                                status pesanan: {{ $order->status }}
                                            </div>
                                            <div style="color:#4b5563;">
                                                status pembayaran:
                                                @if($order->payment_method === 'qris')
                                                    selesai
                                                @else
                                                    menunggu kasir
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>

        @include('dashboards.partials.footer-pembeli')
    </div>

    <script>
        (function() {
            const cartEl = document.getElementById('cart-count');
            const saved = Number(window.localStorage.getItem('cartCount') || 0) || 0;
            if (cartEl) {
                cartEl.textContent = String(saved);
            }

            const userMenuToggle = document.getElementById('user-menu-toggle');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');

            if (userMenuToggle && userMenuDropdown) {
                userMenuToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isShown = userMenuDropdown.style.display === 'block';
                    userMenuDropdown.style.display = isShown ? 'none' : 'block';
                });

                document.addEventListener('click', (e) => {
                    if (!userMenuDropdown.contains(e.target) && e.target !== userMenuToggle) {
                        userMenuDropdown.style.display = 'none';
                    }
                });
            }
        })();
    </script>

</body>
</html>
