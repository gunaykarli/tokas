<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LawText extends Model
{
    protected $fillable = ['code', 'content'];

    public function vodafoneTariffs(){
        return $this->belongsToMany(VodafoneTariff::class);
    }

    /** User defined functions */

    // called from VodafoneTariff@manageCreationProcess
    public function setVodafoneTariffLawTexts($vodafoneTariff, Request $request){

        // depending on the value of the "lawTextOption" radio box in "resources/views/tariffs/vodafone/create.blade.php",
        // save the law texts of the tariff to be created to the DB.
        if($request->lawTextOption == 1){ // copy from the tariff
            // save the values to the 'law_text_vodafone_tariff' pivot table
            foreach($vodafoneTariff->lawTexts as $lawText){
                $lawText->vodafoneTariffs()->attach($vodafoneTariff->id);
            }
        }
        else if($request->lawTextOption == 2){ // select from the list
            // save the values to the 'law_text_vodafone_tariff' pivot table
            foreach($request->lawTextCheckbox as $lawTextID){
                $vodafoneTariff->lawtexts()->attach($lawTextID);
            }
        }
    }
}
