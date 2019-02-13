<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    //protected $guarded = [];
    protected $fillable = ['name', 'tariff_code', 'status', 'main_group_id', 'sub_group_id', 'provider_id', 'made_by_toker', 'base_price', 'provision', 'valid_from', 'valid_to', 'is_limited'];

    public function properties(){
        return $this->belongsToMany(Property::class);
    }

    public function regions(){
        return $this->belongsToMany(Region::class, 'tariff_region')->withPivot('provider_id');
        //** Eloquent will join the two related model names in alphabetical order. However, you are free to override this convention.
        // Normally the name of the pivot table is 'region_tariff'. We have overrided this convention
        // additionally provider_id is extra attribute of the pivot table.*/
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
