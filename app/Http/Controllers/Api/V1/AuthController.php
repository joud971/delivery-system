<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('username', $credentials['username'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password) || !$user->hasRole('Driver')) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة.'], 422);
        }

        return response()->json([
            'token' => $user->createToken('driver-app')->plainTextToken,
            'user' => $user->load('driverProfile'),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message' => 'تم تسجيل الخروج.']);
    }
}
