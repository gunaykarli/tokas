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
        return $this->belongsToMany(Dealer::class, 'ontop');
    }
}
