<?php

namespace App\Http\Controllers;

use App\VodafoneTariff;
use Illuminate\Http\Request;

class VodafoneTariffController extends Controller
{
    /**
     *
     * To redirect to login page when session timeout
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VodafoneTariff  $vodafoneTariff
     * @return \Illuminate\Http\Response
     */
    public function show(VodafoneTariff $vodafoneTariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VodafoneTariff  $vodafoneTariff
     * @return \Illuminate\Http\Response
     */
    public function edit(VodafoneTariff $vodafoneTariff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VodafoneTariff  $vodafoneTariff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VodafoneTariff $vodafoneTariff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VodafoneTariff  $vodafoneTariff
     * @return \Illuminate\Http\Response
     */
    public function destroy(VodafoneTariff $vodafoneTariff)
    {
        //
    }
}
