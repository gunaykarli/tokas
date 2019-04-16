<?php

namespace App\Http\Controllers;

use App\Dealer;
use App\Network;
use App\Output;
use App\Plausibility;
use App\Property;
use App\Provider;
use App\Region;
use App\SystemVariable;
use App\Tariff;
use App\TariffsGroup;
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
        // Take all tariff from the DB.
        $tariffs = Tariff::all();

        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id);

        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()
            ->user()->office_id)
            ->get();

        // Take all providers from the DB.
        $providers = Provider::all();


        return view('tariffs.index', compact('tariffs', 'tariffsWithOnTopForTheDealer', 'providers'));
    }

    public function fetchTariffsWithFilter(Request $request)
    {
        // Take "providerID" sent by "tariffList-Provider.js"
        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $maxBasePrice = $request->get('maxBasePrice');
        // if maxBAsePrice is not specified in the GUI (tariffs/index.blade.php)
        if($maxBasePrice == "")
            $maxBasePrice = Tariff::max('base_price');

        // Fetch the group of the tariffs according to providerID.
        if($providerID == 0)
            // $providerID is 0 means all providers has been selected. In this case tariff group must be all.
            $tariffGroups = "";
        else
            $tariffGroups = TariffsGroup::where('provider_id', $providerID)->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via tariffList-Provider.js .
        // 0 indicates all...then fetch all tariffs of all providers.
        if($providerID == 0)
            $tariffs = Tariff
                ::where('base_price', '<=', $maxBasePrice)
                ->get();
        else
            // if providerID is not 0 then check if tariffGroupID is 0 or not...
            if($tariffGroupID == 0)
                // fetch all tariffs according to providerID and filter parameters
                $tariffs = Tariff
                    ::where('provider_id', $providerID)
                    ->where('base_price', '<=', $maxBasePrice)
                    ->get();
            else
                // fetch all tariffs according to providerID, tariffGroupID and filter parameters
                $tariffs = Tariff
                    ::where('provider_id', $providerID)
                    ->where('group_id', $tariffGroupID)
                    ->where('base_price', '<=', $maxBasePrice)
                    ->get();

        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id);
        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()
                ->user()->office_id)
            ->get();

        // Prepare the html for the table including the related tariffs according to the providerID and tariffID.
        $out ="";
        foreach ($tariffs as $tariff){
            $out .= "<tr>";
            $out .= "<td>" . $tariff->network->name . "</td>";
            $out .= "<td>" . $tariff->name . "</td>";
            $out .= "<td><button type=\"button\" class=\"btn btn-danger\" data-toggle=\"m-popover\" title=\"". $tariff->name. "\" data-content=\"". $tariff->network->name . "\">Info</button></td>";
            $out .= "<td>" . $tariff->base_price . "</td>";
            $out .= "<td>" . $tariff->provision . "</td>";
            $out .= "<td>";

            foreach($tariffsWithOnTopForTheDealer as $tariffWithOnTopForTheDealer)
                if($tariffWithOnTopForTheDealer->id == $tariff->id)
                    $out .= $tariffWithOnTopForTheDealer->pivot->ontop;

            $out .= "</td>";
            $out .= "<td><a href=\"/contract/shopping-cart/add-tariff/" .$tariff->id. "\" class=\"btn btn-primary\" ><span>" . __('tariffs/index.order'). "</span>&nbsp;&nbsp;</a></td>";
            $out .= "</tr>";
        }

        // Send the tariffGroups and out to "tariffList-Provider.js" in json format.
        return response()->json(['tariffGroups' => $tariffGroups, 'out' => $out]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provider = Provider::where('id', 1)->first();
        $dealers = Dealer::all();
        $properties = Property::all();
        $networks = Network::all();
        return view('tariffs.vodafone.create', compact('provider', 'dealers', 'properties', 'networks'));
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

        //** Set the ON-TOP of the newly created tariff */
        $tariff->setOnTop($request);

        //** Set the LIMIT of the newly created tariff */
        $tariffsLimit = new TariffsLimit();
        $tariffsLimit->setLimit($tariff->id, $request);

        //** Set the PROPERTIES of the newly created tariff */
        $tariffsProperties = new Property();
        $tariffsProperties->setProperties($tariff, $request);

        //** Set the HIGHLIGHTS of the newly created tariff */
        $tariffsHighlights = new TariffsHighlight();
        //$tariffsHighlights->setHighlight($tariff->id, $request);


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
