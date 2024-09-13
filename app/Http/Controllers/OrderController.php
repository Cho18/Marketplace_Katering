<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        // Dapatkan user yang sedang login
        $user = auth()->user();

        // Jika user adalah customer (role_id = 1)
        if ($user->role_id == 1) {
            // Ambil semua order milik customer tersebut
            $orders = Order::where('user_id', $user->id)
                ->orderBy('delivery_date', 'asc')
                ->orderBy('delivery_time', 'asc')
                ->get();
        }
        // Jika user adalah merchant (role_id = 2)
        elseif ($user->role_id == 2) {
            // Ambil semua order yang terkait dengan menu milik merchant tersebut
            $orders = Order::whereHas('menu', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('delivery_date', 'asc')
                ->orderBy('delivery_time', 'asc')
                ->get();
        } else {
            // Jika role_id tidak dikenal, kembalikan koleksi kosong atau arahkan ke halaman lain
            $orders = collect(); // Menghasilkan koleksi kosong
        }

        // Kirim data orders ke view
        return view('order.index', compact('orders'));
    }
    

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_time' => 'required|date_format:H:i'
        ]);

        // Buat pesanan baru
        $order = Order::create([
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date,
            'delivery_time' => $request->delivery_time,
            'user_id' => auth()->id(),
        ]);

        // Hitung total amount dari pesanan
        $totalAmount = $order->menu->price * $order->quantity;

        // Buat nomor invoice unik
        $invoiceNumber = 'INV-' . strtoupper(uniqid());

        // Buat invoice untuk pesanan ini
        Invoice::create([
            'order_id' => $order->id,
            'total_amount' => $totalAmount,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Pesanan Anda telah berhasil dibuat dan invoice telah dihasilkan!');
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Belum Siap,Sedang Disiapkan,Telah Siap',
    ]);

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
}

}
