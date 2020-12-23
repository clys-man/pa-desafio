<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Authentication for user login.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->all();

            $validatedData['password'] = bcrypt($request->password);

            $user = User::create([
                'name'=> $validatedData['name'],
                'email'=> $validatedData['email'],
                'password'=> $validatedData['password']
            ]);

            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json(['user'=> $user, 'token'=> $accessToken], 201);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiMessage::display($e->getMessage(), 1020), 500);
            }
            return response()->json(ApiMessage::display("Houve um erro ao efetuar a ação", 1020), 500);
        }
    }

    /**
     * Authentication for user login.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $loginData = $request->all();

        if(!auth()->attempt(["email" => $loginData["email"], "password" => $loginData["password"]])) {
            return response()->json(ApiMessage::display("400 Bad Request", 400), 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json(['user' => auth()->user(), 'token' => $accessToken], 200);

    }
}
