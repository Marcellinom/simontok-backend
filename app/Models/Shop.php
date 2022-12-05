<?php

namespace App\Models;

use App\Models\Shared\Helper;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory, Helper;

    private ?int $id;
    private int $user_id;
    private string $name;
    private DateTime $created_at;

    /**
     * @param int|null $id
     * @param int $user_id
     * @param string $name
     * @param DateTime $created_at
     */
    public function __construct(?int $id, int $user_id, string $name, DateTime $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->created_at = $created_at;
        parent::__construct([
            'id' => $id,
            'user_id' => $user_id,
            'name' => $name,
            'created_at' => $created_at
        ]);
    }

    public static function persist(self $shop)
    {
        DB::table(self::getTable())->upsert(
            [
                'id' => $shop->getId(),
                'user_id' => $shop->getUserId(),
                'name' => $shop->getName(),
                'created_at' => $shop->getCreatedAt()
            ], 'id'
        );
    }

    protected $table = 'shop';

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public $timestamps = false;

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
}
