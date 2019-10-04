<?php

namespace App\Http\Controllers;

use App\Dealer;
use App\LawText;
use App\Network;
use App\Plausibility;
use App\Property;
use App\Provider;
use App\Region;
use App\Service;
use App\Tariff;
use App\TariffsGroup;
use App\TariffsHighlight;
use App\TariffsLimit;
use App\TariffsProvision;
use App\VodafoneTariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
    public function index(Provider $provider, $isAdditionalTariff){
        // providerID session variable is created here.
        if(session()->exists('providerID')){
            session()->forget('providerID');
            Session::put('providerID',$provider->id);
        }
        else{
            Session::put('providerID',$provider->id);
        }


        // Take tariffs of the provider.
        $tariffs = Tariff
            ::where('provider_id', $provider->id)
            ->get();
        $tariffGroups = TariffsGroup
            ::where('provider_id', $provider->id)
            ->get();

        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id);

        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()
                ->user()->office_id)
            ->get();

        if($provider->id == 1)
            return view('tariffs.vodafone.index', compact('tariffs','tariffGroups', 'tariffsWithOnTopForTheDealer', 'provider', 'isAdditionalTariff'));
        else if($provider->id == 2)
            return view('tariffs.ayYildiz.index', compact('tariffs', 'tariffGroups', 'tariffsWithOnTopForTheDealer', 'provider'));
    }

    // public/js/vodafoneTariffsListWithFilter2.js
    public function fetchTariffsWithFilter(Request $request)
    {
        // Take "providerID" sent by "public/js/tariffListWithFilter2.js"
        //$providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $maxBasePrice = $request->get('maxBasePrice');

        // if maxBAsePrice is not specified in the GUI (tariffs/index.blade.php)
        if($maxBasePrice == "")
            $maxBasePrice = Tariff::max('base_price');

        // Fetch the group of the vodafone tariffs according to providerID.
        $tariffGroups = TariffsGroup::where('provider_id', 1)->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via tariffList-Provider.js .
        // 0 indicates all...then fetch all tariffs of all providers.

           // check if tariffGroupID is 0 or not...
            if($tariffGroupID == 0) // fetch all tariffs according to providerID and filter parameters
                $tariffs = Tariff
                    ::where('provider_id', 1)
                    ->where('status', 1)
                    ->where('base_price', '<=', $maxBasePrice)
                    ->orderBy('group_id')
                    ->get();
            else if($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
                // fetch the tariffs according to providerID and filter parameters
                $tariffs = Tariff
                    ::where('provider_id', 1)
                    ->where('status', 1)
                    ->where('base_price', '<=', $maxBasePrice)
                    ->where('action_tariff', 1)
                    ->orderBy('group_id')
                    ->get();
            else
                // fetch all tariffs according to providerID, tariffGroupID and filter parameters
                $tariffs = Tariff
                    ::where('provider_id', 1)
                    ->where('group_id', $tariffGroupID)
                    ->where('status', 1)
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
     * Display a listing of the provision of the Vodafone tariff in specific group.
     * forwarded from "public/js/basePriceSetup.js" or "resources/views/tariffs/vodafone/basePriceSetup.blade.php"
     */
    public function fetchBasePriceOfTariffs(Request $request)
    {
        // Take "providerID" sent by "public/js/provisionSetup.js"
        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');


        // Take the tariffs from the DB according to the providerID, tariffGroupID parameters sent by the "resources/views/tariffs/vodafone/provisionSetup.blade.php" via public/js/provisionSetup.js .

        if($tariffGroupID == 0) // fetch all tariffs according to providerID
            $tariffs = Tariff
                ::where('provider_id', $providerID)
                ->get();
        else if($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
            $tariffs = Tariff
                ::where('provider_id', $providerID)
                ->where('action_tariff', 1)
                ->get();
        else // fetch all tariffs according to providerID, tariffGroupID
            $tariffs = Tariff
                ::where('provider_id', $providerID)
                ->where('group_id', $tariffGroupID)
                ->get();


        // Prepare the html for the table including the related tariffs according to the providerID and tariffID.
        $out ="";
        foreach ($tariffs as $tariff){
            $out .= "<tr>";
            $out .= "<td>" . $tariff->name . "</td>";
            $out .= "<td>" . $tariff->base_price . "</td>";
            $out .= "<td> <input type=\"text\" name=\"newBasePrices[" . $tariff->id . "]\"></td>";
            //$out .= "<td> <button class=\"btn btn-primary\" id=\"" . $tariff->id . "\">" . __('tariffs/vodafone/provisionSetup.save') . "</button> </td>";
            $out .= "</tr>";
        }

        // Send the tariffGroups and out to "public/js/provisionSetup.js" in json format.
        return response()->json(['out' => $out]);
    }


    /**
     * Display the base price setup page
     */
    public function showBasePriceSetupPage(VodafoneTariff $vodafoneTariff)
    {
        // Take all VODAFONE tariffs and tariff groups.
        $provider = Provider
            ::where('id',1)
            ->first();

        $tariffs = Tariff
            ::where('provider_id', 1)
            ->get();

        $tariffGroups = TariffsGroup
            ::where('provider_id', 1)
            ->get();

        return view('tariffs.vodafone.basePriceSetup', compact('tariffs','tariffGroups', 'provider'));
    }

    /**
     * forwarded from "resources/views/tariffs/vodafone/basePriceSetup.blade.php"
     */
    public function storeBasePriceForTariffs(Request $request){
        VodafoneTariff::renewBasePrice($request);
    }

    /**
     * Show the form for creating a new vodafone tariff.
     * /tariff/vodafone/create
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
     * Store a newly created vodafone tariff in storage.
     * called from "/tariffs/vodafone/create.blade.php"
     */
    public function store(Request $request)
    {
        /** Save basic info of the new tariff */
        $tariff = new Tariff();
        $tariff->setBasicInfo($request);

        /** Set the AMOUNT LIMIT of the newly created tariff */
        $tariffsLimit = new TariffsLimit();
        $tariffsLimit->setLimit($tariff->id, $request);

        /** Set the REGION(s) of the newly created Vodafone tariff */
        $regions = new Region();
        $regions->setVodafoneRegions($tariff, $request);

        /** Set the PROVISION of the newly created tariff */
        //$tariffsProvisions = new TariffsProvision();
        //$tariffsProvisions->setProvision($tariff->id, $request);

        /** Set the ON-TOP of the newly created tariff */
        //$tariff->setOnTop($request);

        /** Set the PROPERTIES of the newly created tariff */
        $tariffsProperties = new Property();
        $tariffsProperties->setProperties($tariff, $request);

        /** Set the HIGHLIGHTS of the newly created tariff */
        $tariffsHighlights = new TariffsHighlight();
        $tariffsHighlights->setHighlight($tariff->id, $request);

        /** if the tariff to be created belongs to VODAFONE then perform vodafone-related activities...
        //  manageCreationProcess() manages all the activities related to creation of new Vodafone Tariff*/
        $vodafoneTariff = new VodafoneTariff();
        $vodafoneTariff->manageCreationProcess($tariff, $request);



        /** if the tariff to be created belongs to AY YILDIZ then process ay yıldız related activities... */


        /** if the tariff to be created belongs to O2 then process O2 related activities... */

        return back();
    }

    /** Show the form for editing the VodafoneTariff. */
    public function edit(Tariff $tariff)
    {
        //dd($tariff->vodafoneTariff->plausibility->min_period_of_validity);
        $vodafoneTariff = VodafoneTariff
            ::where('tariff_id', $tariff->id)
            ->first();

        // $provider = Provider::where('id', 1)->first();
        $provider = Provider
            ::where('id', $tariff->provider_id)
            ->first();

        $networks = Network::all();
        $dealers = Dealer::all();
        $properties = Property::all();

        return view('tariffs.vodafone.edit', compact('vodafoneTariff', 'tariff', 'provider', 'dealers', 'properties', 'networks'));
    }

    /**
     * Update the specified vodafone tariff in storage.
     * forwarded from "resources/views/tariffs/vodafone/edit.blade.php"
     */
    public function update(Request $request, Tariff $tariff)
    {
        //$tariff has been created by Model-Route injection

        /** Update BASIC INFO of the new tariff */
        $tariff->updateBasicInfo($tariff, $request);

        /** Update the LIMITED AMOUNT of the tariff */
        $tariffsLimit = new TariffsLimit();
        $tariffsLimit->updateLimit($tariff->id, $request);

        /** Update the REGION(s) of the tariff */
        $regions = new Region();
        $regions->updateVodafoneRegions($tariff, $request);

        /** DO NOT Update the PROVISION of the tariff since there is a specific section for this function (/tariff/vodafone/provision-setup)
        $tariffsProvisions = new TariffsProvision();
        $tariffsProvisions->setProvision($tariff->id, $request);
         */

        /** DO NOT Update the OnTop of the tariff since there is a specific section for this function ()
        $tariff->setOnTop($request);
         */

        /** update the PROPERTIES of the tariff */
        $tariffsProperties = new Property();
        $tariffsProperties->updateProperties($tariff, $request);


        /** update the HIGHLIGHTS of the newly created tariff */
        //$tariffsHighlights = new TariffsHighlight();
        //$tariffsHighlights->setHighlight($tariff->id, $request);

        /** update the PLAUSIBILITY  of the tariff */
        $VFPlausibility = new Plausibility();
        $VFPlausibility->updatePlausibility($tariff->id, $request);


        /** update the SERVICES  of the tariff */
        // Edit the services only if the "editServices" checkbox is checked.
        if($request->editServices == 'on'){
            $service = new Service();
            $service->updateVodafoneTariffServices($tariff, $request);
        }

        /** update the LAWTEXT  of the tariff */
        $lawText = new LawText();
        $lawText->updateVodafoneTariffLawTexts($tariff, $request);

        /** NOTE: $vodafoneTariff->manageCreationProcess($tariff, $request); is not used as it is used in "store" process of the newly created tariff*/

        return redirect('tariff/index');
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



    /** Displays page to set up "on-top" for a tariff */
    public function createOnTop()
    {
        // Determine Vodafone provider
        $provider = Provider
            ::where('id', 1)
            ->first();

        $dealers = Dealer::all();

        // Get all Vodafone tariffs
        $vodafoneTariffs = Tariff
            ::where('provider_id', $provider->id )
            ->get();

        return view('tariffs.vodafone.onTop', compact('vodafoneTariffs','provider', 'dealers'));
    }


    /** Called from resources/views/tariffs/vodafone/onTop.blade.php */
    public function storeOnTop(Request $request){
        $provider = Provider::where('id', 1)->first();

        $tariff = new Tariff;
        $tariff->setOnTop($provider, $request);

        return redirect()->back()->with('storeMessage', 'success');
    }


}
