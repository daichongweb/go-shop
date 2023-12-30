<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class Rsp
{
    public static function success($data = []): JsonResponse
    {
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => '成功',
            'data' => $data
        ]);
    }

    public static function error(string $message = ''): JsonResponse
    {
        return response()->json([
            'code' => 500,
            'status' => 'error',
            'message' => $message
        ]);
    }

    public static function page($paginate): JsonResponse
    {
        return response()->json([
            'data' => [
                'list' => $paginate->items(),
                'currentPage' => $paginate->currentPage(),
                'total' => $paginate->total(),
                'limit' => $paginate->perPage()
            ],
            'code' => 1,
            'message' => 'success'
        ]);
    }
}
