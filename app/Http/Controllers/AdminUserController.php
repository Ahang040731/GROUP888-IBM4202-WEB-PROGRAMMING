<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // show all user
    public function index()
    {
        $users = User::with('account')->paginate(10);
        return view('admin.usermanagement.index', compact('users'));
    }

    // check user detail
    public function edit($id)
    {
        $user = User::with('account')->findOrFail($id);
        return view('admin.usermanagement.edit', compact('user'));
    }

    // update user info
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('admin.usermanagement.index')
                         ->with('success', 'User details updated successfully.');
    }

    // activate/deactivate user
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('admin.usermanagement.index')
                         ->with('success', 'User status updated successfully.');
    }
}
