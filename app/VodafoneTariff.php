<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VodafoneTariff extends Model
{
    protected $guarded = [];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

    public function services(){
        return  $this->belongsToMany(Service::class);
    }

    public function lawTexts(){
        return $this->belongsToMany(LawText::class);
    }
}
