<?php

namespace App\Http\Controllers;

use App\SystemVariable;
use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;

class ImeiController extends Controller
{

    /**
     *
     * To redirect to login page when session timeout
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function IMEIPoolStatus(){

        // Fetch the system variables related to the IMEI.
        $systemVariablesIMEI = SystemVariable
            ::where('subject', 'IMEI')
            ->get();


        return view('IMEIs.IMEIPoolActivations', compact('systemVariablesIMEI'));
    }

    public function IMEIPoolStatusChange(Request $request){

        // Since variables related to the IMEI pool are stored in "systemvariables" table,
        // first determine the related record in the table and then change the value.

        // To change the status for the 'isIMEIPoolActive'
        $systemVariable = SystemVariable
            ::where('subject', 'IMEI')
            ->where('name', 'isIMEIPoolActive')
            ->first();
        // Since the switch tool returns "on" if it is checked, returns nothing if it is unchecked.
        if($request->isIMEIPoolActive == 'on')
            $systemVariable->value = 1;
        else
            $systemVariable->value = 0;

        $systemVariable->save();

        // To change the status for the 'isIMEIFieldActive'
        $systemVariable = SystemVariable
            ::where('subject', 'IMEI')
            ->where('name', 'isIMEIFieldActive')
            ->first();
        // Since the switch tool returns "on" if it is checked, returns nothing if it is unchecked.
        if($request->isIMEIFieldActive == 'on')
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

        alert()->success('Deneme', 'Title');
        return redirect()->back();
    }


}

