<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductMovement;
use Carbon\Carbon;
use DB;
use Doctrine\DBAL\Query\QueryException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class AddProductMovementJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private string $id;
    private int $user_id;
    private int $product_id;
    private int $direction;
    private float $quantity;

    /**
     * @param string $id
     * @param int $user_id
     * @param int $product_id
     * @param int $direction
     * @param float $quantity
     */
    public function __construct(string $id, int $user_id, int $product_id, int $direction, float $quantity)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->direction = $direction;
        $this->quantity = $quantity;
    }

    public static function publish(ProductMovement $product_movement)
    {
        self::dispatch(
            $product_movement->getId(),
            $product_movement->getUserId(),
            $product_movement->getProductId(),
            $product_movement->getDirection(),
            $product_movement->getQuantity()
        );
    }

    /**
     * @throws Throwable
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $latest_movement = DB::table('product_movement')
                ->orderBy('created_at', 'desc')
                ->first();

            DB::table('product_movement')->insert([
                'id' => $this->id,
                'reference_id' => $latest_movement?->id,
                'user_id' => $this->user_id,
                'product_id' => $this->product_id,
                'direction' => (string)$this->direction,
                'quantity' => $this->quantity,
                'created_at' => Carbon::now()->getTimestamp()
            ]);
        } catch (QueryException $exception) {
            DB::rollBack();
            if ($exception[1] == 1062) $this->release(1);
            else throw new Exception($this->direction);
        } catch (Throwable $exception) {
            DB::rollBack();
            throw new $exception;
        }
        DB::commit();
    }
}
