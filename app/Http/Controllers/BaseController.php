<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    const HTTP_OK = 200;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_INTERNAL_ERROR = 500;

    protected function responseSuccess(mixed $result): array
    {
        return with(http_response_code(static::HTTP_OK), fn() => ['status' => true, 'data' => array_values($result)]);
    }

    protected function responseFail(string $error_message, int $response_code = self::HTTP_BAD_REQUEST): array
    {
        return with(http_response_code($response_code), fn() => ['status' => false, 'error_message' => $error_message]);
    }
}
