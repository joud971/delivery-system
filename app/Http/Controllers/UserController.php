<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('manage-users'), 403);
        $users = User::with('roles')->latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('manage-users'), 403);
        $roles = Role::orderBy('name')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('manage-users'), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'username' => 'required|string|max:80|alpha_dash|unique:users,username',
            'email' => 'required|email|max:180|unique:users,email',
            'phone' => 'nullable|string|max:30|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
        ]);
        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'تم إنشاء الحساب بنجاح.');
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->can('manage-users'), 403);
        abort_if($user->is(auth()->user()), 422, 'لا يمكنك حذف حسابك الحالي.');
        $user->delete();
        return back()->with('success', 'تم حذف الحساب.');
    }
}
