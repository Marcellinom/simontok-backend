<?php

namespace App\Models;

use App\Exceptions\ExpectedException;
use App\Models\Shared\Helper;
use App\Models\Shared\SimontokClassTrait;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use function array_flip;
use function array_key_exists;
use function gettype;
use function is_numeric;

class ProductMovement extends Model
{
    use HasFactory, Helper;

    protected $table = 'product_movement';

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

//    private string $id;
//    private ?string $reference_id;
//    private int $user_id;
//    private int $product_id;
//    private int $direction;
//    private float $quantity;
//    private DateTime $created_at;

    protected $fillable = [
        'id', 'user_id', 'product_id', 'direction', 'quantity', 'created_at'
    ];

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

    public function isDirection(int $direction): bool
    {
        return $this->direction == $direction;
    }

    /**
     * @throws Exception
     */
    public function getDirection(): string
    {
        $direction_flipped = array_flip(self::DIRECTION);
        if (is_numeric($this->direction) && gettype((int)$this->direction) == 'integer')
            return $direction_flipped[$this->direction];
        if (array_key_exists($this->direction, self::DIRECTION))
            return $this->direction;
        ExpectedException::throw("invalid parsed direction type", 2030);
    }

    /**
     * @throws Exception
     */
    public static function generate(int $user_id, int $product_id, string $direction, float $quantity): ProductMovement
    {
        return new ProductMovement([
            'id' => Uuid::uuid4()->toString(),
            'product_id' => $product_id,
            'user_id' => $user_id,
            'direction' => $direction,
            'quantity' => $quantity,
        ]);
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getReferenceId(): ?string
    {
        return $this->reference_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }
}
