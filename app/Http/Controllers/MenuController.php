<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the menu items.
     */
    public function index(Request $request)
    {
        // Ambil role_id dan user_id dari pengguna yang sedang login
        $userRoleId = Auth::user()->role_id;
        $userId = Auth::id();

        // Jika role_id adalah 2
        if ($userRoleId == 2) {
            // Filter menu berdasarkan user_id
            $menus = Menu::where('user_id', $userId)->get();
        } else {
            // Untuk role_id=1
            // Cek jika ada query pencarian
            $search = $request->get('search');
            $menus = Menu::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%")
                             ->orWhere('price', 'like', "%{$search}%");
            })->get();
        }

        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        return view('menu.add');
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'photo' => 'required|image|max:2048',
            'type_of_food' => 'required|in:nasi goreng,ayam goreng,mie goreng,lontong,nasi ayam', // New validation
        ]);

        // Handle file upload untuk photo
        $filePath = $request->file('photo')->store('menu_photos', 'public');

        // Buat menu baru
        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'photo' => $filePath,
            'user_id' => auth()->id(),
            'type_of_food' => $request->type_of_food, // Store type of food
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
            'type_of_food' => 'required|in:nasi goreng,ayam goreng,mie goreng,lontong,nasi ayam', // New validation
        ]);

        // Update photo jika diunggah
        if ($request->hasFile('photo')) {
            $filePath = $request->file('photo')->store('menu_photos', 'public');
            $menu->photo = $filePath;
        }

        // Update kolom lainnya
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'type_of_food' => $request->type_of_food, // Update type of food
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu item updated successfully.');
    }
    /**
     * Remove the specified menu item from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu item deleted successfully.');
    }
}
