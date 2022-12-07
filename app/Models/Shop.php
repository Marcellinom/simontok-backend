<?php

namespace App\Models;

use App\Models\Shared\Helper;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shop
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property string $image
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUserId($value)
 * @mixin \Eloquent
 */
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
