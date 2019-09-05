<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];

    public function tariffs(){
        return $this->belongsToMany(Tariff::class)->withPivot('value');
    }

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setProperties($tariff, $request){

        // According to inputOfProperties in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_property) of Property and Tariff is set.
        // Since inputOfProperties takes its names' values from the Property table.,
        // we need to check if the key exist in the array inputOfProperty, if so, use the value sent from the form. */

        $properties = Property::all();
        foreach($properties as $property){
            if($property->data_type == 'boolean')
                //if($request->booleanInputOfProperties[$property->id] != Null)//****array_key_exists('first', $search_array)
                if(array_key_exists($property->id, $request->booleanInputOfProperties))
                    $tariff->properties()->attach($property->id, ['value' => 1]);
                else
                    $tariff->properties()->attach($property->id, ['value' => 0]);
            else
                //if($request->textInputOfProperties[$property->id] != Null)
                if(array_key_exists($property->id, $request->textInputOfProperties))
                    $tariff->properties()->attach($property->id, ['value' => $request->textInputOfProperties[$property->id]]);
        }
    }

    /**
     * forwated from VodafoneTariffController@update
     */
    public function updateProperties($tariff, $request){
        // According to inputOfProperties in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_property) of Property and Tariff is set.
        // Since inputOfProperties takes its names' values from the Property table.,
        // we need to check if the key exist in the array inputOfProperty, if so, use the value sent from the form. */

        // First, detach all properties of the tariff in the related pivot table...
        $tariff->properties()->detach();

        $properties = Property::all();
        foreach($properties as $property){
            if($property->data_type == 'boolean')
                if(array_key_exists($property->id, $request->booleanInputOfProperties))
                    $tariff->properties()->attach($property->id, ['value' => 1]);
                else
                    $tariff->properties()->attach($property->id, ['value' => 0]);
            else
                if(array_key_exists($property->id, $request->textInputOfProperties))
                    $tariff->properties()->attach($property->id, ['value' => $request->textInputOfProperties[$property->id]]);
        }
    }
}
