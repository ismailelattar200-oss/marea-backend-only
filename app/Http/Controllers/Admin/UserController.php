<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,staff,delivery,customer',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('avatar')) {
             $path = $request->file('avatar')->store('avatars', 'public');
             $validated['avatar'] = url('storage/' . $path);
        }

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'role' => 'sometimes|in:admin,staff,delivery,customer'
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function destroy(User $user)
    {
        // Don't delete the only admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() === 1) {
            return response()->json(['message' => 'Impossible de supprimer le dernier administrateur'], 400);
        }

        $user->delete();
        return response()->json(['success' => true]);
    }
}
