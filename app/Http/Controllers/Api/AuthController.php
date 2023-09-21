<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use Dingo\Api\Routing\Helpers;
use \Dingo\Api\Http\Response;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    //send response
    use Helpers;

    public function login(AuthRequest $request):  Response  {
        $credentials = request(['email',"password"]);
        if(!$token = JWTAuth::attempt($credentials)){
            $this->response->error(
                "Credenciales Incorrectas",
                 Response::HTTP_UNAUTHORIZED
            );
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token): Response {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
        /*     'expires_in_minutes' => auth('api')->factory()->getTTL(), */
        ]);
    }
}
