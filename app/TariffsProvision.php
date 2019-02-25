<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsProvision extends Model
{
    //protected $guarded = [];
    protected $fillable = ['tariff_id', 'status', 'base_price', 'provision', 'valid_from', 'valid_to'];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

    public function setProvision($tariffID, $request){

        //** Set the provision of the newly created tariff
        // Called from TariffController@store*/
        $tariffProvision = new TariffsProvision();
        $tariffProvision->tariff_id = $tariffID;
        $tariffProvision->status = 2; // 2 means that the provision will be activated on the date indicated in "valid_from" field.
        $tariffProvision->base_price = $request->basePrice;
        $tariffProvision->provision = $request->provision;
        $tariffProvision->valid_from = $request->provisionValidFrom;

        if($request->provisionValidToIndefinite == 'on')
            $tariffProvision->valid_to = null;
        else
            $tariffProvision->valid_to = $request->provisionValidTo;

        $tariffProvision->save();
    }
}
