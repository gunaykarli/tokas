<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Tariff;
use App\TariffsGroup;
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
     * Display a listing of the provisions of VODAFONE tariffs.
     *
     */
    public function showProvisionSetupPage()
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

        return view('tariffs.vodafone.provisionSetup', compact('tariffs','tariffGroups', 'provider'));
    }

    /**
     * Display a listing of the provision of the Vodafone tariff in specific group.
     * forwarded from "public/js/provisionSetup.js" or "resources/views/tariffs/vodafone/provisionSetup.blade.php"
     */
    public function fetchProvisionOfTariffs(Request $request)
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
            $out .= "<td>" . $tariff->tariffsProvisions->where('status', 1)->first()->base_price . "</td>";
            $out .= "<td>" . $tariff->tariffsProvisions->where('status', 1)->first()->provision . "</td>";
            $out .= "<td>" . $tariff->tariffsProvisions->where('status', 1)->first()->valid_from . "</td>";
            $out .= "<td> <input type=\"text\" name=\"newProvisions[" . $tariff->id . "]\"></td>";
            $out .= "<td> <input  name=\"newValidFroms[" . $tariff->id . "]\" type=\"date\" class=\"form-control m-input\"> </td>";
            //$out .= "<td> <button class=\"btn btn-primary\" id=\"" . $tariff->id . "\">" . __('tariffs/vodafone/provisionSetup.save') . "</button> </td>";
            $out .= "</tr>";
        }

        // Send the tariffGroups and out to "public/js/provisionSetup.js" in json format.
        return response()->json(['out' => $out]);
    }

    /**
     * forwarded from "resources/views/tariffs/vodafone/provisionSetup.blade.php"
     * /tariff/vodafone/provision-setup/store-for-a-tariff
     *
     */
    public function storeForTariff(Request $request){
        TariffsProvision::renewVodafoneProvision($request);
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
