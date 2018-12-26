<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    protected $fillable = ['name', 'surname', 'provider_id', 'region', 'phone', 'email'];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function postcodeRegionVBs(){
        return $this->hasMany(PostcodeRegionVb::class);
    }
}
