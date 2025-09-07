<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'image'    => 'nullable|image|max:2048',
            'password' => 'required|string|min:8',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        $data['password'] = Hash::make($data['password']);

        $user  = User::create($data);
        $token = auth('api')->login($user);

        return response()->json([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type'  => 'bearer',
            ]
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'user' => auth('api')->user(),
            'authorisation' => [
                'token' => $token,
                'type'  => 'bearer',
            ]
        ], 200);
    }
}
