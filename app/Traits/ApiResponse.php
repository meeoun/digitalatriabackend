<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponse
{
    private $field ="";
    private $operator = "";
    private $value ="";
    private $paginate = 25;
    private $pivotDetected = false;



    private function specialValues($string)
    {
        if($string == "null")
        {
            return null;
        }
        return $string;
    }

    private function applyLimit($collection)
    {
        if(request()->has('limit'))
        {
            return  $collection->take(request()->get('limit'));
        }

        return $collection;
    }


    private function controlFilter($query, $operator, $value)
    {
        $this->operator = $operator;
        $this->value = $value;
        if($operator == "=")
        {
           $this->field = $query;
        }elseif ($operator == "!="){
            $this->field = substr($query,0,-1);
        }
        $this->value = $this->specialValues($this->value);
    }

    private function pivotQuery($query)
    {
        $this->pivotDetected = true;
        $values = explode("pivot_", $query);
        return end($values);
    }

    private function filterPivot($collection)
    {
        $collection = $collection->filter(function($value, $key){
            foreach ($value->pivot->getAttributes() as $key2=>$value2)
            {
                if($key2 == $this->field)
                {
                    if($this->operator == "=")
                    {
                        return ($this->value == $value2);
                    }else{
                        return ($this->value != $value2);
                    }
                }
            }
            return false;
        });
        return $collection;
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
        $collection = $this->filterData($collection);
        $collection = $this->sortData($collection);
        $collection = $this->applyLimit($collection);
        $collection = $this->paginateData($collection);
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
            if($query == "page" || $query =="sort_by" || $query =='limit')
            {
                continue;
            }
            if(strpos($query, 'pivot') !== false)
            {
             $query = $this->pivotQuery($query);
            }

            if(substr($query,-1) != "!")
            {
                $this->controlFilter($query, "=",$value);

            }elseif (substr($query,-1) == "!")
            {

                $this->controlFilter($query, "!=", $value);
            }
            if($this->pivotDetected)
            {
                $collection = $this->filterPivot($collection);
            }else{
                $collection = $collection->where($this->field,$this->operator,$this->value);
            }
            $this->pivotDetected = false;
        }
        return $collection;
    }

    protected function sortData(Collection $collection)
    {
        $attribute = null;
        if(request()->has("sort_by"))
        {
            $attribute = request()->get("sort_by");
            $collection = $collection->sortBy->{$attribute};
        }elseif (request()->has("sort_by!"))
        {
            $attribute = request()->get("sort_by!");
            $collection = $collection->sortByDesc->{$attribute};
        }
        return $collection;
    }

    protected function paginateData(Collection $collection)
    {

        $page = LengthAwarePaginator::resolveCurrentPage();
        $results = $collection->slice(($page-1)*$this->paginate, $this->paginate)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $this->paginate, $page,[
            'path'=> LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }


}
