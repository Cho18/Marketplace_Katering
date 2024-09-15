<?php

namespace App\Http\Controllers;

use App\Models\MerchantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantProfileController extends Controller
{
    /**
     * Display the merchant profile.
     */
    public function index()
    {
        $user = Auth::user();
        
        $profile = $user->merchantProfile;

        if (!$profile) {
            $profile = MerchantProfile::create([
                'user_id'           => $user->id,
                'company_name'      => '',
                'address'           => '',
                'contact'           => '',
                'description'       => '',
            ]);
        }

        return view('merchant_profile.index', compact('profile'));
    }

    /**
     * Show the form for editing the merchant profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->merchantProfile;

        return view('merchant_profile.edit', compact('profile'));
    }

    /**
     * Update the merchant profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $profile = $user->merchantProfile;

        $request->validate([
            'company_name'      => 'required|string|max:255',
            'address'           => 'required|string|max:255',
            'contact'           => 'required|string|max:50',
            'description'       => 'nullable|string',
        ], [
            'company_name.required' => 'Nama katering diperlukan.',
            'company_name.string'   => 'Nama katering harus berupa string.',
            'company_name.max'      => 'Nama katering tidak boleh lebih dari 255 karakter.',
            'address.required'      => 'Alamat diperlukan.',
            'address.string'        => 'Alamat harus berupa string.',
            'address.max'           => 'Alamat tidak boleh lebih dari 255 karakter.',
            'contact.required'      => 'Kontak diperlukan.',
            'contact.string'        => 'Kontak harus berupa string.',
            'contact.max'           => 'Kontak tidak boleh lebih dari 50 karakter.',
            'description.string'    => 'Deskripsi harus berupa string.',
        ]);

        $profile->update([
            'company_name'      => $request->company_name,
            'address'           => $request->address,
            'contact'           => $request->contact,
            'description'       => $request->description,
        ]);

        return redirect()->route('merchant.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
