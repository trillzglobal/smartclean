<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Referral;
use App\Models\State;
use App\Models\Temporary;
use App\Models\Token;
use App\Models\User;
use App\Models\UserData;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class RegistrationController extends Controller
{

    //
    public function createUser(Request $request){

        $ref = $this->generateReferralID();
        $request->phone_number = formatPhoneNumber('234', $request->phone_number);
        $request->request->add(['userid'=>$ref]);
        $data = $this->validate($request->all(), config('validator.register'));
        $otpModel = parent::createOTP($data['phone_number'], config('userconf.token.register'));
        $data['token_id']=$otpModel->id;
        if(!empty($data['ref_id'])){
            $ref_id = User::where('userid',$data['ref_id'])->first('id');
            if(!$ref_id)
                return failed('Referral ID is not available', []);
            $data['ref_id']=$ref_id->id;
        }

        //Temporary Table Creation
        $id = saveData($data, Temporary::class);
        $this->sendOTP($otpModel->otp, $otpModel->phone_number);
        return success("OTP Sent to $otpModel->phone_number and ".$data['email']." to Complete Registration", ["otp_id"=>$id]);
    }

    public function verifyRegisterOTP(Request $request){
        $data = $this->validate($request->all(), config('validator.verifyotp'));
        $otp_reason = config('userconf.token.'.$data['otp_reason']);
        if(!is_numeric($otp_reason))
            return failed("OTP Reason is not acceptable", []);
        $data['otp_reason_id'] = $otp_reason;

        $verified  = parent::verifyOTP($data);

        if($verified)
            return success("OTP Verification Successful",["otp_id"=>$verified->id]);
        return failed("OTP Verification not Successful",[]);
    }
    
    public function completeUserCreation(Request $request){
        $data = $this->validate($request->all(), config('validator.register_complete'));

        $stored_data = Token::where('id',$request->otp_id)->with('temporaries')->first();
        if($stored_data->token)
            return failed("Token ID not acceptable", []);

        $phone_number = $stored_data->temporaries->phone_number;
        $email = $stored_data->temporaries->email;
        $ref_user_id = $stored_data->temporaries->ref_id;
        $userid = $stored_data->temporaries->userid;

        $exist = User::where('email',$email)
                        ->whereOr('phone_number',$phone_number)
                        ->exists();

        if($exist)
            return failed("Please retrace and select a unique username and password", []);
        
        //Create User Record
        $user = new User;
        $user->phone_number = $phone_number;
        $user->password = $data["password"];
        $user->email = $email;
        $user->userid = $userid;
        $user->save();

        $userWallet = new Wallet;
        $userWallet->user_id = $userid;
        $userWallet->main_balance = 0.00;
        $userWallet->bonuses = 0.00;
        $userWallet->referral = 0.00;
        $userWallet->save();

        $data['user_id'] = $user->id;
        //Create UserData Record
        saveData(filter_array($data, ['otp_id', 'password']), UserData::class);
        if(!empty($ref_user_id))
            $this->createReferral($user->id, $ref_user_id);

        return success('User Registered Successfully', 200);
    }

    private function createReferral($user_id, $ref_user_id){
        $ref_list = Referral::where('user_id',$ref_user_id)->first();
            if(!empty($ref_list)){
                $ref_data=['user_id'=>$user_id,'ref1'=>$ref_list->userid, 'ref2'=>$ref_list->ref2, 'ref3'=>$ref_list->ref3
                , 'ref4'=>$ref_list->ref4, 'ref5'=>$ref_list->ref5, 'ref6'=>$ref_list->ref6, 'ref7'=>$ref_list->ref7];
            }
            else{
                $ref_data = ["user_id"=>$user_id, 'ref1'=>$ref_user_id];
            }
            saveData($ref_data, Referral::class);
    }

    private function generateReferralID(){
        RUN:
        $ref = strtoupper(Str::random(6));
        if(User::where('userid',$ref)->exists())
            GOTO RUN;
        return $ref;
    }

    public function country(){
        $country = Country::all();

        return success("Request for Country list successful", $country);
    }

    public function state($country_id){
        $state = State::where('country_id', $country_id)->get();

        return success("Request for State list successful", $state);
    }

    public function city($state_id){
        $city = City::where('state_id', $state_id)->get();
        return success("Request for City list successful", $city);
    }
}
