<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Kantin Digital</title>
    <link rel="stylesheet" href="{{ asset('css/buyer-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pembeli-pembayaran.css') }}">
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

@php
    $menuName = request('menu', 'Nasi Chiken Katsu');
    $qty = (int) request('qty', 1);
    $base = (int) request('base', 8000);
    $extra = (int) request('extra', 0);
    $total = (int) request('total', $base + $extra);

    $baseFormatted = number_format($base, 0, ',', '.');
    $extraFormatted = number_format($extra, 0, ',', '.');
    $totalFormatted = number_format($total, 0, ',', '.');
@endphp

    <main class="content">
    <section class="pay-main">
    <h1 class="pay-title">Pembayaran</h1>

    <section class="pay-card">
        <div class="pay-card-header">Ringkasan Pesanan</div>
        <div class="pay-summary-row">
            <div class="pay-summary-left">
                <span class="qty" id="summary-qty">- {{ $qty }}</span>
                <div class="item-info">
                    <img src="{{ asset('assets/images/menu/nasi-chicken-katsu.jpg') }}" alt="Gambar menu" class="item-image">
                    <span class="item-name" id="summary-menu-name">{{ $menuName }}</span>
                </div>
            </div>
            <div class="pay-summary-price" id="summary-total">{{ $totalFormatted }}</div>
        </div>
        <div class="pay-subtotal-row">
            <span>Harga menu</span>
            <span id="summary-base">Rp.{{ $baseFormatted }}</span>
        </div>
        <div class="pay-subtotal-row">
            <span>Tambahan</span>
            <span id="summary-extra">Rp.{{ $extraFormatted }}</span>
        </div>
        <div class="pay-subtotal-row">
            <span>subtotal (termasuk pajak)</span>
            <span id="summary-subtotal">Rp.{{ $totalFormatted }}</span>
        </div>
    </section>

    <section class="pay-card">
        <div class="pay-card-header">Rincian pembayaran</div>
        <div class="pay-method-row js-method" data-method="kasir">
            <div class="pay-method-icon circle-icon">
                <img src="{{ asset('assets/images/kasir.png') }}" alt="Bayar di kasir" class="pay-method-img">
            </div>
            <div class="pay-method-label">Bayar di kasir</div>
        </div>
        <div class="pay-method-row js-method" data-method="qris">
            <div class="pay-method-icon qris-icon">
                <img src="{{ asset('assets/images/qrisl.jpg') }}" alt="Qris" class="pay-method-img">
            </div>
            <div class="pay-method-label">Qris</div>
        </div>
        <div class="pay-method-row">
           <div class="pay-method-icon qris-icon">
                <img src="{{ asset('assets/images/user.jpg') }}" alt="Qris" class="pay-method-img">
            </div>
            <input type="text" class="pay-input" placeholder="nama" value="{{ auth()->user()->name ?? '' }}">
        </div>
    </section>

    {{-- Bar total harga + tombol lanjut pembayaran (tepat di bawah form) --}}
    <div class="pay-footer">
        <div class="pay-footer-inner">
            <div class="pay-total">
                <div class="pay-total-label">Total Harga</div>
                <div class="pay-total-value">Rp.{{ $totalFormatted }}</div>
            </div>
            <button class="pay-submit-btn" id="pay-submit-btn" type="button">lanjut pembayaran</button>
            <a href="{{ route('pembeli.menu') }}" id="go-to-menu-btn" style="display:none; margin-left:12px; padding:0.75rem 1.5rem; border-radius:0.5rem; background:#10b981; color:#ffffff; font-weight:600; font-size:0.9rem; text-decoration:none; white-space:nowrap; box-shadow:0 2px 4px rgba(0,0,0,0.08); transition:background-color 0.15s ease, transform 0.15s ease;">Pesan Menu</a>
        </div>
    </div>
    </main>

    @include('dashboards.partials.footer-pembeli')

    {{-- Overlay untuk QRIS dan status pembayaran --}}
    <div class="pay-overlay" id="pay-overlay" style="display:none;">
    <div class="pay-overlay-inner" id="overlay-qris">
        <img src="{{ asset('assets/images/qris.jpg') }}" alt="QRIS" class="qris-image">
        <p id="qris-countdown" style="margin-top: 16px; text-align:center; color:#111827; font-weight:600; font-size: 1rem;">
            Sisa waktu: 02:00
        </p>
    </div>

    <div class="pay-overlay-inner" id="overlay-success" style="display:none;">
        <div class="pay-success-card">
            <div class="pay-success-icon">✓</div>
            <h2 class="pay-success-title">Pembayaran berhasil</h2>
            <p class="pay-success-text">pesanan anda sedang diproses, mohon tunggu</p>
            <p class="pay-success-thanks">Terimakasih</p>
            <p class="pay-success-note">*otomatis kembali ke beranda setelah 5 detik</p>
        </div>
    </div>

    <div class="pay-overlay-inner" id="overlay-detail" style="display:none;">
        <div class="pay-detail-card">
            <div class="pay-detail-header">
                <img src="{{ asset('assets/images/mamigibtar.jpg') }}" alt="Kantin Mamah Giblar" class="pay-detail-shop-icon">
                <div class="pay-detail-shop-name">kantin mama gibtar, smk nu ma'arif</div>
            </div>
            <h3 class="pay-detail-title">Rincian transaksi</h3>
            <div class="pay-detail-row">
                <span>metode pembayaran</span>
                <span id="detail-method">Qris</span>
            </div>
            <div class="pay-detail-row">
                <span>status</span>
                <span>menunggu</span>
            </div>
            <div class="pay-detail-row">
                <span>waktu</span>
                <span>10.00</span>
            </div>
            <div class="pay-detail-row">
                <span>tanggal</span>
                <span>4 feb 2026</span>
            </div>
            <div class="pay-detail-row">
                <span>location</span>
                <span>Kudus</span>
            </div>
            <div class="pay-detail-row">
                <span>ID transaksi</span>
                <span id="detail-order-id">-</span>
            </div>
            <div class="pay-detail-row">
                <span>jumlah</span>
                <span>{{ $totalFormatted }}</span>
            </div>
            <div class="pay-detail-total-row">
                <span>Total</span>
                <span>{{ $totalFormatted }}</span>
            </div>
            <button type="button" class="pay-detail-close" id="detail-close-btn">Keluar</button>
        </div>
    </div>
