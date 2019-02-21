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
        return $this->belongsToMany(Service::class, 'service_vodafonetariff', 'vodafone_tariff_id', 'service_id')
            ->withPivot('property', 'is_favorite');
        //** property and is_favorite are extra attributes of the pivot table.*/ */
    }

    public function lawTexts(){
        return $this->belongsToMany(LawText::class);
    }

    public function plausibility(){
        return $this->hasOne(Plausibility::class);
    }

    //** manageCreationProcess() manages all the activities related to creation of new Vodafone Tariff
    // called from TariffController@store() */
    public function manageCreationProcess($tariff,  $request)
    {
        //** Create a new Vodafone Tariff in VodafoneTariff table.
        // Note that $this refers to VodafoneTariff instance
        // $tariff refers to main tarif that vodafone belongs to.*/
        $this->tariff_id = $tariff->id;
        $this->save();

        //** Set the Vodafone Tariff PLAUSIBILITY  of the newly created tariff */
        $VFPlausibility = new Plausibility();
        $VFPlausibility->setPlausibility($this->id, $request);

        //** Set the SERVICE of the newly created vodafone tariff */
        $service = new Service();
        $service->setVodafoneTariffServices($this, $request);
    }
}
