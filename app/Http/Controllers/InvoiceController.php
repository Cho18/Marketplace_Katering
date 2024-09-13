<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
    {
        // Ambil invoice berdasarkan ID
        $invoice = Invoice::findOrFail($id);

        // Tampilkan view dengan data invoice
        return view('invoice.index', compact('invoice'));
    }
}
