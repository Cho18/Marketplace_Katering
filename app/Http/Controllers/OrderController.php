<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }
        elseif ($user->role_id == 2) {
            $orders = Order::whereHas('menu', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('delivery_date', 'asc')
                ->orderBy('delivery_time', 'asc')
                ->get();
        } else {
            $orders = collect();
        }

        return view('order.index', compact('orders'));
    }
    

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id'           => 'required|exists:menus,id',
            'quantity'          => 'required|integer|min:1',
            'delivery_date'     => 'required|date|after_or_equal:today',
            'delivery_time'     => 'required|date_format:H:i'
        ], [
            'menu_id.required'                  => 'Menu makanan harus dipilih.',
            'menu_id.exists'                    => 'Menu makanan yang dipilih tidak valid.',
            'quantity.required'                 => 'Jumlah pesanan harus diisi.',
            'quantity.integer'                  => 'Jumlah pesanan harus berupa angka.',
            'quantity.min'                      => 'Minimal jumlah pesanan adalah 1.',
            'delivery_date.required'            => 'Tanggal pengiriman harus diisi.',
            'delivery_date.date'                => 'Tanggal pengiriman tidak valid.',
            'delivery_date.after_or_equal'      => 'Tanggal pengiriman harus hari ini atau setelahnya.',
            'delivery_time.required'            => 'Waktu pengiriman harus diisi.',
            'delivery_time.date_format'         => 'Format waktu pengiriman tidak valid. Harus dalam format jam:menit (contoh: 14:30).',
        ]);
        

        $order = Order::create([
            'menu_id'           => $request->menu_id,
            'quantity'          => $request->quantity,
            'delivery_date'     => $request->delivery_date,
            'delivery_time'     => $request->delivery_time,
            'user_id'           => auth()->id(),
        ]);

        $totalAmount = $order->menu->price * $order->quantity;

        $invoiceNumber = 'INV-' . strtoupper(uniqid());

        Invoice::create([
            'order_id'          => $order->id,
            'total_amount'      => $totalAmount,
            'invoice_number'    => $invoiceNumber,
            'invoice_date'      => now(),
        ]);

        return redirect()->back()->with('success', 'Pesanan Anda telah berhasil dibuat dan invoice telah dihasilkan');
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
