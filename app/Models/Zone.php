<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['zone_code', 'zone_long_description', 'zone_short_description'];

    public function region() {

        return $this->hasMany(Region::class);

    }

    public function territory() {

        return $this->hasMany(Territory::class);

    }

    public function purchaseOrderHeader() {
        
        return $this->hasMany(PurchaseOrderHeader::class);
        
    }
    
}
