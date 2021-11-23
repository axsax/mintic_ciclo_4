<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
//use Jenssegers\Mongodb\Eloquent\Model;
use PhpParser\JsonDecoder;
use PHPUnit\Util\Json;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }
    protected function perfectResponse($message, $code)
    {
        return response()->json(['data' => $message, 'code' => $code], $code);
    }
    protected function errorResponse($message, $code)
    {
        return response()->json(['data' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse(['data' => $collection,'code' => $code], $code);
    }
    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse(['data' => $instance,'code' => $code], $code);
    }

    //se utilizan para cuando el resultado se da desde un Raw Query
    protected function showRawQuery(array $array, $code = 200)
    {
        return $this->successResponse(['data' => $array,'code' => $code], $code);
    }
}
