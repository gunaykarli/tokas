<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'abbreviation', 'provider_id'];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function representatives(){
        return $this->hasMany(Representative::class);
    }

    public function postcodeRegionVBs(){
        return $this->hasMany(PostcodeRegionVb::class);
    }
}
