<?php

namespace App\Models;

use App\Exceptions\ExpectedException;
use App\Models\Shared\SimontokClassTrait;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use function array_key_exists;

/**
 * App\Models\ProductMovement
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement query()
 * @mixin \Eloquent
 * @method string getId()
 * @method self setId(string $id)
 * @method string|null getReferenceId()
 * @method self setReferenceId(string $reference_id = null)
 * @method int getUserId()
 * @method self setUserId(int $user_id)
 * @method int getProductId()
 * @method self setProductId(int $product_id)
 * @method int getDirection()
 * @method self setDirection(int $direction)
 * @method float getQuantity()
 * @method self setQuantity(float $quantity)
 * @method DateTime|null getCreatedAt()
 * @method self setCreatedAt(DateTime $created_at = null)
 * @property int $id
 * @property string|null $reference_id
 * @property int $user_id
 * @property int $product_id
 * @property string $direction
 * @property float $quantity
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMovement whereUserId($value)
 */
class ProductMovement extends Model
{
    use HasFactory, SimontokClassTrait;

    protected $table = 'product_movement';

    public const DIRECTION = [
        'out' => 0,
        'in' => 1,
    ];

    /**
     * @throws Exception
     */
    public static function DIRECTION(string $direction): int
    {
        if (!array_key_exists($direction, self::DIRECTION))
            ExpectedException::throw("invalid direction enum", 2026);

        return self::DIRECTION[$direction];
    }

    /**
     * @throws Exception
     */
    public static function generate(int $user_id, int $product_id, string $direction, float $quantity): ProductMovement
    {
        $product_movement = new ProductMovement();
        $product_movement->setId(Uuid::uuid4()->toString())
            ->setProductId($product_id)
            ->setUserId($user_id)
            ->setDirection(self::DIRECTION($direction))
            ->setQuantity($quantity);
        return $product_movement;
    }

    public const ATTRIBUTES = [
        'id' => 'string',
        'reference_id' => 'string|null', // nge referensiin id sebelumnya untuk menghindari race condition
        'user_id' => User::ATTRIBUTES['id'],
        'product_id' => Product::ATTRIBUTES['id'],
        'direction' => 'int',
        'quantity' => 'float',
        'created_at' => DateTime::class.'|null'
    ];

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        parent::__construct();
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
