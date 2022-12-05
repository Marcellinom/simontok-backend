<?php

namespace App\Models;

use App\Models\Shared\SimontokClassTrait;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

/**
 * App\Models\Marketplace
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace whereUserId($value)
 * @method int getId()
 * @method self setId(int $id)
 * @method int getShopId()
 * @method self setShopId(int $shop_id)
 * @method string getName()
 * @method self setName(string $name)
 * @method DateTime|null getCreatedAt()
 * @method self setCreatedAt(DateTime $created_at = null)
 */
class Marketplace extends Model
{
    use HasFactory, SimontokClassTrait, SerializesModels;

    protected $table = 'marketplace';

    public const ATTRIBUTES = [
        'id' => 'int',
        'shop_id' => 'int',
        'name' => 'string',
        'created_at' => DateTime::class.'|null',
    ];

    public function persist(): void
    {
        DB::table($this->table)->upsert(
            [
                'id' => $this->getId(),
                'shop_id' => $this->getUserId(),
                'name' => $this->getName(),
                'created_at' => $this->getCreatedAt() ? $this->getCreatedAt()->getTimestamp() : null,
            ], 'id'
        );
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        parent::__construct();
    }

    /**
     * @return Collection<Product>
     */
    public function products(): Collection
    {
        $res = $this->hasMany(Product::class, 'marketplace_id', 'id')->get();
        return $res->filter(fn ($product) => $product instanceof Product);
    }
}
