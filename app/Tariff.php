<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $guarded = [];

    public function properties(){
        return $this->belongsToMany(Property::class);
    }

    public function regions(){
        return$this->belongsToMany(Region::class);
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function dealers(){
        //** "ontop" is pivot table for many to many relationship between dealer and tariff
        // Generally it is defined as dealer_tariff but in this case we have special name "ontop" */
        return $this->belongsToMany(Dealer::class, 'ontop');
    }

    public function vodafoneTariff(){
        return $this->hasOne(VodafoneTariff::class);
    }

    public function tariffsHighlights(){
        return $this->hasMany(TariffsHighlight::class);
    }

    public function tariffsProvisions(){
        return $this->hasMany(TariffsProvision::class);
    }

    public function tariffsLimitInfos(){
        return $this->hasMany(TariffsLimitInfo::class);
    }

    public function tariffsGroup(){
        return $this->belongsTo(TariffsGroup::class);
    }
}
