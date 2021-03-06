<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InventoryMovementItem
 *
 * @package App\Models
 */
class InventoryMovementItem extends Model
{
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productItem()
    {
        return $this->belongsTo(Product::class, 'product_item_id');
    }
}