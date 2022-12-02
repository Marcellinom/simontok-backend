<?php

namespace App\Models;

use App\Models\Shared\SimontokClassTrait;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory, SimontokClassTrait;

    public const ATTRIBUTES = [
        'id' => 'int',
        'user_id' => User::ATTRIBUTES['id'],
        'alamat' => 'string',
        'created_at' => DateTime::class.'|null'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        parent::__construct();
    }

    public function user(): Model|User|null
    {
        $res = $this->belongsTo(User::class, 'id', 'user_id')->first();
        return $res instanceof User ? $res : null;
    }
}