</div>
</div>

<script>
    const orderData = {
        user_id: {{ auth()->id() ?? 'null' }},
        menu_name: @json($menuName),
        qty: {{ $qty }},
        base_amount: {{ $base }},
        extra_amount: {{ $extra }},
        total_amount: {{ $total }},
    };
    const storeOrderUrl = "{{ route('pembeli.pembayaran.store') }}";
    const updateStatusUrl = "{{ route('pembeli.pembayaran.updateStatus') }}";
    const csrfToken = "{{ csrf_token() }}";

    const methodRows = document.querySelectorAll('.js-method');
    // Tidak ada metode terpilih di awal, user wajib klik salah satu
    let selectedMethod = null;

    methodRows.forEach(row => {
        row.addEventListener('click', () => {
            methodRows.forEach(r => r.classList.remove('active'));
            row.classList.add('active');
            selectedMethod = row.dataset.method;
        });
    });

    const payBtn = document.getElementById('pay-submit-btn');
    const overlay = document.getElementById('pay-overlay');
    const overlayQris = document.getElementById('overlay-qris');
    const overlaySuccess = document.getElementById('overlay-success');
    const overlayDetail = document.getElementById('overlay-detail');
    const detailMethod = document.getElementById('detail-method');
    const detailOrderIdEl = document.getElementById('detail-order-id');
    const detailCloseBtn = document.getElementById('detail-close-btn');
    const qrisCountdownEl = document.getElementById('qris-countdown');

    function showOverlay(section) {
        overlay.style.display = 'flex';
        overlayQris.style.display = 'none';
        overlaySuccess.style.display = 'none';
        overlayDetail.style.display = 'none';

        if (section === 'qris') overlayQris.style.display = 'block';
        if (section === 'success') overlaySuccess.style.display = 'block';
        if (section === 'detail') overlayDetail.style.display = 'block';
    }

    function clearCart() {
        try {
            window.localStorage.removeItem('cartCount');
        } catch (e) {}

        const cartEl = document.getElementById('cart-count');
        if (cartEl) {
            cartEl.textContent = '0';
        }
    }

    let currentOrderId = null;

    async function saveOrder() {
        try {
            const payload = {
                ...orderData,
                payment_method: selectedMethod,
            };

            const response = await fetch(storeOrderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload),
            });

            if (response.ok) {
                const data = await response.json();
                currentOrderId = data.order_id ?? null;

                if (detailOrderIdEl && currentOrderId) {
                    detailOrderIdEl.textContent = currentOrderId;
                }
            }
        } catch (e) {
            console.error('Gagal menyimpan order', e);
        }
    }

    async function updateOrderStatus(status) {
        if (!currentOrderId) return;
        try {
            await fetch(updateStatusUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    order_id: currentOrderId,
                    status: status,
                }),
            });
        } catch (e) {
            console.error('Gagal update status order', e);
        }
    }

    payBtn.addEventListener('click', async () => {
        // Wajib pilih metode pembayaran dulu
        if (!selectedMethod) {
            alert('Silakan pilih metode pembayaran terlebih dahulu (Bayar di kasir atau QRIS).');
            return;
        }

        // Simpan pesanan ke database (async)
        await saveOrder();

        if (selectedMethod === 'qris') {
            // Tampilkan QRIS dulu
            showOverlay('qris');

            // Countdown 2 menit
            let remainingSeconds = 60;
            if (qrisCountdownEl) {
                const updateCountdownText = () => {
                    const minutes = String(Math.floor(remainingSeconds / 60)).padStart(2, '0');
                    const seconds = String(remainingSeconds % 60).padStart(2, '0');
                    qrisCountdownEl.textContent = `Sisa waktu: ${minutes}:${seconds}`;
                };

                updateCountdownText();

                const countdownInterval = setInterval(async () => {
                    remainingSeconds--;
                    if (remainingSeconds <= 0) {
                        clearInterval(countdownInterval);

                        // Setelah waktu habis, anggap pembayaran menunggu konfirmasi
                        clearCart();
                        await updateOrderStatus('menunggu');

                        showOverlay('success');

                        setTimeout(() => {
                            detailMethod.textContent = 'Qris';
                            showOverlay('detail');
                        }, 2000);

                        return;
                    }

                    updateCountdownText();
                }, 1000);
            }
        } else {
            // Bayar di kasir: langsung kosongkan cart dan tampilkan pesan menunggu konfirmasi kasir
            clearCart();
            detailMethod.textContent = 'Bayar di kasir (menunggu konfirmasi kasir)';
            showOverlay('detail');
        }
    });

    detailCloseBtn.addEventListener('click', () => {
        // Fallback: pastikan keranjang tetap kosong
        clearCart();
        overlay.style.display = 'none';
        window.location.href = "{{ route('pembeli.pesanan') }}";
    });
