<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsHighlight extends Model
{
    //protected $guarded = [];
    protected $fillable = ['tariff_id', 'highlight_type', 'content'];

    protected $casts = [
        'content' => 'array',
    ];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

    public function setHighlight($tariffID, $request){


        //** Save tariff highlight. Loop control variable is 5 since in create.blade.php 5 place for the highlight has been established dynamically using for loop

        for($i = 0; $i<2; $i++){
            $tariffHighlight = new TariffsHighlight();

            $highlightExist = 0;
            if($request->texts3P2T1[$i] != Null) {
                $content['text1'] = $request->texts3P2T1[$i];
            }
            if($request->texts3P2T2[$i] != Null)
                $content['text2'] = $request->texts3P2T2[$i];

            if($request->propertyIDs3P2T1[$i] != Null)
                $content['property1'] = $request->propertyIDs3P2T1[$i];
            if($request->propertyIDs3P2T2[$i] != Null)
                $content['property2'] = $request->propertyIDs3P2T2[$i];
            if($request->propertyIDs3P2T3[$i] != Null)
                $content['property3'] = $request->propertyIDs3P2T3[$i];


            $tariffHighlight->tariff_id = $tariffID;
            $tariffHighlight->highlight_type = 1;
            $tariffHighlight->content = $content;
            $tariffHighlight->save();

            $out = new Output();
            $out->output3 = $tariffID;
            $out->save();

        }

    }
}