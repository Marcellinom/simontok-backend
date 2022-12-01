<?php

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

if (!function_exists('use_db_transaction')) {
    /**
     * @throws Throwable
     */
    function use_db_transaction(callable $callback) {
        DB::beginTransaction();
        try {
            $res = $callback();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $res;
    }
}

if (!function_exists('every_array')) {
    function every_array(array|Collection|EloquentCollection $array, callable $logic): bool
    {
        for ($i = 0; $i < count($array); $i++)
            if (!$logic($array[$i])) return false;
        return true;
    }
}
