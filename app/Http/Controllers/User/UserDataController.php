<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class UserDataController extends Controller
{


    //
    public function getUserDetails(Request $request){

        dd("Hello Drame");
        // dd(authUser());
        $user = $request->user();
        // dd($user);
        $userid = $user->userid;


        $userData = User::where('userid', $userid)->with('user_data')->first();

        // dd($userData);

    }

    public function updateUserDetails(Request $request){

    }

    public function create(Request $request){
    }


}
