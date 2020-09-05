<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponse
{
    private $field ="";
    private $operator = "";
    private $value ="";


    private function controlFilter($string, $operator)
    {
        $this->operator = $operator;

        if($operator == "=")
        {
            $values = explode("_eq_",$string);
        }else{
            $values = explode("_ne_",$string);
        }
        $this->field = $values[0];
        $this->value = end($values);
    }


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
        $collection = $this->sortData($collection);
        $collection = $this->filterData($collection);
        return $this->success(['data'=> $collection], $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        return $this->success(['data' => $model], $code);
    }

    protected function successMessage($message)
    {
        return response()->json(['success'=>$message, 'code'=>'200'],200);

    }

    protected function filterData(Collection $collection)
    {
        foreach (request()->query() as $query => $value)
        {
            if(strpos($query, '_eq_') !== false)
            {
                $this->controlFilter($query, "=");

            }elseif (strpos($query, '_ne_') !== false)
            {
                $this->controlFilter($query, "!=");
            }
            $collection = $collection->where($this->field,$this->operator,$this->value);
        }
        return $collection;
    }

    protected function sortData(Collection $collection)
    {
        if(request()->has('sort_by'))
        {
            $attribute = request()->sort_by;
            if(request()->has('desc'))
            {
                $collection = $collection->sortByDesc->{$attribute};

            }else{
                $collection = $collection->sortBy->{$attribute};
            }
        }
        return $collection;
    }



}
