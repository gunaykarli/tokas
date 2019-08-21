<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsLimit extends Model
{
    //protected $guarded = [];
    protected $fillable = ['tariff_id', 'valid_from', 'valid_to', 'limit', 'remaining_amount'];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setLimit($tariffID, $request){
        if($request->isLimited == 'on'){
            $tariffsLimit = new TariffsLimit();
            $tariffsLimit->tariff_id = $tariffID;
            $tariffsLimit->valid_from = $request->limitValidFrom;
            $tariffsLimit->valid_to = $request->limitValidTo;
            $tariffsLimit->limit = $request->limit;
            $tariffsLimit->remaining_amount = $request->limit; // since the tariff has just been created...It will be decreased by 1 as the tariff is sold.
            $tariffsLimit->save();
        }
    }


    /**
     * forwated from VodafoneTariffController@update
     */
    public function updateLimit($tariffID, $request){

        if($request->isLimited == 'on'){
            $tariffsLimit = TariffsLimit
                ::where('tariff_id', $tariffID)
                ->first();
            $tariffsLimit->tariff_id = $tariffID;
            $tariffsLimit->valid_from = $request->limitValidFrom;
            $tariffsLimit->valid_to = $request->limitValidTo;
            $tariffsLimit->limit = $request->limit;
            // If the limit of the tariff has been increased or has no change, the remaining_amount is updated according to the below formula.
            $tariffsLimit->remaining_amount = $tariffsLimit->remaining_amount + ($request->limit - $tariffsLimit->limit);
            $tariffsLimit->update();
        }
        else{
            $tariffsLimit = TariffsLimit
                ::where('tariff_id', $tariffID)
                ->first();
            // Give a warning message that limit of the tariff will be deleted permanently. Varsa kalan miktarı göster vs.
            $tariffsLimit->delete();
            //Limit silinince ne oluyor? Status disable or?
        }
    }

}
