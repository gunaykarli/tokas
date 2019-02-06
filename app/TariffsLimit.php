<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsLimit extends Model
{
    protected $guarded = [];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

}
