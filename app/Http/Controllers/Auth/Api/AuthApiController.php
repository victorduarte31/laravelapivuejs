<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Controllers\Auth\Api\Traits\AuthTrait;

class AuthApiController extends Controller
{

    use AuthTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['authenticate', 'register']]);
    }


    public function getAuthenticatedUser()
    {
        $response = $this->getUser();
        if ($response['status'] != 200)
            return response()->json([$response['response']], $response['status']);

        $user = $response['response'];

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function refresh()
    {
        if (!$token = JWTAuth::getToken())
            return response()->json(['error' => 'token_not_send'], 401);

        try {
            $token = JWTAuth::refresh();
        } catch (TokenInvalidException $e) {
            response()->json(['token_invalid'], $e->getStatusCode());
        }
        return response()->json(compact('token'));
    }


}
