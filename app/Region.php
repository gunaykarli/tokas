<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'abbreviation', 'provider_id'];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function representatives(){
        return $this->hasMany(Representative::class);
    }

    public function postcodeRegionVBs(){
        return $this->hasMany(PostcodeRegionVb::class);
    }

    public function tariffs(){
        return $this->belongsToMany(Tariff::class, 'tariff_region')->withPivot('provider_id');
        //** Eloquent will join the two related model names in alphabetical order. However, you are free to override this convention.
        // Normally the name of the pivot table is 'region_tariff'. We have overrided this convention
        // additionally provider_id is extra attribute of the pivot table.*/
    }
}
