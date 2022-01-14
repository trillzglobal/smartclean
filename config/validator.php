<?php

return [
    'register' => [
        'email' => 'required|unique:users||email:rfc,dns',
        'phone_number' => 'required|unique:users',
        'userid' => 'required|unique:users|min:6',
    ],
    'register_complete'=>[
        'first_name'=>'required',
        'last_name'=>'required',
        'dob'=>'required',
        'otp_id'=>'required',
        'password'=>'required|min:8',
        'address'=>'required',
        'state_id'=>'required|numeric',
        'country_id'=>'required|numeric',
        'city_id'=>'required|numeric'

    ],
    'login' =>[
        'email'=> 'required',
        'password'=>'required',
    ],
    "verifyotp"=>[
        "otp_reason"=>'required',
        "otp"=>'required|min:6|max:6',
        "otp_id"=>'required|numeric'
    ],
    "change_password"=>[
        "otp_reason"=>'required',
        "otp"=>'required|min:6|max:6',
        "otp_id"=>'required|numeric',
        "new_password"=>'required|min:8'
    ]
];
