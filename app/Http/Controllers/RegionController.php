<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::all();
        return view('regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = Provider::all();
        return view('regions.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $region = new Region();

        $region->name = ucfirst($request->regionName) ;
        $region->abbreviation = strtoupper($request->regionAbbreviation);
        $region->provider_id = $request->providerID;

        $region->save();

        return back()->with('success', 'Insert Record successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit($regionID)
    {
        $region = Region::where('id',Crypt::decrypt($regionID))->first() ;

        $providers = Provider::all();
        return view('regions.edit', compact('region', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $region->name = ucfirst($request->regionName);
        $region->abbreviation = strtoupper($request->regionAbbreviation);
        $region->provider_id = $request->providerID;

        $region->save();

        $regions = Region::all();
        return view('regions.index', compact('regions'))->with('success', 'Insert Record successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        //
    }
}
