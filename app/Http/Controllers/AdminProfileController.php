<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    /**
     * Show the admin profile page
     */
    public function index()
    {
        
        $admin = Admin::with('account')->first();

        if (!$admin) {
            $admin = new Admin([
                'username' => 'System Admin',
                'phone' => '',
                'address' => '',
                'photo' => null,
            ]);
        }

        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Handle profile update
     */
    public function update(Request $request)
    {
        $admin = Admin::firstOrFail();

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        
        if ($request->hasFile('photo')) {
            if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                Storage::disk('public')->delete($admin->photo);
            }

            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        $admin->update($validated);

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Profile updated successfully!');
    }
}
