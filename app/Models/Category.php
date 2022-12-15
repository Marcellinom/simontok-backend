<?php

namespace App\Models;

use App\Models\Shared\Helper;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Helper;

    protected $fillable = [
        'name', 'shop_id', 'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $table = 'category';

    public $timestamps = false;

//    private int $id;
//    private int $shop_id;
//    private string $name;
//    private DateTime $created_at;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shop_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
