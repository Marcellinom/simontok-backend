<?php

namespace App\Models;

use App\Models\Shared\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory, Helper;
    protected $table = 'transaction_items';
    public $timestamps = false;
//    private int $transaction_id;
//    private int $product_id;
//    private float $quantity;

    protected $fillable = ['transaction_id', 'product_id'. 'quantity'];

    public function product(): Product|null
    {
        $res = $this->hasOne(Product::class, 'id', 'product_id')->first();
        return $res instanceof Product ? $res : null;
    }

    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transaction_id;
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
}
