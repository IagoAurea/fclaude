<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * success response method.
     * @param array|string|null $result
     * @param array|string|null $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message, $code = Response::HTTP_OK)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $result
        ];

        return response()->streamJson($response, $code);
    }

    /**
     * error response method.
     * @param array|string|null $error
     * @param array|null $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = Response::HTTP_NOT_FOUND)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages))
            $response['data'] = $errorMessages;

        return response()->json($response, $code);
    }

    /**
     * fail response method.
     * @param array|string|null $error
     * @param array|string|null $failMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendFails($error, $failMessages = [], $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($failMessages))
            $response['data'] = $failMessages;

        return response()->json($response, $code);
    }
}
