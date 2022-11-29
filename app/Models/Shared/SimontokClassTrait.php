<?php

namespace App\Models\Shared;

use function dd;
use function explode;
use function preg_replace;
use function strtolower;

trait SimontokClassTrait
{
    function __call($method, $parameters)
    {
        // getMethodName jadi get_method_name
        $method_name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $method));
        // get_method_name jadi [get, method_name]
        $method_name = explode('_', $method_name, 2);

        if (($method_name[0] === 'get' or $method_name[0] === 'is') and self::ATTRIBUTES[$method_name[1]] !== null) {
            $attr = $method_name[1];
            return $this->$attr;
        }
        if ($method_name[0] === 'set' and self::ATTRIBUTES[$method_name[1]] !== null) {
            $atr = $method_name[1];
            $this->$atr = $parameters[0];
            return $this;
        }
        return parent::__call($method, $parameters);
    }
}