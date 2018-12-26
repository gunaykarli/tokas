<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $language){

        // establish new session variable 'locale' and assign value of $language which comes from language bar.
        $request->session()->put('locale', $language);
        // set locale using the following expression
        App::setlocale($language);
        return redirect()->back();

        // Note: 'SetLocal' Middleware has been established and registered to App\Http\Kernel.php

    }
}
