<?php

namespace App\Models;

use App\Models\Shared\SimontokClassTrait;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Marketplace
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marketplace query()
 * @mixin \Eloquent
 * @method int getId()
 * @method void setId(int $id)
 * @method int getUserId()
 * @method void setUserId(int $user_id)
 * @method string getName()
 * @method void setName(string $name)
 * @method DateTime|null getCreatedAt()
 * @method void setCreatedAt(DateTime $created_at = null)
 */
class Marketplace extends Model
{
    use HasFactory, SimontokClassTrait;

    protected $table = 'marketplace';

    public const ATTRIBUTES = [
        'id' => 'int',
        'user_id' => User::ATTRIBUTES['id'],
        'name' => 'string',
        'created_at' => DateTime::class.'|null',
    ];

    public function persist(): void
    {
        DB::table($this->table)->upsert(
            [
                'id' => $this->getId(),
                'user_id' => $this->getUserId(),
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

    public function user(): User|null
    {
        $res = $this->belongsTo(User::class, 'id', 'user_id')->first();
        return $res instanceof User ? $res : null;
    }
}
