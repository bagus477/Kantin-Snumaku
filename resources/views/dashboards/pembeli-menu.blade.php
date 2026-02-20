<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Digital - Menu Pembeli</title>
    <link rel="stylesheet" href="{{ asset('css/buyer-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pembeli-menu.css') }}">
</head>
<body>
    <div class="page">
        <header class="navbar">
            <div class="navbar-logo">Kantin Digital</div>
            <nav class="navbar-menu">
                <a href="{{ route('pembeli.dashboard') }}">Home</a>
                <a href="#" class="active">Menu</a>
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

                <h2 class="section-heading">Terlaris</h2>
                <div class="menu-row">
                    @foreach ($terlaris as $menu)
                        <article class="menu-card">
                            <div class="menu-card-body">
                                <div class="menu-card-title">{{ $menu->name }}</div>
                                @if ($menu->description)
                                    <div class="menu-card-desc">{{ $menu->description }}</div>
                                @endif
                                <div class="menu-card-bottom">
                                    <span class="menu-card-price">{{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="menu-card-side">
                                <div class="menu-card-image" style="background-image: url('{{ asset('assets/images/menu/' . $menu->image) }}');"></div>
                                <button class="menu-card-add" data-menu-id="{{ $menu->id }}">Add</button>
                            </div>
                        </article>
                    @endforeach
                </div>

                <h2 class="section-heading">Aneka Nasi</h2>
                <div class="menu-row">
                    @foreach ($anekaNasi as $menu)
                        <article class="menu-card">
                            <div class="menu-card-body">
                                <div class="menu-card-title">{{ $menu->name }}</div>
                                @if ($menu->description)
                                    <div class="menu-card-desc">{{ $menu->description }}</div>
                                @endif
                                <div class="menu-card-bottom">
                                    <span class="menu-card-price">{{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="menu-card-side">
                                <div class="menu-card-image" style="background-image: url('{{ asset('assets/images/menu/' . $menu->image) }}');"></div>
                                <button class="menu-card-add" data-menu-id="{{ $menu->id }}">Add</button>
                            </div>
                        </article>
                    @endforeach
                </div>

                <h2 class="section-heading">Aneka Mie</h2>
                <div class="menu-row">
                    @foreach ($anekaMie as $menu)
                        <article class="menu-card">
                            <div class="menu-card-body">
                                <div class="menu-card-title">{{ $menu->name }}</div>
                                @if ($menu->description)
                                    <div class="menu-card-desc">{{ $menu->description }}</div>
                                @endif
                                <div class="menu-card-bottom">
                                    <span class="menu-card-price">{{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="menu-card-side">
                                <div class="menu-card-image" style="background-image: url('{{ asset('assets/images/menu/' . $menu->image) }}');"></div>
                                <button class="menu-card-add" data-menu-id="{{ $menu->id }}">Add</button>
                            </div>
                        </article>
                    @endforeach
                </div>

                <h2 class="section-heading">Aneka Cemilan</h2>
                <div class="menu-row">
                    @foreach ($anekaCemilan as $menu)
                        <article class="menu-card">
                            <div class="menu-card-body">
                                <div class="menu-card-title">{{ $menu->name }}</div>
                                @if ($menu->description)
                                    <div class="menu-card-desc">{{ $menu->description }}</div>
                                @endif
                                <div class="menu-card-bottom">
                                    <span class="menu-card-price">{{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="menu-card-side">
                                <div class="menu-card-image" style="background-image: url('{{ asset('assets/images/menu/' . $menu->image) }}');"></div>
                                <button class="menu-card-add" data-menu-id="{{ $menu->id }}">Add</button>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </main>

        @include('dashboards.partials.footer-pembeli')

        {{-- Modal detail menu --}}
        <div id="menu-modal-backdrop" class="menu-modal-backdrop" style="display: none;">
            <div class="menu-modal">
                <div class="menu-modal-header">
                    <h3 id="modal-menu-name"></h3>
                    <button type="button" id="menu-modal-close" class="menu-modal-close">×</button>
                </div>
                <p id="modal-menu-desc" class="menu-modal-desc"></p>
                <div class="menu-modal-price" id="modal-menu-price"></div>

                <div class="menu-modal-section" id="modal-rasa-section" style="display: none;">
                    <div class="menu-modal-section-title">Rasa</div>
                    <div id="modal-rasa-list" class="menu-modal-options"></div>
                </div>

                <div class="menu-modal-section" id="modal-topping-section" style="display: none;">
                    <div class="menu-modal-section-title">Tambahan</div>
                    <div id="modal-topping-list" class="menu-modal-options"></div>
                </div>

                <div class="menu-modal-qty-row">
                    <span class="menu-modal-qty-label">Jumlah</span>
                    <div class="menu-modal-qty-control">
                        <button type="button" class="qty-btn" id="qty-decrease">-</button>
                        <span id="qty-value" class="qty-value">1</span>
                        <button type="button" class="qty-btn" id="qty-increase">+</button>
                    </div>
                </div>

                <button type="button" class="menu-modal-add">Add</button>
            </div>
        </div>
    </div>

    <script>
        const pembayaranUrl = "{{ route('pembeli.pembayaran') }}";
        const allMenus = @json($allMenus);
        const cartCountEl = document.getElementById('cart-count');
        // Ambil nilai awal dari localStorage supaya tidak kembali ke 0 saat pindah halaman
        let cartCount = Number(window.localStorage.getItem('cartCount') || 0) || 0;
        if (cartCountEl) {
            cartCountEl.textContent = String(cartCount);
        }

        // Klik icon cart menuju halaman pembayaran
        const cartIconEl = document.querySelector('.cart-icon');
        if (cartIconEl) {
            cartIconEl.addEventListener('click', () => {
                window.location.href = pembayaranUrl;
            });
        }

        // Dropdown user (Pesanan Saya + Logout)
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
        const menuMap = new Map(allMenus.map(menu => [menu.id, menu]));

        const backdrop = document.getElementById('menu-modal-backdrop');
        const closeBtn = document.getElementById('menu-modal-close');
        const nameEl = document.getElementById('modal-menu-name');
        const descEl = document.getElementById('modal-menu-desc');
        const priceEl = document.getElementById('modal-menu-price');
        const rasaSection = document.getElementById('modal-rasa-section');
        const toppingSection = document.getElementById('modal-topping-section');
        const rasaList = document.getElementById('modal-rasa-list');
        const toppingList = document.getElementById('modal-topping-list');
        const modalAddBtn = document.querySelector('.menu-modal-add');
        const qtyValueEl = document.getElementById('qty-value');
        const qtyDecreaseBtn = document.getElementById('qty-decrease');
        const qtyIncreaseBtn = document.getElementById('qty-increase');
        let currentQty = 1;
        let currentMenuId = null;

        function openMenuModal(menuId) {
            const menu = menuMap.get(Number(menuId));
            if (!menu) return;

            currentMenuId = Number(menuId);

            nameEl.textContent = menu.name;
            descEl.textContent = menu.description || '';
            priceEl.textContent = new Intl.NumberFormat('id-ID').format(menu.price);

            const options = menu.options || [];
            const rasaOptions = options.filter(o => o.type === 'rasa');
            const toppingOptions = options.filter(o => o.type === 'tambahan');

            rasaList.innerHTML = '';
            toppingList.innerHTML = '';

            if (rasaOptions.length) {
                rasaSection.style.display = '';
                rasaOptions.forEach(opt => {
                    const label = document.createElement('label');
                    label.className = 'menu-modal-option-item';
                    label.innerHTML = `<span>${opt.name}</span><input type="checkbox" name="rasa[]" value="${opt.id}">`;
                    rasaList.appendChild(label);
                });
            } else {
                rasaSection.style.display = 'none';
            }

            if (toppingOptions.length) {
                toppingSection.style.display = '';
                toppingOptions.forEach(opt => {
                    const label = document.createElement('label');
                    label.className = 'menu-modal-option-item';

                    let text = opt.name;
                    if (opt.extra_price && Number(opt.extra_price) > 0) {
                        const formatted = new Intl.NumberFormat('id-ID').format(Number(opt.extra_price));
                        text += ` (+Rp ${formatted})`;
                    }

                    label.innerHTML = `<span>${text}</span><input type="checkbox" name="topping[]" value="${opt.id}">`;
                    toppingList.appendChild(label);
                });
            } else {
                toppingSection.style.display = 'none';
            }

            // Reset quantity setiap buka modal
            currentQty = 1;
            if (qtyValueEl) {
                qtyValueEl.textContent = String(currentQty);
            }

            backdrop.style.display = 'flex';
        }

        // Event untuk tombol plus/minus quantity
        if (qtyDecreaseBtn && qtyIncreaseBtn && qtyValueEl) {
            qtyDecreaseBtn.addEventListener('click', () => {
                if (currentQty > 1) {
                    currentQty -= 1;
                    qtyValueEl.textContent = String(currentQty);
                }
            });

            qtyIncreaseBtn.addEventListener('click', () => {
                currentQty += 1;
                qtyValueEl.textContent = String(currentQty);
            });
        }

        // Event tombol Add di dalam modal: hitung total (harga menu + tambahan) * jumlah,
        // update jumlah di icon keranjang, lalu redirect ke halaman pembayaran
        if (modalAddBtn) {
            modalAddBtn.addEventListener('click', () => {
                if (!currentMenuId) {
                    window.location.href = pembayaranUrl;
                    return;
                }

                const menu = menuMap.get(currentMenuId);
                if (!menu) {
                    window.location.href = pembayaranUrl;
                    return;
                }

                const options = menu.options || [];
                const tambahanOptions = options.filter(o => o.type === 'tambahan');

                // Ambil checkbox tambahan yang dipilih
                const checkedTambahanIds = Array.from(
                    document.querySelectorAll('#modal-topping-list input[type="checkbox"]:checked')
                ).map(input => Number(input.value));

                let ekstraPerPorsi = 0;
                checkedTambahanIds.forEach(id => {
                    const opt = tambahanOptions.find(o => Number(o.id) === id);
                    if (opt && opt.extra_price) {
                        ekstraPerPorsi += Number(opt.extra_price);
                    }
                });

                const hargaDasar = Number(menu.price) || 0;
                const qty = Number(currentQty) || 1;
                const totalBase = hargaDasar * qty;
                const totalExtra = ekstraPerPorsi * qty;
                const total = totalBase + totalExtra;

                // Naikkan jumlah item di icon keranjang
                cartCount += qty;
                if (cartCountEl) {
                    cartCountEl.textContent = String(cartCount);
                }

                // Simpan ke localStorage agar tetap terbaca di halaman lain
                window.localStorage.setItem('cartCount', String(cartCount));

                const params = new URLSearchParams();
                params.set('menu', menu.name);
                params.set('qty', String(qty));
                params.set('base', String(totalBase));
                params.set('extra', String(totalExtra));
                params.set('total', String(total));

                window.location.href = `${pembayaranUrl}?${params.toString()}`;
            });
        }

        document.querySelectorAll('.menu-card-add').forEach(btn => {
            btn.addEventListener('click', () => {
                const menuId = btn.dataset.menuId;
                openMenuModal(menuId);
            });
        });

        closeBtn.addEventListener('click', () => {
            backdrop.style.display = 'none';
        });

        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.style.display = 'none';
            }
        });
    </script>
</body>
</html>
