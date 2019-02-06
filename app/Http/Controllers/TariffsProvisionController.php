<?php

namespace App\Http\Controllers;

use App\TariffsProvision;
use Illuminate\Http\Request;

class TariffsProvisionController extends Controller
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
     * @param  \App\TariffsProvision  $tariffsProvision
     * @return \Illuminate\Http\Response
     */
    public function show(TariffsProvision $tariffsProvision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TariffsProvision  $tariffsProvision
     * @return \Illuminate\Http\Response
     */
    public function edit(TariffsProvision $tariffsProvision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TariffsProvision  $tariffsProvision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TariffsProvision $tariffsProvision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TariffsProvision  $tariffsProvision
     * @return \Illuminate\Http\Response
     */
    public function destroy(TariffsProvision $tariffsProvision)
    {
        //
    }
}
