<?php

use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

function formatPhoneNumber($country_code, $phone_number) {
    //Remove plus sign
    $phone_number = str_replace('+', '', $phone_number);

    //Check if phone number starts with country code
    if (!Str::startsWith($phone_number, $country_code)) {
        if (Str::startsWith($phone_number, '0')) {
            $phone_number = substr($phone_number, 1, strlen($phone_number));
        }
        $phone_number = $country_code . $phone_number;
    }

    return $phone_number;
}

function generateToken(){
    $token = rand(100000, 999999);
    return $token;
}

function filter_array(array $data, array $excludes) {
    for ($i = 0; $i < count($excludes); $i++) {
        if (isset($data[$excludes[$i]])) {
            unset($data[$excludes[$i]]);
        }
    }
    return $data;
}

function saveData(array $data, $model) {
    try {
         $data = \filter_array($data, ['password_confirmation']);
         return $model::insertGetId($data);
    }
    catch(QueryException $e) {
        abort(error('Oops! Something went wrong.', [$e->getMessage()]));
    }
}
