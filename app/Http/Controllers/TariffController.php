<?php

namespace App\Http\Controllers;

use App\Network;
use App\Output;
use App\Plausibility;
use App\Property;
use App\Provider;
use App\Region;
use App\Tariff;
use App\TariffsHighlight;
use App\TariffsLimit;
use App\TariffsProvision;
use App\VodafoneTariff;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class TariffController extends Controller
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
        $provider = Provider::where('id', 1)->first();
        $properties = Property::all();
        $networks = Network::all();
        return view('tariffs.vodafone.create', compact('provider', 'properties', 'networks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //** Save basic info of the new tariff */
        $tariff = new Tariff();
        $tariff->setBasicInfo($request);

        //** Set the REGION(s) of the newly created Vodafone tariff */
        $regions = new Region();
        $regions->setVodafoneRegions($tariff, $request);

        //** Set the PROVISION of the newly created tariff */
        $tariffsProvisions = new TariffsProvision();
        $tariffsProvisions->setProvision($tariff->id, $request);

        //** Set the LIMIT of the newly created tariff */
        $tariffsLimit = new TariffsLimit();
        $tariffsLimit->setLimit($tariff->id, $request);

        //** Set the PROPERTIES of the newly created tariff */
        $tariffsProperties = new Property();
        $tariffsProperties->setProperties($tariff, $request);

        //** Set the HIGHLIGHTS of the newly created tariff */
        $tariffsHighlights = new TariffsHighlight();
        $tariffsHighlights->setHighlight($tariff->id, $request);

        //** if the tariff to be created belongs to VODAFONE then perform vodafone-related activities...
        //  manageCreationProcess() manages all the activities related to creation of new Vodafone Tariff*/
        $vodafoneTariff = new VodafoneTariff();
        $vodafoneTariff->manageCreationProcess($tariff, $request);



        //** if the tariff to be created belongs to AY YILDIZ then process ay yıldız related activities... */


        //** if the tariff to be created belongs to O2 then process O2 related activities... */

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tariff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tariff $tariff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tariff $tariff)
    {
        //
    }
}
