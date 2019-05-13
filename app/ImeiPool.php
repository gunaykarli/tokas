<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImeiPool extends Model
{
    protected $fillable = ['contract_id', 'provider_id', 'vf_gsm_id', 'IMEI', 'device', 'package', 'VO', 'status', 'user', 'salesperson_id', 'date', 'award_date'];

    public static function changeIMEIPoolStatus($request){
        // Since variables related to the IMEI pool are stored in "systemvariables" table,
        // first determine the related record in the table and then change the value.
        // To change the status for the 'isIMEIPoolActive'
        $systemVariable = SystemVariable
            ::where('subject', 'IMEI')
            ->where('name', 'isIMEIPoolActive')
            ->first();
        if($request->isIMEIPoolActive == 'on')
            $systemVariable->value = 1;
        else
            $systemVariable->value = 0;
        $systemVariable->save();

        // To change the status for the 'isIMEIOnDemandFieldActive'
        $systemVariable = SystemVariable
            ::where('subject', 'IMEI')
            ->where('name', 'isIMEIOnDemandFieldActive')
            ->first();
        if($request->isIMEIOnDemandFieldActive == 'on')
            $systemVariable->value = 1;
        else
            $systemVariable->value = 0;
        $systemVariable->save();

        // To change the status for the 'validFrom'
        $systemVariable = SystemVariable
            ::where('subject', 'IMEI')
            ->where('name', 'IMEIPoolActiveFrom')
            ->first();
        $systemVariable->value = $request->validFrom;
        $systemVariable->save();

        // To change the status for the 'validTo'
        $systemVariable = SystemVariable
            ::where('subject', 'IMEI')
            ->where('name', 'IMEIPoolActiveTo')
            ->first();
        $systemVariable->value = $request->validTo;
        $systemVariable->save();
    }

}