</script>

<script>
    (function() {
        const cartEl = document.getElementById('cart-count');
        const saved = Number(window.localStorage.getItem('cartCount') || 0) || 0;

        if (cartEl) {
            cartEl.textContent = String(saved);
        }

        // Jika tidak ada item di keranjang, tetap di halaman pembayaran
        // tetapi tampilkan state kosong (tanpa ringkasan pesanan dan tombol bayar nonaktif).
        if (!saved || saved <= 0) {
            const qtyEl = document.getElementById('summary-qty');
            const nameEl = document.getElementById('summary-menu-name');
            const baseEl = document.getElementById('summary-base');
            const extraEl = document.getElementById('summary-extra');
            const subtotalEl = document.getElementById('summary-subtotal');
            const totalEl = document.getElementById('summary-total');
            const payBtn = document.getElementById('pay-submit-btn');
            const goToMenuBtn = document.getElementById('go-to-menu-btn');

            if (qtyEl) qtyEl.textContent = '- 0';
            if (nameEl) nameEl.textContent = 'Belum ada pesanan';
            if (baseEl) baseEl.textContent = 'Rp.0';
            if (extraEl) extraEl.textContent = 'Rp.0';
            if (subtotalEl) subtotalEl.textContent = 'Rp.0';
            if (totalEl) totalEl.textContent = 'Rp.0';

            if (payBtn) {
                payBtn.disabled = true;
                payBtn.textContent = 'Belum ada pesanan';
                payBtn.style.opacity = '0.7';
                payBtn.style.cursor = 'not-allowed';
            }

            if (goToMenuBtn) {
                goToMenuBtn.style.display = 'inline-block';
            }
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
    })();
</script>

</body>
</html>
