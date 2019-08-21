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
        return $this->belongsToMany(Tariff::class, 'tariff_region')->withPivot('provider_id')->withTimestamps();
        //** Eloquent will join the two related model names in alphabetical order. However, you are free to override this convention.
        // Normally the name of the pivot table is 'region_tariff'. We have overrided this convention
        // additionally provider_id is extra attribute of the pivot table.*/
    }

    /** User Defined Functions */

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setVodafoneRegions($tariff, $request){
        // According to checkboxOfRegion in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_region) of Region and Tariff is set.
        // Since checkboxOfRegions takes its names' values from the Region table according to the active provider,
        // we need to check if the key exist in the array, if so, control, if it has been checked. */
        $regions = Region::where('provider_id', $request->providerID)->get();

        //** If 'All Regions' checkbox is checked then all regions is save to the tariff_region pivot table  */
        if($request->allRegions == 'on'){
            foreach($regions as $region){
                $tariff->regions()->attach($region->id, ['provider_id' => $request->providerID]);
            }
        }
        else{
            foreach($regions as $region){
                if(array_key_exists($region->id, $request->checkboxOfRegions)) {
                    if($request->checkboxOfRegions[$region->id] == 'on')
                        $tariff->regions()->attach($region->id, ['provider_id' => $request->providerID]);
                }
            }
        }

    }

    /**
     * forwated from VodafoneTariffController@update
     */
    public function updateVodafoneRegions($tariff, $request){
        // According to checkboxOfRegion in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_region) of Region and Tariff is set.
        // Since checkboxOfRegions takes its names' values from the Region table according to the active provider,
        // we need to check if the key exist in the array, if so, control, if it has been checked. */
        $regions = Region::where('provider_id', $request->providerID)->get();

        // First, detach all regions of the tariff  in the related pivot table...
        $tariff->regions()->detach();

        //** If 'All Regions' checkbox is checked then all regions is save to the tariff_region pivot table  */
        if($request->allRegions == 'on'){
            foreach($regions as $region){
                $tariff->regions()->attach($region->id, ['provider_id' => $request->providerID]);
            }
        }
        else{
            foreach($regions as $region){
                if(array_key_exists($region->id, $request->checkboxOfRegions)) {
                    if($request->checkboxOfRegions[$region->id] == 'on')
                        $tariff->regions()->attach($region->id, ['provider_id' => $request->providerID]);
                }
            }
        }

    }
}
