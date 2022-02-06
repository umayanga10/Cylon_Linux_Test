<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'region_id',
        'territory_id',
        'user_id',
        'po_date',
        'po_number',
        'remark'
    ];

    public function zone() {

        return $this->belongsTo(Zone::class);

    }

    public function region() {

        return $this->belongsTo(Region::class);

    }

    public function territory() {

        return $this->belongsTo(Territory::class);

    }

    public function user() {

        return $this->belongsTo(User::class);

    }

    public function purchaseOrderItemList() {

        return $this->hasMany(PurchaseOrderItemList::class);

    }
    

}
