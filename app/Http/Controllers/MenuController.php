<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the menu items.
     */
    public function index(Request $request)
    {
        $userRoleId = Auth::user()->role_id;
        $userId = Auth::id();

        if ($userRoleId == 2) {
            $menus = Menu::where('user_id', $userId)->paginate(12);
        } else {
            $search = $request->get('search');
            $menus = Menu::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('price', 'like', "%{$search}%");
            })->paginate(12);
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
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'price'             => 'required|numeric',
            'photo'             => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'type_of_food'      => 'required|in:nasi goreng,ayam goreng,mie goreng,lontong,nasi ayam',
        ], [
            'name.required'              => 'Nama menu makanan wajib diisi',
            'description.required'       => 'Deskripsi menu makanan wajib diisi',
            'price.required'             => 'Harga menu makanan wajib diisi',
            'photo.required'             => 'Foto menu makanan wajib diisi',
            'photo.image'                => 'Harus berupa gambar',
            'photo.mimes'                => 'Hanya file JPG, JPEG, PNG yang diizinkan',
            'photo.max'                  => 'Ukuran gambar maksimal 2MB',
            'type_of_food.required'      => 'Jenis menu makanan wajib diisi',
            'type_of_food.in'            => 'Jenis menu makanan tidak valid',
        ]);

        $filePath = $request->file('photo')->store('menu_photos', 'public');

        Menu::create([
            'name'              => $request->name,
            'description'       => $request->description,
            'price'             => $request->price,
            'photo'             => $filePath,
            'user_id'           => auth()->id(),
            'type_of_food'      => $request->type_of_food, 
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu makanan berhasil dibuat.');
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
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'price'             => 'required|numeric',
            'photo'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'type_of_food'      => 'required|in:nasi goreng,ayam goreng,mie goreng,lontong,nasi ayam',
        ], [
            'name.required'              => 'Nama menu makanan wajib diisi.',
            'name.max'                   => 'Nama menu makanan tidak boleh lebih dari 255 karakter.',
            'description.required'       => 'Deskripsi menu makanan wajib diisi.',
            'price.required'             => 'Harga menu makanan wajib diisi.',
            'price.numeric'              => 'Harga menu makanan harus berupa angka.',
            'photo.image'                => 'Foto harus berupa gambar.',
            'photo.mimes'                => 'Hanya file dengan tipe jpg, jpeg, png yang diizinkan.',
            'photo.max'                  => 'Ukuran gambar maksimal 2MB.',
            'type_of_food.required'      => 'Jenis menu makanan makanan wajib diisi.',
            'type_of_food.in'            => 'Jenis menu makanan makanan tidak valid.',
        ]);

        if ($request->hasFile('photo')) {
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }

            $filePath = $request->file('photo')->store('menu_photos', 'public');
            $menu->photo = $filePath;
        }

        $menu->update([
            'name'              => $request->name,
            'description'       => $request->description,
            'price'             => $request->price,
            'type_of_food'      => $request->type_of_food,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu makanan berhasil diperbarui.');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu makanan berhasil dihapus');
    }
}
