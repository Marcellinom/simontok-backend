<?php

namespace App\Models;

use App\Models\Shared\Helper;
use App\Models\Shared\SimontokClassTrait;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Marketplace extends Model
{
    use HasFactory, SerializesModels, Helper;

    protected $table = 'marketplace';

//    private ?int $id;
//    private int $shop_id;
//    private string $name;
//    private DateTime $created_at;
//

    public static function persist(self $marketplace): void
    {
        DB::table($marketplace->table)->upsert(
            [
                'id' => $marketplace->getId(),
                'shop_id' => $marketplace->getShopId(),
                'name' => $marketplace->getName(),
                'created_at' => $marketplace->getCreatedAt()->getTimestamp(),
            ], 'id'
        );
    }

    protected $fillable = [
        'id', 'shop_id', 'name', 'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * @return Collection<Product>
     */
    public function products(): Collection
    {
        $res = $this->hasMany(Product::class, 'marketplace_id', 'id')->get();
        return $res->filter(fn ($product) => $product instanceof Product);
    }

    /**
     * @return Shop|null
     */
    public function shop(): Shop|null
    {
        $res = $this->belongsTo(Shop::class, 'shop_id', 'id')->first();
        return $res instanceof Shop ? $res : null;
    }

    public function user(): User|null
    {
        return $this->shop()->user();
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

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }
}
