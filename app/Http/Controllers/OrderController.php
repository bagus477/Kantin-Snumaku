<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function penjualDashboard()
    {
        // Hanya hitung pesanan yang masih menunggu (belum diproses)
        // Termasuk:
        // - pending (QRIS baru dibuat)
        // - menunggu (QRIS sudah lewat countdown, menunggu konfirmasi kantin)
        // - menunggu pembayaran (bayar di kasir)
        $ordersCount = Order::whereIn('status', ['pending', 'menunggu', 'menunggu pembayaran'])->count();

        // Pesanan terakhir yang sudah selesai (jika ada)
        $latestReadyOrder = Order::where('status', 'selesai')
            ->latest('updated_at')
            ->first();

        return view('dashboards.penjual', [
            'ordersCount' => $ordersCount,
            'latestReadyOrder' => $latestReadyOrder,
        ]);
    }

    public function penjualPesanan()
    {
        // Pesanan yang masih menunggu + yang sudah ditolak (tab Pesanan)
        // Termasuk status 'menunggu' (QRIS menunggu konfirmasi kantin)
        $orders = Order::with('user')
            ->whereIn('status', ['pending', 'menunggu', 'menunggu pembayaran', 'ditolak'])
            ->orderByDesc('created_at')
            ->get();

        $ordersCount = Order::whereIn('status', ['pending', 'menunggu', 'menunggu pembayaran'])->count();

        // Pesanan terakhir yang sudah selesai (untuk link Detail Pesanan di navbar)
        $latestReadyOrder = Order::where('status', 'selesai')
            ->latest('updated_at')
            ->first();

        return view('dashboards.penjual-pesanan', [
            'orders' => $orders,
            'ordersCount' => $ordersCount,
            'latestReadyOrder' => $latestReadyOrder,
            'activeTab' => 'pesanan',
        ]);
    }

    public function penjualTerjadwal()
    {
        // Pesanan yang sudah diterima (tab Terjadwal)
        $orders = Order::with('user')
            ->where('status', 'diterima')
            ->orderByDesc('created_at')
            ->get();

        $ordersCount = Order::whereIn('status', ['pending', 'menunggu pembayaran'])->count();

        // Pesanan terakhir yang sudah selesai (untuk link Detail Pesanan di navbar)
        $latestReadyOrder = Order::where('status', 'selesai')
            ->latest('updated_at')
            ->first();

        return view('dashboards.penjual-pesanan', [
            'orders' => $orders,
            'ordersCount' => $ordersCount,
            'latestReadyOrder' => $latestReadyOrder,
            'activeTab' => 'terjadwal',
        ]);
    }

    public function penjualDetailPesanan(Order $order)
    {
        // Hitung pesanan yang masih menunggu untuk badge di navbar
        $ordersCount = Order::whereIn('status', ['pending', 'menunggu pembayaran'])->count();

        return view('dashboards.penjual-detail-pesanan', [
            'order' => $order->load('user'),
            'ordersCount' => $ordersCount,
        ]);
    }

    public function pembeliPesanan()
    {
        $userId = Auth::id();

        $orders = Order::query()
            ->when($userId, function ($q) use ($userId) {
                $q->where(function ($inner) use ($userId) {
                    $inner->where('user_id', $userId)
                          ->orWhereNull('user_id'); // tampilkan juga pesanan lama yang belum ada user_id
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('dashboards.pembeli-pesanan', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'menu_name' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'base_amount' => 'required|integer|min:0',
            'extra_amount' => 'required|integer|min:0',
            'total_amount' => 'required|integer|min:0',
            'payment_method' => 'required|string|max:50',
        ]);

        $userId = Auth::id() ?? ($data['user_id'] ?? null);

        // Status awal berdasarkan metode pembayaran
        // Qris  : pending (nanti diupdate jadi menunggu / selesai sesuai flow)
        // Kasir : menunggu pembayaran (akan dikonfirmasi kasir)
        $initialStatus = $data['payment_method'] === 'qris'
            ? 'pending'
            : 'menunggu pembayaran';

        $order = Order::create([
            'user_id' => $userId,
            'menu_name' => $data['menu_name'],
            'qty' => $data['qty'],
            'base_amount' => $data['base_amount'],
            'extra_amount' => $data['extra_amount'],
            'total_amount' => $data['total_amount'],
            'payment_method' => $data['payment_method'],
            'status' => $initialStatus,
        ]);

        return response()->json([
            'message' => 'Order stored',
            'order_id' => $order->id,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|string|max:50',
            'alasan_tolak' => 'nullable|string|max:255',
        ]);

        $order = Order::findOrFail($data['order_id']);
        $order->status = $data['status'];
        if (array_key_exists('alasan_tolak', $data)) {
            $order->alasan_tolak = $data['alasan_tolak'];
        }
        $order->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Order status updated',
            ]);
        }

        // Simpan status baru di session untuk ditampilkan sebagai popup di halaman pesanan penjual
        $request->session()->flash('order_status_popup', $order->status);

        // Jika ada URL tujuan spesifik, arahkan ke sana (misalnya dari tombol Terima ke halaman Terjadwal)
        if ($request->filled('redirect_to')) {
            return redirect($request->input('redirect_to'));
        }

        return redirect()->back();
    }
}
