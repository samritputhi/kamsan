<?php

namespace App\Http\Filters\V1;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


abstract class QueryFilter{
    protected $builder;
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $this->builder;
    }  
}   