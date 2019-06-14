<?php

namespace App\Http\Controllers;

use App\ImeiPool;
use App\SystemVariable;
use Illuminate\Http\Request;


class ImeiPoolController extends Controller
{
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

    public function forwardToChangeIMEIPoolStatus(Request $request){
        ImeiPool::changeIMEIPoolStatus($request);
        return redirect()->back();
    }
}
