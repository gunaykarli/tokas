<?php

namespace App\Http\Controllers;

use App\Postcode;
use Illuminate\Http\Request;

class PostcodeController extends Controller
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
     * @param  \App\Postcode  $postcode
     * @return \Illuminate\Http\Response
     */
    public function show(Postcode $postcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Postcode  $postcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Postcode $postcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Postcode  $postcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Postcode $postcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Postcode  $postcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Postcode $postcode)
    {
        //
    }
}
