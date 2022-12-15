<?php

namespace App\Models;

use App\Models\Shared\Helper;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Shop extends Model
{
    use HasFactory, Helper;

//    private ?int $id;
//    private int $user_id;
//    private string $name;
//    private string $image;
//    private DateTime $created_at;


    protected $fillable = [
        'id', 'user_id', 'name', 'created_at', 'image'
    ];

    public static function persist(self $shop)
    {
        DB::table((new self())->table)->upsert(
            [
                'id' => $shop->getId(),
                'user_id' => $shop->getUserId(),
                'name' => $shop->getName(),
                'image' => $shop->getImage(),
                'created_at' => $shop->getCreatedAt()->getTimestamp()
            ], 'id'
        );
    }

    protected $table = 'shop';

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public $timestamps = false;

    public function user(): Model|User|null
    {
        $res = $this->belongsTo(User::class, 'user_id', 'id')->first();
        return $res instanceof User ? $res : null;
    }

    /**
     * @return Collection<Category>
     */
    public function category(): Collection
    {
        $res = $this->hasMany(Category::class, 'id', 'shop_id')->get();
        return $res->filter(fn ($res) => $res instanceof Category);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
}
