<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsProvision extends Model
{
    protected $guarded = [];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }
}
