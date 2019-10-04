<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsHighlight extends Model
{
    //protected $guarded = [];
    protected $fillable = ['tariff_id', 'content'];


    protected $casts = [
        'content' => 'array',
    ];

    public function tariff(){
        return $this->belongsTo(Tariff::class);
    }

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setHighlight_content_as_array($tariffID, $request){


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

    /**
     * Saves tariff highlight.
     * forwated from VodafoneTariffController@store
     */
    public function setHighlight($tariffID, $request){

        // initialize content array with key-value pairs
        $content['internet1'] = '';
        $content['internet2'] = '';
        $content['internet3'] = '';
        $content['internet4'] = '';
        $content['SMS1'] = '';
        $content['SMS2'] = '';
        $content['SMS3'] = '';
        $content['SMS4'] = '';
        $content['telephony1'] = '';
        $content['telephony2'] = '';
        $content['telephony3'] = '';
        $content['telephony4'] = '';
        $content['other1'] = '';
        $content['other2'] = '';
        $content['other3'] = '';


        // depending on the value of the element in "resources/views/tariffs/vodafone/create.blade.php" in property section content for key 'internet', 'SMS' or 'telephony' should be set.
        $content['internet1'] = $request->highlight1; // In resources/views/tariffs/vodafone/create.blade.php, highlight1 text field is set to take internet highlight
        $content['SMS1'] = $request->highlight2; // highlight2 text field is set to take SMS highlight
        $content['telephony1'] = $request->highlight3; // highlight3 text field is set to take telephony highlight

        if($request->addNewAdvantageCheckbox1 == 'on'){
            if($request->nameOfPropertySelectBox1 != 0){
                if($request->textOfValue1 != ''){
                    if($request->nameOfPropertySelectBox1 == 1) // telephony
                        $content['telephony2'] = $request->textOfValue1;
                    else if($request->nameOfPropertySelectBox1 == 2) // internet
                        $content['internet2'] = $request->textOfValue1;
                    else if($request->nameOfPropertySelectBox1 == 3) // SMS
                        $content['SMS2'] = $request->textOfValue1;
                    else if($request->nameOfPropertySelectBox1 == 4) // other
                        $content['other1'] = $request->textOfValue1;
                }
            }
        }

        if($request->addNewAdvantageCheckbox2 == 'on'){
            if($request->nameOfPropertySelectBox2 != 0){
                if($request->textOfValue2 != ''){
                    if($request->nameOfPropertySelectBox2 == 1) // telephony
                        $content['telephony3'] = $request->textOfValue2;
                    else if($request->nameOfPropertySelectBox2 == 2) // internet
                        $content['internet3'] = $request->textOfValue2;
                    else if($request->nameOfPropertySelectBox2 == 3) // SMS
                        $content['SMS3'] = $request->textOfValue2;
                    else if($request->nameOfPropertySelectBox2 == 4) // other
                        $content['other2'] = $request->textOfValue2;
                }
            }
        }

        if($request->addNewAdvantageCheckbox3 == 'on'){
            if($request->nameOfPropertySelectBox3 != 0){
                if($request->textOfValue3 != ''){
                    if($request->nameOfPropertySelectBox3 == 1) // telephony
                        $content['telephony4'] = $request->textOfValue3;
                    else if($request->nameOfPropertySelectBox3 == 2) // internet
                        $content['internet4'] = $request->textOfValue3;
                    else if($request->nameOfPropertySelectBox3 == 3) // SMS
                        $content['SMS4'] = $request->textOfValue3;
                    else if($request->nameOfPropertySelectBox3 == 4) // other
                        $content['other3'] = $request->textOfValue3;
                }
            }
        }

        // save the content array to the db
        $tariffHighlight = new TariffsHighlight();
        $tariffHighlight->tariff_id = $tariffID;
        $tariffHighlight->content = $content;
        $tariffHighlight->save();
    }
}