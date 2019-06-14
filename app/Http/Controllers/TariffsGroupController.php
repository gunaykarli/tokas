<?php

namespace App\Http\Controllers;

use App\TariffsGroup;
use Illuminate\Http\Request;

class TariffsGroupController extends Controller
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
     * @param  \App\TariffsGroup  $tariffsGroup
     * @return \Illuminate\Http\Response
     */
    public function show(TariffsGroup $tariffsGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TariffsGroup  $tariffsGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(TariffsGroup $tariffsGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TariffsGroup  $tariffsGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TariffsGroup $tariffsGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TariffsGroup  $tariffsGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(TariffsGroup $tariffsGroup)
    {
        //
    }
}
