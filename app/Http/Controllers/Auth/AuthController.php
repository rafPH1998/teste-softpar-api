<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private User $user)
    { }

    public function auth(AuthRequest $req): JsonResponse
    {
        $user = User::where('email', '=', $req->email)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json(['error' => 'Credenciais inválidas'], 422);
        }
        
        $user->tokens()->delete();
        $token = $user->createToken($req->device_name)->plainTextToken;
        return response()->json(['token' => $token]);
        
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}