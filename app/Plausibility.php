<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plausibility extends Model
{
    protected $fillable = ['tariff_id', 'min_period_of_validity', 'debit_authorization', 'subsidy_authorization',
        'IMEI_acquisition', 'telephone_book_entry', 'fax_book_entry', 'general_agreement', 'VF_home_address',
        'ultra_card', 'FN_porting', 'AO_bundle', 'member_type', 'group_must', 'tariff_type'];

    public function vodafoneTariff(){
        return $this->belongsTo(VodafoneTariff::class);
    }


    //* User defined methods of the model (class)

    /**
     * forwated from VodafoneTariffController@store
     */
    public function setPlausibility($vodafoneTariffID, $request){

        $VFPlausibility = new Plausibility();

        $VFPlausibility->vodafone_tariff_id = $vodafoneTariffID ;
        $VFPlausibility->min_period_of_validity = $request->minPeriodOfValidity ;
        $VFPlausibility->debit_authorization = $request->debitAuthorization ;
        $VFPlausibility->subsidy_authorization = $request->subsidyAuthorization ;
        $VFPlausibility->IMEI_acquisition = $request->IMEIAcquisition ;
        $VFPlausibility->telephone_book_entry = $request->telephoneBookEntry ;
        $VFPlausibility->fax_book_entry = $request->faxBookEntry ;
        $VFPlausibility->general_agreement = $request->generalAgreement ;
        $VFPlausibility->VF_home_address = $request->VFHomeAddress ;
        $VFPlausibility->ultra_card = $request->ultraCard ;
        $VFPlausibility->FN_porting = $request->FNPorting ;
        $VFPlausibility->AO_bundle = $request->AOBundle ;
        $VFPlausibility->member_type = $request->memberType ;
        $VFPlausibility->group_must = $request->groupMust ;
        $VFPlausibility->tariff_type = $request->tariffType ;
        $VFPlausibility->save();
    }

    /**
     * forwated from VodafoneTariffController@update
     */
    public function updatePlausibility($tariffID, $request){


        // Determine the specific row to be updated in the table
        $VFPlausibility = Plausibility
            ::where('vodafone_tariff_id', VodafoneTariff::where('tariff_id', $tariffID)->first()->id )
            ->first();

        $VFPlausibility->vodafone_tariff_id =  VodafoneTariff::where('tariff_id', $tariffID)->first()->id ;
        $VFPlausibility->min_period_of_validity = $request->minPeriodOfValidity ;
        $VFPlausibility->debit_authorization = $request->debitAuthorization ;
        $VFPlausibility->subsidy_authorization = $request->subsidyAuthorization ;
        $VFPlausibility->IMEI_acquisition = $request->IMEIAcquisition ;
        $VFPlausibility->telephone_book_entry = $request->telephoneBookEntry ;
        $VFPlausibility->fax_book_entry = $request->faxBookEntry ;
        $VFPlausibility->general_agreement = $request->generalAgreement ;
        $VFPlausibility->VF_home_address = $request->VFHomeAddress ;
        $VFPlausibility->ultra_card = $request->ultraCard ;
        $VFPlausibility->FN_porting = $request->FNPorting ;
        $VFPlausibility->AO_bundle = $request->AOBundle ;
        $VFPlausibility->member_type = $request->memberType ;
        $VFPlausibility->group_must = $request->groupMust ;
        $VFPlausibility->tariff_type = $request->tariffType ;
        $VFPlausibility->update();
    }
}
