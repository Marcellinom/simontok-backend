<?php

namespace App\Models;

use App\Exceptions\ExpectedException;
use App\Models\Shared\SimontokClassTrait;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use function config;

/**
 * App\Models\Otp
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Otp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Otp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Otp query()
 * @mixin \Eloquent
 * @method int getUserId()
 * @method void setUserId(int $user_id)
 * @method int getOtp()
 * @method void setOtp(int $otp)
 * @method DateTime getCreatedAt()
 * @method void setCreatedAt(DateTime $created_at)
 * @method DateTime getCooldown()
 * @method void setCooldown(DateTime $cooldown)
 * @property int $user_id
 * @property int $otp
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $cooldown
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereCooldown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereUserId($value)
 */
class Otp extends Model
{
    use HasFactory, SimontokClassTrait;

    protected $table = 'otp';

    public $timestamps = false;

    private Mailable $mailable;

    public function persist()
    {
        DB::table($this->table)->upsert(
            [
                'user_id' => $this->getUserId(),
                'otp' => $this->getOtp(),
                'created_at' => $this->getCreatedAt()->getTimestamp(),
                'cooldown' => $this->getCooldown()->getTimestamp(),
            ], 'user_id'
        );
    }

    /**
     * @throws \Exception
     */
    public static function generateForUser(User $user): self
    {
        if (null === $otp = self::where('user_id', $user->getId())->first()) {
            $otp = new self();
            $otp->setUserId($user->getId());
        } else if ($otp->getCooldown() > new DateTime()) {
            ExpectedException::throw('OTP is under cooldown', 1005, 400);
        }
        $otp->setOtp(random_int(1000, 9999));
        $otp->setCreatedAt(new DateTime());
        $otp->setCooldown(new DateTime('+5 minutes'));
        return $otp;
    }

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->mailable = new Mailable();
        parent::__construct();
    }

    public function build(): Mailable
    {
        return $this->mailable->from(config('mail.from'))
            ->subject('Email OTP Confirmation')
            ->markdown('email_otp', [
                'otp' => $this->getOtp(),
                'user_id' => $this->getUserId()
            ]);
    }

    protected $casts = [
        'created_at' => 'datetime',
        'cooldown' => 'datetime',
    ];

    public const ATTRIBUTES = [
        'user_id' => User::ATTRIBUTES['id'],
        'otp' => 'int',
        'created_at' => DateTime::class,
        'cooldown' => DateTime::class,
    ];
}
