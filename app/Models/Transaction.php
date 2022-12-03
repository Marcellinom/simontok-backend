<?php

namespace App\Models;

use App\Models\Shared\SimontokClassTrait;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, SimontokClassTrait;

    public const STATUS = [
        'cancelled' => -1,
        'waiting_payment' => 0,
        'paid' => 1
    ];

    public static function STATUS(string $value)
    {

    }

    public const ATTRIBUTES = [
        'id' => 'int',
        'pembeli_id' => Pembeli::ATTRIBUTES['id'],
        'created_at' => DateTime::class,
        'status' => 'string'
    ];
}
