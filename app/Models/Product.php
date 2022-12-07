<?php

namespace App\Models;

use App\Models\Shared\Helper;
use App\Models\Shared\SimontokClassTrait;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Helper;

    protected $table = 'product';

//    private ?int $id;
//    private int $marketplace_id;
//    private string $name;
//    private float $unit_price;
//    private string $image;
//    private string $category;
//    private DateTime $created_at;

    protected $fillable = [
        'id', 'marketplace_id', 'name', 'unit_price', 'created_at', 'image', 'category'
    ];

    public static function persist(self $product)
    {
        DB::table($product->table)->upsert([
            'id' => $product->getId(),
            'marketplace_id' => $product->getMarketplaceId(),
            'name' => $product->getName(),
            'unit_price' => $product->getUnitPrice(),
            'created_at' => $product->getCreatedAt()->getTimestamp(),
            'image' => $product->getImage(),
            'category' => $product->getCategory()
        ], 'id');
    }

    public function marketplace(): ?Marketplace
    {
        $res = $this->belongsTo(Marketplace::class, 'id', 'marketplace_id')->first();
        return $res instanceof Marketplace ? $res : null;
    }


    /**
     * @return Collection<ProductMovement>
     */
    public function productMovement(): Collection
    {
        $res = $this->hasMany(ProductMovement::class, 'product_id', 'id')->get();
        return $res->filter(fn ($item) => $item instanceof ProductMovement);
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param float $unit_price
     */
    public function setUnitPrice(float $unit_price): void
    {
        $this->unit_price = $unit_price;
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
    public function getMarketplaceId(): int
    {
        return $this->marketplace_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unit_price;
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

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }
}
