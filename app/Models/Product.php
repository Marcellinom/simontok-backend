<?php

namespace App\Models;

use App\Models\Shared\SimontokClassTrait;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $marketplace_id
 * @property string $name
 * @property float $unit_price
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMarketplaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitPrice($value)
 * @method int getId()
 * @method self setId(int $id)
 * @method int getMarketplaceId()
 * @method self setMarketplaceId(int $marketplace_id)
 * @method string getName()
 * @method self setName(string $name)
 * @method float getUnitPrice()
 * @method self setUnitPrice(float $unit_price)
 * @method DateTime|null getCreatedAt()
 * @method self setCreatedAt(DateTime $created_at = null)
 */
class Product extends Model
{
    use HasFactory, SimontokClassTrait;

    protected $table = 'product';

    public const ATTRIBUTES = [
        'id' => 'int',
        'marketplace_id' => 'int',
        'name' => 'string',
        'unit_price' => 'float',
        'created_at' => DateTime::class.'|null'
    ];

    public function persist()
    {
        DB::table('product')->upsert([
            'id' => $this->getId(),
            'marketplace_id' => $this->getMarketplaceId(),
            'name' => $this->getName(),
            'unit_price' => $this->getUnitPrice(),
            'created_at' => $this->getCreatedAt() ? $this->getCreatedAt()->getTimestamp() : null,
        ], 'id');
    }

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        parent::__construct();
    }

    public function marketplace(): ?Marketplace
    {
        $res = $this->belongsTo(Marketplace::class, 'id', 'marketplace_id')->first();
        return $res instanceof Marketplace ? $res : null;

    }

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
