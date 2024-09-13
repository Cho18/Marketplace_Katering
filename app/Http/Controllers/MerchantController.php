<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerchantProfile;
use App\Models\Menu;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        // Get search query
        $search = $request->input('search');

        // Fetch all merchant profiles with optional search
        $query = MerchantProfile::query();

        if ($search) {
            $query->where('company_name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('contact', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        $merchants = $query->paginate(10);

        return view('merchants.index', compact('merchants', 'search'));
    }

    public function show(Request $request, $id)
    {
        // Find the merchant profile
        $merchant = MerchantProfile::findOrFail($id);

        // Get search query for menus
        $search = $request->input('search');

        // Get menus for this merchant's user
        $query = Menu::where('user_id', $merchant->user_id);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('type_of_food', 'like', '%' . $search . '%');
            });
        }

        $menus = $query->paginate(10);

        return view('merchants.show', compact('merchant', 'menus', 'search'));
    }
}
