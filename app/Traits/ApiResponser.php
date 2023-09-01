<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Build success response
     * @param  string|array $data
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK,$status)
    {
        return response()->json(['status'=>$status,'responseCode'=> $code,'responseMessage'=>$data], $code)->header('Content-Type','application/json');
    }

    /**
     * Build error responses
     * @param  string|array $message
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code,$status)
    {
        return response()->json(['status'=>$status,'responseCode' => $code,'responseMessage' => $message], $code)->header('Content-Type','application/json');
    }
}
