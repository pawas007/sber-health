<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LogoutTokenController extends Controller
{
    public function logout(Request $request): JsonResponse
    {
//        Auth::user()->tokens()->delete();
        Auth::user()->currentAccessToken()->delete();
        $response = [
            'status' => true,
            'message' => 'Logout successfully',
        ];
        return Response::json($response ) ;
    }
}
