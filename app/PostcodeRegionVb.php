<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostcodeRegionVb extends Model
{
    protected $fillable = ['postcode', 'provider_id', 'region_id', 'primary_VB_id', 'secondary_VB_id'];

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function representative(){
        return $this->belongsTo(Representative::class);
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function postcode(){
        return $this->belongsTo(Postcode::class);
    }

    public function dealerRegionVBs(){
        return $this->hasMany(DealerRegionVb::class, 'dealer_postcode');
    }
}
