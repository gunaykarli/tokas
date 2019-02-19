<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsHighlight extends Model
{
    //protected $guarded = [];
    protected $fillable = ['tariff_id', 'highlight_short', 'highlight'];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

    public function setHighlight($tariffID, $request){

        //** Save tariff highlight. Loop control variable is 5 since in create.blade.php 5 place for the highlight has been established dynamically using for loop   */
        for($i = 0; $i<5; $i++){
            $tariffHighlight = new TariffsHighlight();
            if($request->inputOfShortHighlight[$i] != Null){
                $tariffHighlight->tariff_id = $tariffID;
                $tariffHighlight->highlight_short = $request->inputOfShortHighlight[$i];
                $tariffHighlight->highlight = $request->inputOfShortHighlightX[$i];
                $tariffHighlight->save();
            }
        }
    }
}
