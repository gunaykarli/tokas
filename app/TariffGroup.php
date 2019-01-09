<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffGroup extends Model
{
    protected $guarded = [];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function tariffs(){
        return $this->hasMany(Tariff::class);
    }

}
