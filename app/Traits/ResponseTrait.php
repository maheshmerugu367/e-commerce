<?php

namespace App\Traits;
use App\Constants\ResponseConstants;




use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * Return a success response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function successResponse($success = null, $message = null, $statusCode = null,$errors=[]): JsonResponse
    {
        $success = $success ?? true;
        $message = $message ?? ResponseConstants::DEFAULT_FAILURE_MESSAGE;
        $statusCode = $statusCode ?? ResponseConstants::DEFAULT_FAILURE_STATUS_CODE;
    
        return response()->json([
            'status' => $success,
            'message' => $message,
            'errors'=>$errors,
            'statusCode'=>$statusCode
        ]);
    }

    public function failureResponse($success = null, $message = null, $statusCode = null,$errors=[]): JsonResponse
    {
        $success = $success ?? false;
        $message = $message ?? ResponseConstants::DEFAULT_FAILURE_MESSAGE;
        $statusCode = $statusCode ?? ResponseConstants::DEFAULT_FAILURE_STATUS_CODE;
    
        return response()->json([
            'status' => $success,
            'message' => $message,
            'errors'=>$errors,
            'statusCode'=>$statusCode
        ]);
    }
}
