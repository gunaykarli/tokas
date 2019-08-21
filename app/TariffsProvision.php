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

    // renew the provision of a vodofone tariff.
    // forwarded from "resources/views/tariffs/vodafone/provisionSetup.blade.php" via "public/js/provisionSetup.js"
    public static function renewVodafoneProvision($request){

        //** renew the provision of the tariffs
        // Called from TariffsProvisionController@storeForTariff*/

        // tariffs are fetched to reach the id of the tariff which will be used "newProvisions[$tariff->id]"
        // No other way exists to determine tariff whose provision are to be upgraded.
        $tariffs = Tariff
            ::where('provider_id', 1)
            ->where('group_id', $request->tariffGroup)
            ->get();

        if($request->forAllTariffs == 'on'){
            foreach($tariffs as $tariff){
                $tariffProvision = new TariffsProvision();

                $tariffProvision->tariff_id = $tariff->id;
                $tariffProvision->status = 2; // 2 means that the provision will be activated on the date indicated in "valid_from" field.
                $tariffProvision->base_price = $tariff->base_price;
                $tariffProvision->provision = $request->provisionForAll;
                $tariffProvision->valid_from = $request->provisionValidToForAll;

                $tariffProvision->save();
            }
        }
        else{
            foreach($tariffs as $tariff){
                $tariffProvision = new TariffsProvision();

                if ($request->newProvisions[$tariff->id] != ""){
                    $tariffProvision->tariff_id = $tariff->id;
                    $tariffProvision->status = 2; // 2 means that the provision will be activated on the date indicated in "valid_from" field.
                    $tariffProvision->base_price = $tariff->base_price;
                    $tariffProvision->provision = $request->newProvisions[$tariff->id];
                    $tariffProvision->valid_from = $request->newValidFroms[$tariff->id];

                    $tariffProvision->save();
                }
            }
        }

        //echo " " . ($request->newProvisions[$tariff->id]) ;
        //dd("stop");

        return redirect()->back()->with('message', 'success');
    }
}
