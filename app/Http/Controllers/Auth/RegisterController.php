<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\SmsVerifications;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\CodeGenerator;
use Illuminate\Support\Facades\DB;
use App\Traits\RegisterUser;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
use RegisterUser;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
            ]);


            $smsCode = CodeGenerator::generateCode();
            DB::table('sms_verification_code')
                ->insert([
                    'code' => Hash::make($smsCode),
                    'user_id' => $user->id
                ]);

            new SmsVerifications($user->phone, $smsCode);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
