<?php

namespace App\Traits;

trait Response
{

    /**
     *  Return a response on success
     * @param String $type
     * @param Object $data
     * @param Int $code
     * @return Response 
     */
    public function successResponse(String $type = 'Success', $data, int $code = 200)
    {

        return response()->json([
            'data' => [
                [
                    'type' => $type,
                    'attributes' => [$data]
                ]
            ]
        ], $code);
    }

    /**
     *  Return a response on error
     * @param String $message
     * @param Int $code
     * @return Response 
     */
    public function errorResponse(String $message = 'Error', int $code = 400)
    {

        return response()->json([
            'errors' => [
                [
                    'status' => strtolower($code),
                    'title' => $message
                ]
            ]
        ], $code);
    }
}
