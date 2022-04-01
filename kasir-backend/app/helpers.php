<?php

if (!function_exists('api_response')) {
    function api_response($data = [], $message = 'success', $code = 200)
    {
        if ($data) {
            return response()->json([
                'code' => $code,
                'message' => $message,
                'data' => $data
            ], $code);
        }

        return response()->json([
            'code' => $code,
            'message' => $message
        ], $code);
    }
}
