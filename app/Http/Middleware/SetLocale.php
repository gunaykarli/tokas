<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request , Closure $next)
    {

        if (!$request->session()->has('locale')){

            //$request->session()->put('locale', auth()->user()->dealer->address->country);
            $request->session()->put('locale', Config::get('locale'));
            $locale = $request->session()->get('locale');

        }
        else{
            //$locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            //$locale = auth()->user()->office->address->coutry;
            $locale = $request->session()->get('locale');


        }

        App::setLocale($locale);

        //dd($locale);


        return $next($request);
    }
}
