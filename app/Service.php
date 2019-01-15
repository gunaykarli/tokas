<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    public function vodafoneTariffs(){
        return $this->belongsToMany(VodafoneTariff::class, 'mandotary_exclusion');
    }
}
