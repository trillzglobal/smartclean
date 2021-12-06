<?php

return [
    'user' => [
        'email' => 'required|unique:users',
        'phone_number' => 'required|unique:users',
        'password' => 'required|confirmed|min:6'
    ],
    'login' =>[
        'email'=> 'required',
        'password'=>'required',
    ],
];
