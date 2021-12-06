<?php

use Illuminate\Http\Response;

function error($message, $data, $code = null) {
    $d = [
        'code' => $code?? Response::HTTP_BAD_REQUEST,
        'status' => 'error',
        'message' => $message,
        'data' => $data
    ];

    return response()->json($d);
}


function failed($message, $data, $code = null) {
    $d = [
        'code' => $code?? Response::HTTP_UNPROCESSABLE_ENTITY,
        'status' => 'failed',
        'message' => $message,
        'data' => $data
    ];

    return response()->json($d);
}


function success($message, $data, $code = null) {
    $d = [
        'code' => $code?? Response::HTTP_OK,
        'status' => 'success',
        'message' => $message,
        'data' => $data
    ];

    return response()->json($d);
}


function expired($message, $data, $code = null) {
    $d = [
        'code' => $code?? Response::HTTP_UNAUTHORIZED,
        'status' => 'expired',
        'message' => $message,
        'data' => $data
    ];


    return response()->json($d);
}
