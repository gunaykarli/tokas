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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

    /** Display a listing of the providers. */
    public function providers()
    {
        return view('tariffs.providers');
    }



    /** Display a listing of the tariffs. */
    public function index()
    {
        // Take all ACTIVE tariffs from the DB.
        $tariffs = Tariff
            ::where('status', 1)
            ->orderBy('provider_id')
            ->orderBy('group_id')
            ->get();

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

    // called from "public/js/allTariffListWithFilter4.js"
    public function fetchTariffsWithFilter_V1(Request $request) // working one
    {
        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $maxBasePrice = $request->get('maxBasePrice');

        $maxSpeed = $request->get('maxSpeed');
        $minBandWidth = $request->get('minBandWidth');
        $statusOfTariffs = $request->get('statusOfTariffs'); // it is used in listing the tariffs whose statuses are active (1) or disabled (0).

        // determine the status of the tariffs as a filter parameter which are requested from "resources/views/tariffs/index.blade.php"
        // $statusOfTariffs:
            //  1 is show only active tariffs
            //  0 is show only disabled tariffs
            //  2 is show all tariffs

        if($statusOfTariffs == 1)// active tariffs
            $status = 1;
        else if($statusOfTariffs == 0) // disabled tariffs
            $status = 0;

        // if maxBasePrice is not specified in the GUI (tariffs/index.blade.php)
        if($maxBasePrice == "")
            $maxBasePrice = Tariff::max('base_price');

        // Fetch the group of the tariffs according to providerID.
        if($providerID == 0)
            // $providerID is 0 means all providers has been selected. In this case tariff group must be all.
            $tariffGroups = "";
        else
            $tariffGroups = TariffsGroup::where('provider_id', $providerID)->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via public/js/allTariffListWithFilter2.js .
        // 0 indicates all...then fetch all tariffs of all providers.    //->properties()->where('name', 'max-Bandbreite')->wherePivot('value', '>=', $minBandWidth);
        if($providerID == 0)
            if($statusOfTariffs != 2)
                $tariffs = Tariff
                    ::where('status', $status)
                    ->where('base_price', '<=', $maxBasePrice)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else
                $tariffs = Tariff
                    ::where('base_price', '<=', $maxBasePrice)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
        else
            // if providerID is not 0 then check if tariffGroupID is 0 or not...tariffGroupID of 0 indicates all groups
            if($tariffGroupID == 0)
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->orderBy('group_id')
                        ->get();
            else if($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
                    // fetch all tariffs according to providerID and filter parameters
                    if($statusOfTariffs != 2)
                        $tariffs = Tariff
                            ::where('provider_id', $providerID)
                            ->where('status', $status)
                            ->where('base_price', '<=', $maxBasePrice)
                            ->where('action_tariff', 1)
                            ->orderBy('group_id')
                            ->get();
                    else
                        $tariffs = Tariff
                            ::where('provider_id', $providerID)
                            ->where('base_price', '<=', $maxBasePrice)
                            ->where('action_tariff', 1)
                            ->orderBy('group_id')
                            ->get();
            else
                // fetch all tariffs according to providerID, tariffGroupID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->where('status', $status)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->get();


        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id
        );
        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()->user()->office_id)
            ->get();

        // Prepare the html for the table including the related tariffs according to the providerID and tariffID...
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
                $out .= "<td>";
                if($tariff->status == 1) $out .= __('tariffs/index.active');  else  $out .= __('tariffs/index.disabled');
                $out .= "<button type=\"button\" class=\"btn btn-danger\" name=\" ". $tariff->name . " \" id=\" " . $tariff->id . "\">";
                $out .= __('tariffs/index.change');
                $out .= "</td>";

                $out .="<td>";

                if($tariff->provider_id == 1)
                    $out .="<a href=\"/tariff/vodafone/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                elseif($tariff->provider_id == 2)
                    $out .="<a href=\"/tariff/ayYildiz/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                elseif(($tariff->provider_id == 3))
                    $out .="<a href=\"/tariff/O2/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";

                $out .="</td>";
                $out .= "</tr>";
        }

        // Send the tariffGroups and out to "tariffList-Provider.js" in json format.
        return response()->json(['tariffGroups' => $tariffGroups, 'out' => $out]);
    }

    public function fetchTariffsWithFilter(Request $request)
    {
        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $statusOfTariffs = $request->get('statusOfTariffs'); // it is used in listing the tariffs whose statuses are active (1) or disabled (0).


        // set filter parameters

        $filterParameters['networkID'] = $request->get('networkID');

        // if maxBasePrice is not specified in the GUI (tariffs/index.blade.php)
        if($request->get('maxBasePrice') == "")
            $filterParameters['maxBasePrice'] = Tariff::max('base_price');
        else
            $filterParameters['maxBasePrice'] = $request->get('maxBasePrice');

        if($request->get('minDataVolume') == "")
            $filterParameters['minDataVolume'] = 0;
        else
            $filterParameters['minDataVolume'] = $request->get('minDataVolume');

        if($request->get('minBandWidth') == "")
            $filterParameters['minBandWidth'] = 0;
        else
            $filterParameters['minBandWidth'] = $request->get('minBandWidth');

        $filterParameters['allNetFlatTelephony'] = $request->get('allNetFlatTelephony');
        $filterParameters['allNetFlatInternet'] = $request->get('allNetFlatInternet');
        $filterParameters['allNetFlatSMS'] = $request->get('allNetFlatSMS');


        // determine the status of the tariffs as a filter parameter which are requested from "resources/views/tariffs/index.blade.php"
        // $statusOfTariffs:
        //  1, show only active tariffs
        //  0, show only disabled tariffs
        //  2, show all tariffs

        if($statusOfTariffs == 1)// only active tariffs will be listed
            $status = 1;
        else if($statusOfTariffs == 0) // only disabled tariffs will be listed
            $status = 0;


        // Fetch the group of the tariffs according to providerID.
        if($providerID == 0)
            // $providerID is 0 means all providers has been selected. In this case tariff group must be "all".
            $tariffGroups = "";
        else
            $tariffGroups = TariffsGroup
                ::where('provider_id', $providerID)
                ->where('status', 1)
                ->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via public/js/allTariffListWithFilter2.js .
        // 0 indicates all...then fetch all tariffs of all providers.    //->properties()->where('name', 'max-Bandbreite')->wherePivot('value', '>=', $minBandWidth);
        if($providerID == 0){
            if($statusOfTariffs == 1) // 1, show only active tariffs
                $tariffs = Tariff
                    ::where('status', $status)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else if($statusOfTariffs == 0) // 0, show only disabled tariffs
                $tariffs = Tariff
                    ::where('status', $status)
                    ->orderBy('updated_at', 'DESC') // last deactivated tariffs will be top of the list...
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else if($statusOfTariffs == 2) //  2, show all tariffs
                $tariffs = Tariff
                    ::orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
        }
        else{
            // if providerID is not 0 then check if tariffGroupID is 0 or not...tariffGroupID of 0 indicates all groups
            if($tariffGroupID == 0)
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->orderBy('group_id')
                        ->get();
            else if($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
            else
                // fetch all tariffs according to providerID, tariffGroupID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->where('status', $status)
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->get();
        }



        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id
        );
        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()->user()->office_id)
            ->get();

        // Prepare the html for the table including the related tariffs according to the filter parameters...
        $out ="";
        foreach ($tariffs as $tariff){

                if($this->checkFilterParametersForTariff($tariff, $filterParameters)){
                    $out .= "<tr>";
                    $out .= "<td>" . $tariff->network->name . "</td>";
                    $out .= "<td>" . $tariff->name . "</td>";

                    $out .= "<td>";
                    $out .= "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"m-popover\" title=\"" . $tariff->name . "\"";
                        $out.= " data-html=\"true\" data-content= \" Lorem \"";

                    /**
                    if ($tariff->tariffsHighlight){
                            if($tariff->tariffsHighlight->content['internet1'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['internet1'] ."</li>";
                            if($tariff->tariffsHighlight->content['internet2'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['internet2'] ."</li>";
                            if($tariff->tariffsHighlight->content['internet3'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['internet3'] ."</li>";
                            if($tariff->tariffsHighlight->content['internet4'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['internet4'] ."</li>";
                            if($tariff->tariffsHighlight->content['SMS1'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['SMS1'] ."</li>";
                            if($tariff->tariffsHighlight->content['SMS2'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['SMS2'] ."</li>";
                            if($tariff->tariffsHighlight->content['SMS3'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['SMS3'] ."</li>";
                            if($tariff->tariffsHighlight->content['SMS4'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['SMS4'] ."</li>";
                            if($tariff->tariffsHighlight->content['telephony1'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['telephony1'] ."</li>";
                            if($tariff->tariffsHighlight->content['telephony2'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['telephony2'] ."</li>";
                            if($tariff->tariffsHighlight->content['telephony3'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['telephony3'] ."</li>";
                            if($tariff->tariffsHighlight->content['telephony4'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['telephony4'] ."</li>";
                            if($tariff->tariffsHighlight->content['other1'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['other1'] ."</li>";
                            if($tariff->tariffsHighlight->content['other2'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['other2'] ."</li>";
                            if($tariff->tariffsHighlight->content['other3'] != '')
                                $out .= "<li>". $tariff->tariffsHighlight->content['other3'] ."</li>";
                    }
                     */
                    $out .= ">Info";
                    $out .= "</button></td>";

                    $out .= "<td>" . $tariff->base_price . "</td>";
                    $out .= "<td>" . $tariff->provision . "</td>";
                    $out .= "<td>";

                    foreach($tariffsWithOnTopForTheDealer as $tariffWithOnTopForTheDealer){
                        if($tariffWithOnTopForTheDealer->id == $tariff->id)
                            $out .= $tariffWithOnTopForTheDealer->pivot->ontop;
                    }

                    $out .= "</td>";
                    $out .= "<td>";
                    if($tariff->status == 1) $out .= __('tariffs/index.active');  else  $out .= __('tariffs/index.disabled');
                    $out .= "<button type=\"button\" class=\"btn btn-danger\" name=\" ". $tariff->name . " \" id=\" " . $tariff->id . "\">";
                    $out .= __('tariffs/index.change');
                    $out .= "</td>";

                    $out .="<td>";

                    if($tariff->provider_id == 1)
                        $out .="<a href=\"/tariff/vodafone/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                    elseif($tariff->provider_id == 2)
                        $out .="<a href=\"/tariff/ayYildiz/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                    elseif(($tariff->provider_id == 3))
                        $out .="<a href=\"/tariff/O2/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";

                    $out .="</td>";
                    $out .= "</tr>";
                }
        }

        // Send the tariffGroups and out to "tariffList-Provider.js" in json format.
        return response()->json(['tariffGroups' => $tariffGroups, 'out' => $out]);
    }

    // checks if a tariffs's property meets filter parameters
    public function checkFilterParametersForTariff($tariff, $filterParameters){

        // network check
        if($filterParameters['networkID'] !=0){ // 0 means all networks. No filter.
            if( $tariff->network_id != $filterParameters['networkID']){
                return 0;
            }
        }

        // maxBasePrice check
        if( !($tariff->base_price <= $filterParameters['maxBasePrice'])){
            return 0;
        }

/**
        // max-Bandbreite check
        // find the value of the property (max-Bandbreite) in pivot table for the tariff.
        $minBandWidthObject = DB::table('property_tariff')
            ->where('tariff_id', $tariff->id)
            ->where('property_id', '=', Property
                ::where('name', 'max-Bandbreite')
                ->first()
                ->id)
            ->first();

        if($minBandWidthObject){
            if( !($minBandWidthObject->amount_of_value >= $filterParameters['minBandWidth'])){
                return 0;
            }
        }
        else
            //return 0;

        // Datenvolumen check
        // find the value of the property (Datenvolumen) in pivot table for the tariff.
        $minDataVolumeObject = DB::table('property_tariff')
            ->where('tariff_id',$tariff->id)
            ->where('property_id', '=', Property
                ::where('name', 'Datenvolumen')
                ->first()
                ->id)
            ->first();

        if($minDataVolumeObject){
            if( !($minDataVolumeObject->amount_of_value >= $filterParameters['minDataVolume'])){
                return 0;
            }
        }
        else
            //return 0;

 */
        // allNetFlatTelephony check
        if($filterParameters['allNetFlatTelephony'] != "false"){ // "false" means, "no filter" for "allNetFlatTelephony" parameter...
            // find the value of the property (allNetFlatTelephony) in pivot table for the tariff.
            $allNetFlatTelephonyObject = DB::table('property_tariff')
                ->where('tariff_id',$tariff->id)
                ->where('property_id', '=', Property
                    ::where('name', 'Telefonie')
                    ->first()
                    ->id)
                ->first();


            if($allNetFlatTelephonyObject){
                if($allNetFlatTelephonyObject->amount_of_value != 1){
                    return 0;
                }
            }
            else{
                return 0;
            }
        }


        // allNetFlatInternet check
        if($filterParameters['allNetFlatInternet'] != "false"){ // "false" means, "no filter" for "allNetFlatInternet" parameter...
            // find the value of the property (allNetFlatInternet) in pivot table for the tariff.
            $allNetFlatInternetObject = DB::table('property_tariff')
                ->where('tariff_id',$tariff->id)
                ->where('property_id', '=', Property
                    ::where('name', 'Internet')
                    ->first()
                    ->id)
                ->first();

            if($allNetFlatInternetObject){
                if($allNetFlatInternetObject->amount_of_value != 1){
                    return 0;
                }
            }
            else
                return 0;
        }

        // allNetFlatSMS check
        if($filterParameters['allNetFlatSMS'] != "false"){ // "false" means, "no filter" for "allNetFlatSMS" parameter...
            // find the value of the property (allNetFlatSMS) in pivot table for the tariff.
            $allNetFlatSMSObject = DB::table('property_tariff')
                ->where('tariff_id',$tariff->id)
                ->where('property_id', '=', Property
                    ::where('name', 'SMS')
                    ->first()
                    ->id)
                ->first();

            if($allNetFlatSMSObject){
                if($allNetFlatSMSObject->amount_of_value != 1){
                    return 0;
                }
            }
            else
                return 0;
        }


        // if all property of the tariff meet all filter parameters, then return 1. Otherwise function sends return 0 in above codes...
        return 1;

    }

    public function changeStatusOfTariff_without_enable_disable__gruop_status(Request $request)
    {
        $tariffID = $request->get('tariffID');

        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $maxBasePrice = $request->get('maxBasePrice');
        $statusOfTariffs = $request->get('statusOfTariffs');// it is used in listing the tariffs whose statuses are active (1) or disabled (0).

        // take status of tariff whose status is going to be changed. And change the status of the current tariff
        $currentTariff = Tariff
                            ::where('id', $tariffID)
                            ->first();
        if($currentTariff->status == 1){
            $currentTariff->status = 0;
            $statusOfCurrentTariff = 0;
        }
        else{
            $currentTariff->status = 1;
            $statusOfCurrentTariff = 1;
        }
        $currentTariff->save();


        // determine the status of the tariffs as a filter parameter which are requested from "resources/views/tariffs/index.blade.php"
        // $statusOfTariffs:
            //  1 is show only active tariffs
            //  0 is show only disabled tariffs
            //  2 is show all tariffs
        if($statusOfTariffs == 1)// active tariffs
            $status = 1;
        else if($statusOfTariffs == 0) // disabled tariffs
            $status = 0;

        // if maxBAsePrice is not specified in the GUI (tariffs/index.blade.php)
        if($maxBasePrice == "")
            $maxBasePrice = Tariff::max('base_price');

        // Fetch the group of the tariffs according to providerID and status of the group.
        if($providerID == 0)
            // $providerID is 0 means all providers has been selected. In this case tariff group must be all.
            $tariffGroups = "";
        else
            $tariffGroups = TariffsGroup
                ::where('provider_id', $providerID)
                ->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via tariffList-Provider.js .
        // 0 indicates all...then fetch all tariffs of all providers.
        if($providerID == 0)
            if($statusOfTariffs != 2)
                $tariffs = Tariff
                    ::where('status', $status)
                    ->where('base_price', '<=', $maxBasePrice)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else
                $tariffs = Tariff
                    ::where('base_price', '<=', $maxBasePrice)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
        else
            // if providerID is not 0 then check if tariffGroupID is 0 or not...
            if($tariffGroupID == 0)
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->orderBy('group_id')
                        ->get();
            else if($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
            else
                // fetch all tariffs according to providerID, tariffGroupID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->where('status', $status)
                        ->where('base_price', '<=', $maxBasePrice)
                        ->get();
                else
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

        // Prepare the html for the table including the related tariffs according to the providerID and tariffID...
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
            $out .= "<td>";
            if($tariff->status == 1) $out .= __('tariffs/index.active');  else  $out .= __('tariffs/index.disabled');
            $out .= "<button type=\"button\" class=\"btn btn-danger\" name=\" ". $tariff->name . " \" id=\" " . $tariff->id . "\">";
            $out .= __('tariffs/index.change');
            $out .= "</button>";
            $out .= "</td>";
            $out .= "</tr>";
        }

        // Send the tariffGroups and out to "tariffList-Provider.js" in json format.
        return response()->json(['tariffGroups' => $tariffGroups, 'out' => $out]);
    }

    /* called by public/js/allTariffListWithFilter8.js
     * when the button titled "change" in status column is clicked in resources/views/tariffs/index.blade.php
     * And also, controls the status of the group of the tariff, and alter, if it is necessary
     */
    public function changeStatusOfTariff(Request $request)
    {
        $tariffID = $request->get('tariffID');
        $tariffGroupID = $request->get('tariffGroupID');


        // take status of tariff whose status is going to be changed. And change the status of the current tariff
        $currentTariff = Tariff
            ::where('id', $tariffID)
            ->first();
        if($currentTariff->status == 1){
            $currentTariff->status = 0;
        }
        else{
            $currentTariff->status = 1;
        }
        $currentTariff->save();

        /** After changing the status of the tariff, control the status of the group, and alter if it is necessary */
        // After changing the status of the tariff, status of the group which the tariff whose status has been changed, belongs to should be controlled.
        // After the changing of the status of the tariff from 1 to 0, if the group has all tariffs with disabled status,
        // then the status of the group must be altered from 1 to 0.
        // After the changing of the status of the tariff from 0 to 1, if the group has min one tariff with enabled status,
        // then the status of the group must be altered from 0 to 1.
        TariffsGroup::controlAndAlterStatusOfGroup($tariffID);

        //$this->fetchTariffsWithFilter($request);


        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $statusOfTariffs = $request->get('statusOfTariffs');// it is used in listing the tariffs whose statuses are active (1) or disabled (0).

        // set filter parameters
        $filterParameters['networkID'] = $request->get('networkID');

        // if maxBasePrice is not specified in the GUI (tariffs/index.blade.php)
        if($request->get('maxBasePrice') == "")
            $filterParameters['maxBasePrice'] = Tariff::max('base_price');
        else
            $filterParameters['maxBasePrice'] = $request->get('maxBasePrice');

        if($request->get('minDataVolume') == "")
            $filterParameters['minDataVolume'] = 0;
        else
            $filterParameters['minDataVolume'] = $request->get('minDataVolume');

        if($request->get('minBandWidth') == "")
            $filterParameters['minBandWidth'] = 0;
        else
            $filterParameters['minBandWidth'] = $request->get('minBandWidth');

        $filterParameters['allNetFlatTelephony'] = $request->get('allNetFlatTelephony');
        $filterParameters['allNetFlatInternet'] = $request->get('allNetFlatInternet');
        $filterParameters['allNetFlatSMS'] = $request->get('allNetFlatSMS');


        // determine the status of the tariffs as a filter parameter which are requested from "resources/views/tariffs/index.blade.php"
        // $statusOfTariffs:
        //  1 is show only active tariffs
        //  0 is show only disabled tariffs
        //  2 is show all tariffs

        if($statusOfTariffs == 1)// active tariffs
            $status = 1;
        else if($statusOfTariffs == 0) // disabled tariffs
            $status = 0;

        // Fetch the group of the tariffs according to providerID and status of the tariff group
        if($providerID == 0)
            // $providerID is 0 means all providers has been selected. In this case tariff group must be all.
            $tariffGroups = "";
        else
            $tariffGroups = TariffsGroup
                ::where('provider_id', $providerID)
                ->where('status', 1)
                ->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via public/js/allTariffListWithFilter2.js .
        // 0 indicates all...then fetch all tariffs of all providers.    //->properties()->where('name', 'max-Bandbreite')->wherePivot('value', '>=', $minBandWidth);
        if($providerID == 0)
            if($statusOfTariffs == 1) // 1, show only active tariffs
                $tariffs = Tariff
                    ::where('status', $status)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else if($statusOfTariffs == 0) // 0, show only disabled tariffs
                $tariffs = Tariff
                    ::where('status', $status)
                    ->orderBy('updated_at', 'DESC') // last deactivated tariffs will be top of the list...
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else if($statusOfTariffs == 2) //  2, show all tariffs
                $tariffs = Tariff
                    ::orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
        else
            // if providerID is not 0 then check if tariffGroupID is 0 or not...tariffGroupID of 0 indicates all groups
            if($tariffGroupID == 0)
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->orderBy('group_id')
                        ->get();
            else if($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
            else
                // fetch all tariffs according to providerID, tariffGroupID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->where('status', $status)
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->get();


        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id
        );
        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()->user()->office_id)
            ->get();

        // Prepare the html for the table including the related tariffs according to the providerID and tariffID...
        $out ="";
        foreach ($tariffs as $tariff){

            if($this->checkFilterParametersForTariff($tariff, $filterParameters)){
                $out .= "<tr>";
                $out .= "<td>" . $tariff->network->name . "</td>";
                $out .= "<td>" . $tariff->name . "</td>";

                $out .= "<td><button type=\"button\" class=\"btn btn-danger\" data-toggle=\"m-popover\" title=\"". $tariff->name. "data-html=\"true\"". "\" data-content=\"";
                if ($tariff->tariffsHighlight){
                    if($tariff->tariffsHighlight->content['internet1'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['internet1'] ."</li>";
                    if($tariff->tariffsHighlight->content['internet2'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['internet2'] ."</li>";
                    if($tariff->tariffsHighlight->content['internet3'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['internet3'] ."</li>";
                    if($tariff->tariffsHighlight->content['internet4'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['internet4'] ."</li>";
                    if($tariff->tariffsHighlight->content['SMS1'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['SMS1'] ."</li>";
                    if($tariff->tariffsHighlight->content['SMS2'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['SMS2'] ."</li>";
                    if($tariff->tariffsHighlight->content['SMS3'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['SMS3'] ."</li>";
                    if($tariff->tariffsHighlight->content['SMS4'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['SMS4'] ."</li>";
                    if($tariff->tariffsHighlight->content['telephony1'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['telephony1'] ."</li>";
                    if($tariff->tariffsHighlight->content['telephony2'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['telephony2'] ."</li>";
                    if($tariff->tariffsHighlight->content['telephony3'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['telephony3'] ."</li>";
                    if($tariff->tariffsHighlight->content['telephony4'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['telephony4'] ."</li>";
                    if($tariff->tariffsHighlight->content['other1'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['other1'] ."</li>";
                    if($tariff->tariffsHighlight->content['other2'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['other2'] ."</li>";
                    if($tariff->tariffsHighlight->content['other3'] != '')
                        $out .= "<li>". $tariff->tariffsHighlight->content['other3'] ."</li>";
                }
                $out .= "\">Info</button></td>";

                $out .= "<td>" . $tariff->base_price . "</td>";
                $out .= "<td>" . $tariff->provision . "</td>";
                $out .= "<td>";

                foreach($tariffsWithOnTopForTheDealer as $tariffWithOnTopForTheDealer){
                    if($tariffWithOnTopForTheDealer->id == $tariff->id)
                        $out .= $tariffWithOnTopForTheDealer->pivot->ontop;
                }

                $out .= "</td>";
                $out .= "<td>";
                if($tariff->status == 1) $out .= __('tariffs/index.active');  else  $out .= __('tariffs/index.disabled');
                $out .= "<button type=\"button\" class=\"btn btn-danger\" name=\" ". $tariff->name . " \" id=\" " . $tariff->id . "\">";
                $out .= __('tariffs/index.change');
                $out .= "</td>";

                $out .="<td>";

                if($tariff->provider_id == 1)
                    $out .="<a href=\"/tariff/vodafone/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                elseif($tariff->provider_id == 2)
                    $out .="<a href=\"/tariff/ayYildiz/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                elseif(($tariff->provider_id == 3))
                    $out .="<a href=\"/tariff/O2/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";

                $out .="</td>";
                $out .= "</tr>";
            }
        }

        // Send the tariffGroups and out to "tariffList-Provider.js" in json format.
        return response()->json(['tariffGroups' => $tariffGroups, 'out' => $out]);

    }
    public function setFilteredOutput($request){

        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $statusOfTariffs = $request->get('statusOfTariffs');// it is used in listing the tariffs whose statuses are active (1) or disabled (0).

        // set filter parameters
        $filterParameters['networkID'] = $request->get('networkID');

        // if maxBasePrice is not specified in the GUI (tariffs/index.blade.php)
        if($request->get('maxBasePrice') == "")
            $filterParameters['maxBasePrice'] = Tariff::max('base_price');
        else
            $filterParameters['maxBasePrice'] = $request->get('maxBasePrice');

        if($request->get('minDataVolume') == "")
            $filterParameters['minDataVolume'] = 0;
        else
            $filterParameters['minDataVolume'] = $request->get('minDataVolume');

        if($request->get('minBandWidth') == "")
            $filterParameters['minBandWidth'] = 0;
        else
            $filterParameters['minBandWidth'] = $request->get('minBandWidth');

        $filterParameters['allNetFlatTelephony'] = $request->get('allNetFlatTelephony');
        $filterParameters['allNetFlatInternet'] = $request->get('allNetFlatInternet');
        $filterParameters['allNetFlatSMS'] = $request->get('allNetFlatSMS');


        // determine the status of the tariffs as a filter parameter which are requested from "resources/views/tariffs/index.blade.php"
        // $statusOfTariffs:
        //  1 is show only active tariffs
        //  0 is show only disabled tariffs
        //  2 is show all tariffs

        if($statusOfTariffs == 1)// active tariffs
            $status = 1;
        else if($statusOfTariffs == 0) // disabled tariffs
            $status = 0;



        // Fetch the group of the tariffs according to providerID and status of the tariff group
        if($providerID == 0)
            // $providerID is 0 means all providers has been selected. In this case tariff group must be all.
            $tariffGroups = "";
        else
            $tariffGroups = TariffsGroup
                ::where('provider_id', $providerID)
                ->where('status', 1)
                ->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via public/js/allTariffListWithFilter2.js .
        // 0 indicates all...then fetch all tariffs of all providers.    //->properties()->where('name', 'max-Bandbreite')->wherePivot('value', '>=', $minBandWidth);
        if($providerID == 0)
            if($statusOfTariffs != 2)
                $tariffs = Tariff
                    ::where('status', $status)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else
                $tariffs = Tariff
                    ::orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
        else
            // if providerID is not 0 then check if tariffGroupID is 0 or not...tariffGroupID of 0 indicates all groups
            if($tariffGroupID == 0)
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->orderBy('group_id')
                        ->get();
            else if($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
                // fetch all tariffs according to providerID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('status', $status)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('action_tariff', 1)
                        ->orderBy('group_id')
                        ->get();
            else
                // fetch all tariffs according to providerID, tariffGroupID and filter parameters
                if($statusOfTariffs != 2)
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->where('status', $status)
                        ->get();
                else
                    $tariffs = Tariff
                        ::where('provider_id', $providerID)
                        ->where('group_id', $tariffGroupID)
                        ->get();


        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id
        );
        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()->user()->office_id)
            ->get();

        // Prepare the html for the table including the related tariffs according to the providerID and tariffID...
        $out ="";
        foreach ($tariffs as $tariff){

            if($this->checkFilterParametersForTariff($tariff, $filterParameters)){
                $out .= "<tr>";
                $out .= "<td>" . $tariff->network->name . "</td>";
                $out .= "<td>" . $tariff->name . "</td>";
                $out .= "<td><button type=\"button\" class=\"btn btn-danger\" data-toggle=\"m-popover\" title=\"". $tariff->name. "\" data-content=\"". $tariff->network->name . "\">Info</button></td>";
                $out .= "<td>" . $tariff->base_price . "</td>";
                $out .= "<td>" . $tariff->provision . "</td>";
                $out .= "<td>";

                foreach($tariffsWithOnTopForTheDealer as $tariffWithOnTopForTheDealer){
                    if($tariffWithOnTopForTheDealer->id == $tariff->id)
                        $out .= $tariffWithOnTopForTheDealer->pivot->ontop;
                }

                $out .= "</td>";
                $out .= "<td>";
                if($tariff->status == 1) $out .= __('tariffs/index.active');  else  $out .= __('tariffs/index.disabled');
                $out .= "<button type=\"button\" class=\"btn btn-danger\" name=\" ". $tariff->name . " \" id=\" " . $tariff->id . "\">";
                $out .= __('tariffs/index.change');
                $out .= "</td>";

                $out .="<td>";

                if($tariff->provider_id == 1)
                    $out .="<a href=\"/tariff/vodafone/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                elseif($tariff->provider_id == 2)
                    $out .="<a href=\"/tariff/ayYildiz/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";
                elseif(($tariff->provider_id == 3))
                    $out .="<a href=\"/tariff/O2/edit/".$tariff->id."\" type=\"button\" class=\"btn btn-primary\">". __('tariffs/index.edit')."</a>";

                $out .="</td>";
                $out .= "</tr>";
            }
        }

        // Send the tariffGroups and out to "tariffList-Provider.js" in json format.
        return response()->json(['tariffGroups' => $tariffGroups, 'out' => $out]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** TRANSFERRED TO VODAFONETARIFFCONTROLLER@CREATE
        $provider = Provider::where('id', 1)->first();
        $dealers = Dealer::all();
        $properties = Property::all();
        $networks = Network::all();
        return view('tariffs.vodafone.create', compact('provider', 'dealers', 'properties', 'networks'));
        */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /**TRANSFERRED TO VODAFONETARIFFCONTROLLER@STORE
        //** Save basic info of the new tariff
        $tariff = new Tariff();
        $tariff->setBasicInfo($request);

        // Set the REGION(s) of the newly created Vodafone tariff
        $regions = new Region();
        $regions->setVodafoneRegions($tariff, $request);

        // Set the PROVISION of the newly created tariff
        $tariffsProvisions = new TariffsProvision();
        $tariffsProvisions->setProvision($tariff->id, $request);

        // Set the ON-TOP of the newly created tariff
        $tariff->setOnTop($request);

        // Set the LIMIT of the newly created tariff
        $tariffsLimit = new TariffsLimit();
        $tariffsLimit->setLimit($tariff->id, $request);

        // Set the PROPERTIES of the newly created tariff
        $tariffsProperties = new Property();
        $tariffsProperties->setProperties($tariff, $request);

        // Set the HIGHLIGHTS of the newly created tariff
        $tariffsHighlights = new TariffsHighlight();
        //$tariffsHighlights->setHighlight($tariff->id, $request);


        // if the tariff to be created belongs to VODAFONE then perform vodafone-related activities...
        //  manageCreationProcess() manages all the activities related to creation of new Vodafone Tariff
        $vodafoneTariff = new VodafoneTariff();
        $vodafoneTariff->manageCreationProcess($tariff, $request);



        // if the tariff to be created belongs to AY YILDIZ then process ay yıldız related activities...


        // if the tariff to be created belongs to O2 then process O2 related activities...

        return back();

         */
    }


    /**
     * Show the form for creating new on-top cloning */
    public function createCloning(){

        return view('tariffs.onTopCloning');
    }

    /**
     * forward the program execution to set the on-top cloning */
    public function storeOnTopCloning(Request $request){
        $tariff = new Tariff();
        $tariff->setOnTopCloning($request);

        return redirect()->back()->with('storeMessage', 'success');
    }






    /**
     * Display the specified resource.
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
