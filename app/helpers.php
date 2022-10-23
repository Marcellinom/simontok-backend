<?php

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
