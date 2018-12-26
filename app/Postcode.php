<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    protected $fillable = ['postcode', 'district', 'city', 'city', 'state', 'country'];

    public function postcodeRegionVBs(){
        return $this->hasMany(PostcodeRegionVb::class);
    }
}
