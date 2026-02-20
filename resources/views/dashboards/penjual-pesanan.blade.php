<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - Kantin Digital</title>
    <link rel="stylesheet" href="{{ asset('css/buyer-dashboard.css') }}">
</head>
<body>
<div class="page">
    <header class="navbar">
        <div class="navbar-logo">Kantin Digital</div>
        <nav class="navbar-menu">
            <a href="{{ route('penjual.pesanan') }}" class="{{ ($activeTab ?? 'pesanan') === 'pesanan' ? 'active' : '' }}">
                Pesanan ({{ $ordersCount ?? $orders->count() }})
            </a>
            <a href="{{ route('penjual.terjadwal') }}" class="{{ ($activeTab ?? '') === 'terjadwal' ? 'active' : '' }}">Terjadwal</a>
            @if(!empty($latestReadyOrder))
                <a href="{{ route('penjual.pesanan.detail', $latestReadyOrder->id) }}">Detail Pesanan</a>
            @else
                <a href="#" style="opacity:0.6; cursor: default;">Detail Pesanan</a>
            @endif
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
            @if(($activeTab ?? 'pesanan') === 'terjadwal')
                <h2 style="font-size:1rem; font-weight:600; margin-bottom:12px;">Hari ini ({{ $orders->count() }})</h2>
            @endif

            @forelse($orders as $order)
                @if(($activeTab ?? 'pesanan') === 'terjadwal')
                    {{-- Kartu tampilan untuk tab Terjadwal --}}
                    <article style="border:1px solid #d4d4d4; border-radius: 12px; padding: 14px 18px; margin-bottom: 12px; background:#ffffff;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom: 6px;">
                            <div>
                                <div style="font-weight:600; margin-bottom:4px;">{{ $order->user->name ?? 'Pembeli' }}</div>
                                <span style="display:inline-block; padding:2px 8px; border-radius:999px; background:#bbf7d0; color:#166534; font-size:0.75rem; font-weight:600;">Terjadwal</span>
                            </div>
                            <div style="font-size:0.8rem; color:#111827; white-space:nowrap;">
                                <a href="{{ route('penjual.pesanan.detail', $order->id) }}" style="display:inline-block; padding:6px 14px; border-radius:999px; background:#16a34a; color:#ffffff; text-decoration:none; font-weight:500;">Detail Pesanan</a>
                            </div>
                        </div>

                        <div style="display:flex; align-items:center; gap:6px; font-size:0.85rem; color:#4b5563; margin-top:4px;">
                            <span style="display:inline-flex; width:16px; height:16px; border-radius:999px; border:2px solid #4b5563; align-items:center; justify-content:center; font-size:0.6rem;">🕒</span>
                            <span>Akan dijemput hari ini Pukul</span>
                            <span style="padding:2px 8px; border-radius:999px; background:#e5e7eb; font-size:0.8rem; color:#111827;">{{ optional($order->updated_at)->addMinutes(10)->format('H.i') }} WIB</span>
                        </div>
                    </article>
                @else
                    {{-- Kartu tampilan untuk tab Pesanan --}}
                    <article class="order-card" data-order-id="{{ $order->id }}" style="border:1px solid #d4d4d4; border-radius: 12px; padding: 16px 20px; margin-bottom: 16px; background:#ffffff;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom: 8px;">
                            <div>
                                <div style="font-weight:600;">{{ $order->user->name ?? 'Pembeli' }}</div>
                                <div style="font-size:0.8rem; color:#6b7280;">baru saja · {{ $order->created_at?->format('H.i') }} WIB</div>
                            </div>
                        </div>

                        <div style="border:1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; margin-bottom: 12px; background:#f9fafb;">
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom: 6px;">
                                <span style="font-weight:600;">{{ $order->qty }}x</span>
                                <span>{{ $order->menu_name }}</span>
                            </div>
                            <div style="font-size:0.85rem; color:#6b7280; margin-bottom:2px;">Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            <div style="font-size:0.8rem; color:#6b7280; margin-bottom:4px;">
                                Metode pembayaran:
                                @if($order->payment_method === 'qris')
                                    QRIS
                                @else
                                    Bayar di kasir
                                @endif
                            </div>
                            <div class="order-status-text" style="font-size:0.8rem; color:#4b5563; margin-top:4px;">Status pesanan: {{ $order->status }}</div>
                            @if($order->status === 'ditolak' && !empty($order->alasan_tolak))
                                <div style="font-size:0.8rem; color:#b91c1c; margin-top:2px;">
                                    Alasan ditolak: {{ $order->alasan_tolak }}
                                </div>
                            @endif
                            <div style="font-size:0.8rem; color:#4b5563; margin-top:2px;">
                                Status pembayaran:
                                @if($order->payment_method === 'qris')
                                    Sudah terbayar
                                @else
                                    Menunggu pembayaran
                                @endif
                            </div>
                        </div>

                        @if(in_array($order->status, ['pending', 'menunggu', 'menunggu pembayaran']))
                            <div style="display:flex; justify-content:flex-end; gap:8px;">
                                <form method="POST" action="{{ route('penjual.pesanan.updateStatus') }}" style="margin:0;" class="reject-form">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="status" value="ditolak">
                                    <input type="hidden" name="alasan_tolak" value="">
                                    <button type="button" class="btn-reject" style="min-width:90px; padding:6px 0; border-radius:999px; border:1px solid #d4d4d4; background:#ffffff; cursor:pointer;">Tolak</button>
                                </form>
                                <form method="POST" action="{{ route('penjual.pesanan.updateStatus') }}" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="status" value="diterima">
                                    <input type="hidden" name="redirect_to" value="{{ route('penjual.terjadwal') }}">
                                    <button type="submit" style="min-width:90px; padding:6px 0; border-radius:999px; border:none; background:#16a34a; color:#ffffff; cursor:pointer;">Terima</button>
                                </form>
                            </div>
                        @else
                            <div style="display:flex; justify-content:flex-end; margin-top:4px; font-size:0.85rem; color:#6b7280;">
                                Pesanan sudah {{ $order->status }}
                            </div>
                        @endif
                    </article>
                @endif
            @empty
                <p>Belum ada pesanan.</p>
            @endforelse
        </section>
    </main>

    {{-- Modal alasan menolak pesanan --}}
    <div id="reject-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.3); z-index:40; align-items:center; justify-content:center;">
        <div style="background:#ffffff; border-radius:12px; padding:16px 20px; width:100%; max-width:320px; box-shadow:0 10px 25px rgba(0,0,0,0.18);">
            <h3 style="font-size:1rem; font-weight:600; margin-bottom:12px; text-align:center;">Alasan menolak pesanan</h3>
            <div style="font-size:0.9rem; color:#111827; margin-bottom:10px;">
                <label style="display:flex; align-items:center; gap:8px; margin-bottom:6px; cursor:pointer;">
                    <input type="checkbox" id="reason-menu-habis" value="Menu habis" style="width:14px; height:14px;">
                    <span>Menu habis</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" id="reason-kantin-tutup" value="Kantin akan segera tutup" style="width:14px; height:14px;">
                    <span>Kantin akan segera tutup</span>
                </label>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
                <button type="button" id="reject-cancel" style="min-width:90px; padding:6px 0; border-radius:999px; border:1px solid #d4d4d4; background:#ffffff; cursor:pointer; font-size:0.9rem;">Batal</button>
                <button type="button" id="reject-confirm" style="min-width:110px; padding:6px 0; border-radius:999px; border:none; background:#16a34a; color:#ffffff; cursor:pointer; font-size:0.9rem; font-weight:600;">Lanjutkan</button>
            </div>
        </div>
    </div>

    @include('dashboards.partials.footer-pembeli')
