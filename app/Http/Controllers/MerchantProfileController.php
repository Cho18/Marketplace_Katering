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
        
        // Check if the merchant profile exists, if not, create a new one
        $profile = $user->merchantProfile;

        if (!$profile) {
            $profile = MerchantProfile::create([
                'user_id' => $user->id,
                'company_name' => '',
                'address' => '',
                'contact' => '',
                'description' => '',
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
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $profile->update([
            'company_name' => $request->company_name,
            'address' => $request->address,
            'contact' => $request->contact,
            'description' => $request->description,
        ]);

        return redirect()->route('merchant.profile')->with('success', 'Profile updated successfully.');
    }
}
