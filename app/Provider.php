<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ['name'];

    public function addresses(){
        return $this->hasMany(Address::class, 'entity_id');
    }

    public function regions(){
        return $this->hasMany(Region::class);
    }

    public function representatives(){
        return $this->hasMany(Representative::class);
    }

    public function postcodeRegionVBs(){
        return $this->hasMany(PostcodeRegionVb::class);
    }
}
