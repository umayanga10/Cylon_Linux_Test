<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['region_code', 'region_name', 'zone_id'];

    public function zone() {

        return $this->belongsTo(Zone::class);

    }

    public function territory() {

        return $this->hasMany(Territory::class);

    }

    public function purchaseOrderHeader() {
        
        return $this->hasMany(PurchaseOrderHeader::class);
        
    }
}
