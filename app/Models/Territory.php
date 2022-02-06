<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    use HasFactory;

    protected $fillable = ['territory_code', 'territory_name', 'zone_id', 'region_id'];

    public function zone() {

        return $this->belongsTo(Zone::class);

    }

    public function region() {

        return $this->belongsTo(Region::class);

    }

    public function user() {

        return $this->hasMany(User::class);

    }

    public function purchaseOrderHeader() {
        
        return $this->hasMany(PurchaseOrderHeader::class);
        
    }
}
