<?php

namespace App\Models;

use App\Models\Shared\Helper;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Transaction extends Model
{
    use HasFactory, Helper;
    protected $table = 'transaction';
    public $timestamps = false;
//    private int $id;
//    private int $marketplace_id;
//    private float $total_price;
//    private DateTime $created_at;
//    /**
//     * @var Collection<TransactionItem>
//     */
//    private Collection $items;

    protected $fillable = [
        'marketplace_id', 'total_price', 'created_at'
    ];

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return gettype($this->created_at) == 'integer' ? Carbon::createFromTimestamp($this->created_at) : $this->created_at;
    }

    /**
     * @return Collection<TransactionItem>
     */
    public function getItems(): Collection
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'id')->get()->filter(fn ($res) => $res instanceof TransactionItem);
    }

    /**
     * @return int
     */
    public function getId(): int
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
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->total_price;
    }
}
