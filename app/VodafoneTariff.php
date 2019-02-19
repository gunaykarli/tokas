<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VodafoneTariff extends Model
{
    protected $fillable = ['tariff_id'];

    //* Relationships with the other Models (Classes)
    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

    public function services(){
        return  $this->belongsToMany(Service::class);
    }

    public function lawTexts(){
        return $this->belongsToMany(LawText::class);
    }

    public function plausibility(){
        return $this->hasOne(Plausibility::class);
    }

    public function createVodafoneTariff($tariffID){
        $vodafoneTariff = new VodafoneTariff();
        $vodafoneTariff->tariff_id = $tariffID;
        $vodafoneTariff->save();
    }

}
