<?php

namespace App\Models\Shared;

use DB;
use Throwable;

class DbTransaction
{
    /**
     * @throws Throwable
     */
    public static function run($callback)
    {
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
