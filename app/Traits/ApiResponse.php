<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponse
{
    private function success($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function error($message, $code)
    {
        return response()->json(['error'=>$message, 'code'=> $code], $code);
    }

    protected function showAll(Collection $collection, $code=200 )
    {
        return $this->success(['data'=> $collection], $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        return $this->success(['data' => $model], $code);
    }


}
