<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validate($data, $rules) {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            abort(error('Unable to process your request. Please make sure the data provided are valid', $validator->errors()->toArray(), Response::HTTP_BAD_REQUEST));
        }
        return $data;
    }
}
