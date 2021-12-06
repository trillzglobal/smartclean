<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    public function login(Request $request)
    {

        //return success("Completed", $data);
        $credentials = $this->validate($request->all(), config('validator.login'));

        $identity = filter_var($credentials["email"], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        if (strcmp($identity, 'email') != 0) {
            $credentials[$identity] = formatPhoneNumber('234', $credentials['email']);
            unset($credentials['email']);
        }


        if (! $token = auth('api')->attempt($credentials)) {
            return expired('Invalid login credentials', null);
        }
        // $user = User::where("email",$data["email"]);
        // $token = auth('api')
        return $this->respondWithToken($token);

    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->success('Successfully logged out', null);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return success('Logged in successfully', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
