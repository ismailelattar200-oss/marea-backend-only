<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UserController extends Controller
{
    private function ensureVehicleColumnExists()
    {
        if (!Schema::hasColumn('users', 'vehicle')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('vehicle')->nullable();
            });
        }
    }

    public function index()
    {
        $this->ensureVehicleColumnExists();
        return response()->json([
            'success' => true,
            'data' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureVehicleColumnExists();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,staff,delivery,customer',
            'phone' => 'nullable|string|max:30',
            'vehicle' => 'nullable|string|max:100',
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
        $this->ensureVehicleColumnExists();
        $rules = [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'role' => 'sometimes|in:admin,staff,delivery,customer',
            'phone' => 'nullable|string|max:30',
            'vehicle' => 'nullable|string|max:100'
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }

        $validated = $request->validate($rules);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

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
