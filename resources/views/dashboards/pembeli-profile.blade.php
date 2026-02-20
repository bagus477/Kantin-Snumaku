<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Kantin Digital</title>
    <link rel="stylesheet" href="{{ asset('css/buyer-dashboard.css') }}">
</head>
<body>
<div class="page">
    <header class="navbar">
        <div class="navbar-logo">Kantin Digital</div>
        <nav class="navbar-menu">
            <a href="{{ route('pembeli.dashboard') }}">Home</a>
            <a href="{{ route('pembeli.menu') }}">Menu</a>
            <a href="#" class="active">Profile</a>
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

    <main class="content" style="padding-top: 32px;">
        <section style="max-width: 720px; margin: 0 auto; text-align: center;">
            <div style="width: 140px; height: 140px; border-radius: 999px; background:#e5e5e5; margin: 16px auto 12px;"></div>
            <h2 style="font-size: 1.4rem; font-weight: 600; margin-bottom: 32px;">
                {{ auth()->user()->name ?? 'User' }}
            </h2>

            <div style="text-align:left; margin-top: 32px;">
                {{-- Alamat Email --}}
                <div style="padding-bottom: 8px; border-bottom: 1px solid #d4d4d4; margin-bottom: 16px;">
                    <div style="font-weight: 600; margin-bottom: 4px;">Alamat Email</div>
                    <div>{{ auth()->user()->email ?? '-' }}</div>
                    <div style="font-size: 0.8rem; color:#6b7280; margin-top: 4px;">*Alamat email tidak dapat diubah</div>
                </div>

                {{-- Username --}}
                <div style="padding-top: 4px; padding-bottom: 8px; border-bottom: 1px solid #d4d4d4;">
                    <div style="font-weight: 600; margin-bottom: 4px;">UserName</div>
                    <div>{{ auth()->user()->name ?? '-' }}</div>
                </div>
            </div>
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
