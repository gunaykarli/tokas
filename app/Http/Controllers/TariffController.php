<?php

namespace App\Http\Controllers;

use App\Output;
use App\Property;
use App\Provider;
use App\Region;
use App\Tariff;
use App\TariffsHighlight;
use App\TariffsLimit;
use App\TariffsProvision;
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
        return view('tariffs.vodafone.create', compact('provider', 'properties'));
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

        $tariff->name = $request->tariffName;
        $tariff->tariff_code = $request->tariffCode;
        $tariff->status = 1;
        $tariff->main_group_id = $request->mainGroupID;
        $tariff->sub_group_id = $request->subGroupID;
        $tariff->provider_id = $request->providerID;
        $tariff->base_price = 0; // base_price and provision will be entered in next step...
        $tariff->provision = 0;
        $tariff->valid_from = $request->tariffValidFrom;
        $tariff->valid_to = $request->tariffValidTo;
        if ($request->madeByToker == 'on')
            $tariff->made_by_toker = 1;
        else
            $tariff->made_by_toker = 0;

        if ($request->isLimited == 'on')
            $tariff->is_limited = 1;
        else
            $tariff->is_limited = 0;

        $tariff->save();



        //** Set the REGION(s) of the newly created tariff */

        // According to checkboxOfRegion in resources/views/tariffs/vodafone/create.blade.php,  the pivot table (tariff_region) of Region and Tariff is set.
        // Since checkboxOfRegions takes its names' values from the Region table according to the active provider,
        // we need to check if the key exist in the array, if so, control, if it has been checked. */
        $regions = Region::where('provider_id', $request->providerID)->get();
        foreach($regions as $region){
            if(array_key_exists($region->id, $request->checkboxOfRegions)) {
                if($request->checkboxOfRegions[$region->id] == 'on')
                    $tariff->regions()->attach($region->id, ['provider_id' => $request->providerID]);
            }
        }

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
