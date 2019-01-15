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

    public function tariffGroup(){
        return $this->belongsTo(TariffGroup::class);
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

}
