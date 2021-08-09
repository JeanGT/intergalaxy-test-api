<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|between:6,20'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        return $this->attemptLogin($validator->validated());
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|between:4,100',
            'cpf' => 'required|cpf|string|unique:users',
            'hourly_price' => 'required|numeric|min:0',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:6,20'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'role_id' => 1
            ],
        ));

        return $this->attemptLogin($validator->validated());
    }

    private function attemptLogin($credentials)
    {
        $token_validity = 24 * 60;

        $this->guard()->factory()->setTTL($token_validity);

        if (!$token = $this->guard()->attempt($credentials))
            return response()->json(['message' => 'Unauthorized'], 401);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'User logged out successfully']);
    }

    public function profile()
    {
        return response()->json($this->guard()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity' => $this->guard()->factory()->getTTL(),
            'user' => $this->guard()->user()
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
