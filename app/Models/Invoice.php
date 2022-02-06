<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'purchase_order_header_id'
    ];

    public function purchaseOrderHeader() {

        return $this->belongsTo(PurchaseOrderHeader::class);
    }

}
