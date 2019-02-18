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

        $out = new Output();
        $out->output1 = $request->inputOfShortHighlight[0];
        $out->output2 = $request->inputOfShortHighlightX[0];
        $out->output3 = $tariffID;
        $out->save();

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
