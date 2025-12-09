<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'phone_number' => 'nullable|max:20',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        if ($user->buyer) {
            $buyerData = [];

            if ($request->hasFile('profile_picture')) {
                if ($user->buyer->profile_picture && file_exists(public_path('images/profiles/' . $user->buyer->profile_picture))) {
                    unlink(public_path('images/profiles/' . $user->buyer->profile_picture));
                }

                $pictureName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
                $request->file('profile_picture')->move(public_path('images/profiles'), $pictureName);
                $buyerData['profile_picture'] = $pictureName;
            }

            if ($request->phone_number) {
                $buyerData['phone_number'] = $validated['phone_number'];
            }

            if (!empty($buyerData)) {
                $user->buyer->update($buyerData);
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}