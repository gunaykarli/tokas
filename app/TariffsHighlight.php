<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsHighlight extends Model
{
    protected $guarded = [];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }
}
