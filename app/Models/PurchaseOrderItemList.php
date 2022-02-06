<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemList extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_header_id',
        'product_id',
        'enter_qty',
        'total_price',
    ];

    public function purchaseOrderHeader() {

        return $this->belongsTo(PurchaseOrderHeader::class);

    }

    public function product() {

        return $this->belongsTo(Product::class);

    }

}
