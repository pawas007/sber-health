<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TestRoute extends Controller
{


    public function index(Request $request): JsonResponse
    {
        return Response::json(Auth::user());
    }


}
