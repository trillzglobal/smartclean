<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use \App\Http\Traits\UserTrait;
use App\Models\Token;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, UserTrait;
    var $otp_base_url;
    protected function validate(array $data, $rules) {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            abort(error('Unable to process your request. Please make sure the data provided are valid', $validator->errors()->toArray(), Response::HTTP_BAD_REQUEST));
        }
        return $data;
    }

    protected function api_call($url, array $data = [], array $headers = []) {
        Log::debug('URL: '.$url);

        try {
            $res = Http::withHeaders($headers)->post($url, $data);
            Log::debug('Res: '.$res);
            if ($res->successful()) {
                $response = $res->json();
            }
            else {
                return 0; //Request failed!
            }
        }
        catch(ConnectionException $e) {
            return 1; //Service unavailable. Please try again later
        }
        catch(RequestException $e) {
            return 2; //Oops! Invalid request or endpoint called
        }
        return $response;
    }

    private function authenticate() {
        $this->otp_base_url = config('api_vendors.myflex.base_url');
        $url = $this->otp_base_url . '/users/account/authenticate';
        $data = [
            'phone' => config('api_vendors.myflex.username'),
            'password' => config('api_vendors.myflex.password')
        ];
        $response = $this->api_call($url, $data);
        return $response['token']?? null;
    }

    protected function sendOTP($otp_code, $phone_number, $task = "signup on") {
        $token = $this->authenticate();
        if ($token) {
            $data = [
                "service_category_id" => "23",
                "recipient" => [$phone_number],
                "sender" => "Payant",
                "message" => "Hi, kindly use OTP " . $otp_code . " to complete your $task " . config('app.company_name'),
                "dnd" => true
            ];

            $response = $this->api_call($this->otp_base_url . '/sms', $data, ['Authorization' => $token]);
            return $response['status']?? null == 'success';
        }
        return false;
    }

    protected function verifyOTP(array $data){
        $resp = Token::where('otp', (int)$data['otp'])
                        ->where('otp_reason_id', $data['otp_reason_id'])
                        ->where('id', $data['otp_id'])
                        ->where('created_at', '>=', [now()->subMinutes(10), now()])
                        ->where("status",false)->first();
        if($resp){
            $resp->status = true;
            $resp->save();
            return $resp;
        }
        return false;
    }
}
