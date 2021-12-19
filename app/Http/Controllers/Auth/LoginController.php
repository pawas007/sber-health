<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function login(Request $request)
    {


        try {
            if (!Auth::attempt($request->only('email', 'password'))) {

                return Response::json(['message' => 'Invalid email or password'], 401);

            } else {
                $user = User::where('email', $request['email'])->firstOrFail();

                $token = $user->createToken('auth_token')->plainTextToken;
                return Response::json([
                    'status' => true,
                    'data' => [
                        'token_type' => 'Bearer',
                        'token' => $token,

                    ]

                ], 200);
            }


        } catch (Exception $e) {
            return Response::json($e->getMessage(),  500);
        }


    }


}
