<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class ApiException extends \Exception
{

    public const HTTP_OK = 200;
    public const HTTP_ERROR = 500;

    protected $data;
    protected $code;

    public function __construct($message, int $code = self::HTTP_ERROR, array $data = [])
    {
        $this->data = $data;
        $this->code = $code;
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        $content = [
            'message' => $this->message,
            'code' => $this->code,
            'data' => $this->data ?? [],
            'timestamp' => date('Y-m-d H:i:s')
        ];

        return response()->json($content, $this->code);
    }
}
