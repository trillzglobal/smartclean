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
        $this->middleware('auth:api', ['except' => ['login','forgotPassword','resetPassword']]);
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

    public function forgotPassword($phone_number){
        $phone_number = formatPhoneNumber('234',$phone_number);
        $user =  User::where('phone_number',$phone_number)->first();

        if(!$user)
            return failed("User detail does not exist", []);

        $otpModel = parent::createOTP($phone_number, config('userconf.token.reset_password'), $user->id);
        $this->sendOTP($otpModel->otp, $otpModel->phone_number, "password change on");

        return success("OTP Sent successfully to registered phone number", ["otp_id"=>$otpModel->id]);
    }

    public function resetPassword(Request $request){
        $data = $this->validate($request->all(), config('validator.change_password'));
        $otp_reason = config('userconf.token.'.$data['otp_reason']);
        if(!is_numeric($otp_reason))
            return failed("OTP Reason is not acceptable", []);
        $data['otp_reason_id'] = $otp_reason;

        $verified  = parent::verifyOTP($data);
        if(!$verified)
            return failed("OTP Verification failed",[]);

        $user =  User::find($verified->user_id);
        $user->password = $data["new_password"];
        $user->save();

        return success("Password Changed Successfully", []);
    }

}
