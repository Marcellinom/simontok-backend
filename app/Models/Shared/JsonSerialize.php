<?php

namespace App\Models\Shared;

use JsonSerializable;

class JsonSerialize implements JsonSerializable
{
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data)
    {
        return new self($data);
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
