<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenerateTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You are not allow to perform this action'], 403);
        }


        $token = $request->user()->createToken(Auth::user()->name)->plainTextToken;

        return response()->json([
            'access_token' => $token
        ]);
    }
}
