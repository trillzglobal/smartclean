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
    /**
     * getUserDetails
     *
     * @param  mixed $request
     * @return void
     */
    public function getUserDetails(Request $request){

        dd(authUser());

    }

    public function updateUserDetails(Request $request){

    }

    public function create(Request $request){
    }


}