</div>

<script>
    (function () {
        var overlay = document.getElementById('reject-overlay');
        var btnCancel = document.getElementById('reject-cancel');
        var cbMenuHabis = document.getElementById('reason-menu-habis');
        var cbKantinTutup = document.getElementById('reason-kantin-tutup');
        var currentForm = null;

        function openOverlay(form) {
            currentForm = form;
            if (cbMenuHabis) cbMenuHabis.checked = false;
            if (cbKantinTutup) cbKantinTutup.checked = false;
            if (overlay) {
                overlay.style.display = 'flex';
            }
        }

        function closeOverlay() {
            if (overlay) {
                overlay.style.display = 'none';
            }
            currentForm = null;
        }

        document.querySelectorAll('.reject-form .btn-reject').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var form = btn.closest('form');
                if (form) {
                    openOverlay(form);
                }
            });
        });

        if (btnCancel) {
            btnCancel.addEventListener('click', function () {
                closeOverlay();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    closeOverlay();
                }
            });
        }

        // Delegasi event untuk tombol Lanjutkan di dalam overlay,
        // supaya tetap bekerja meskipun elemen dirender ulang.
        document.addEventListener('click', function (e) {
            if (!overlay) return;
            if (e.target && e.target.id === 'reject-confirm') {
                var form = currentForm;
                if (!form) {
                    closeOverlay();
                    return;
                }

                var reasons = [];
                if (cbMenuHabis && cbMenuHabis.checked) {
                    reasons.push(cbMenuHabis.value || 'Menu habis');
                }
                if (cbKantinTutup && cbKantinTutup.checked) {
                    reasons.push(cbKantinTutup.value || 'Kantin akan segera tutup');
                }

                var hidden = form.querySelector('input[name="alasan_tolak"]');
                if (hidden) {
                    hidden.value = reasons.join(' | ');
                }

                // Submit dulu sebelum mengosongkan currentForm
                form.submit();
                closeOverlay();
            }
        });

        @if(session('order_status_popup'))
        (function () {
            var status = @json(session('order_status_popup'));
            var message = status === 'ditolak'
                ? 'Pesanan berhasil ditolak.'
                : 'Pesanan berhasil diterima. Jadwal dan jam pengiriman akan ditentukan sesuai kebijakan kantin.';
            alert(message);
        })();
        @endif
    })();
</script>

</body>
</html>

