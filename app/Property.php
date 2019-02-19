<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];

    public function tariffs(){
        return $this->belongsToMany(Tariff::class)->withPivot('value');
    }

    public function setProperties($tariff, $request){
        // According to inputOfProperties in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_property) of Property and Tariff is set.
        // Since inputOfProperties takes its names' values from the Property table.,
        // we need to check if the key exist in the array inputOfProperty, if so, use the value sent from the form. */

        $properties = Property::all();
        foreach($properties as $property){
            if($request->inputOfProperties[$property->id] != Null)
                $tariff->properties()->attach($property->id, ['value' => $request->inputOfProperties[$property->id]]);
            /*
            if(array_key_exists($property->id, $request->inputOfProperties)){
                $tariff->properties()->attach($property->id, ['value' => $request->inputOfProperties[$property->id]]);
            }
            */
        }
    }
}
