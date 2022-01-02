<?php
namespace App\Http\Traits;

use App\Models\Token;

trait UserTrait{
    function createOTP($phone_number, $reason, $user_id=null){
        $otp = generateToken();
        $otpModel = new Token;
        $otpModel->phone_number = $phone_number;
        $otpModel->otp = $otp;
        $otpModel->user_id = $user_id;
        $otpModel->otp_reason_id = $reason;
        $otpModel->save();

        return $otpModel;
    }

}
