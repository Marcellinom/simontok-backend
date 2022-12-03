<?php

namespace App\Models;

use App\Models\Shared\SimontokClassTrait;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pembeli
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Pembeli newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pembeli newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pembeli query()
 * @mixin \Eloquent
 * @method int getId()
 * @method self setId(int $id)
 * @method int getUserId()
 * @method self setUserId(int $user_id)
 * @method string getAlamat()
 * @method self setAlamat(string $alamat)
 * @method DateTime|null getCreatedAt()
 * @method self setCreatedAt(DateTime $created_at = null)
 */
class Pembeli extends Model
{
    use HasFactory, SimontokClassTrait;

    protected $table = 'pembeli';

    public const ATTRIBUTES = [
        'id' => 'int',
        'user_id' => User::ATTRIBUTES['id'],
        'alamat' => 'string',
        'created_at' => DateTime::class.'|null'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $fillable = [
        'user_id',
        'alamat'
    ];

    public static function persist(self $pembeli)
    {
        DB::table('pembeli')->upsert(
            [
                'id' => $pembeli->getId(),
                'user_id' => $pembeli->getUserId(),
                'alamat' => $pembeli->getAlamat(),
                'created_at' => $pembeli->getCreatedAt() ?? Carbon::now()->getTimestamp()
            ], 'id'
        );
    }

    public function user(): Model|User|null
    {
        $res = $this->belongsTo(User::class, 'id', 'user_id')->first();
        return $res instanceof User ? $res : null;
    }
}
