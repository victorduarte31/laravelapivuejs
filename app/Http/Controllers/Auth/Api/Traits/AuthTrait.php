<?php

namespace App\Http\Controllers\Auth\Api\Traits;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

trait AuthTrait
{

    public function authenticate()
    {
        // grab credentials from the request
        $credentials = request()->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // recuperar usuario logado
        $user = auth()->user();

        // all good so return the token
        return response()->json(compact('token', 'user'));
    }

    public function getUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {

                return [
                    'response' => 'user_not_found',
                    'status' => 404
                ];
                /*return response()->json(['user_not_found'], 404);*/
            }

        } catch (TokenExpiredException $e) {

            return [
                'response' => 'token_expired',
                'status' => $e->getStatusCode()
            ];
            /*return response()->json(['token_expired'], $e->getStatusCode());*/

        } catch (TokenInvalidException $e) {

            return [
                'response' => 'token_invalid',
                'status' => $e->getStatusCode()
            ];
            /* return response()->json(['token_invalid'], $e->getStatusCode());*/

        } catch (JWTException $e) {

            return [
                'response' => 'token_absent',
                'status' => $e->getStatusCode()
            ];
            /*return response()->json(['token_absent'], $e->getStatusCode());*/

        }

        return [
            'response' => $user,
            'status' => 200,
        ];
    }
}
