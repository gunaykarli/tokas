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

    public function setLimit($tariffID, $request){
        if($request->isLimited == 'on'){
            $tariffsLimit = new TariffsLimit();
            $tariffsLimit->tariff_id = $tariffID;
            $tariffsLimit->valid_from = $request->limitValidFrom;
            $tariffsLimit->valid_to = $request->limitValidTo;
            $tariffsLimit->limit = $request->limit;
            $tariffsLimit->remaining_amount = $request->limit; // since the tariff has just been created...It will be decreased by 1 as the tariff is sell.
            $tariffsLimit->save();
        }
    }
}
