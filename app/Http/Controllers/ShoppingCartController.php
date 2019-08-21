<?php

namespace App\Http\Controllers;

use App\Dealer;
use App\Provider;
use App\ShoppingCart;
use App\Tariff;
use App\TariffsGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
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

        /*
        $tariffs = Tariff::all();
        $VFnumber = 1;
        $AYnumber = 1;
        $O2number = 1;
        foreach($tariffs as $tariff){
            if($tariff->provider_id == 1){
                $tariff->name = "VF-Tariff-".$VFnumber;
                $tariff->tariff_code = "Code-VF-Tariff-".$VFnumber;
                $tariff->base_price = rand(25, 100);
                $tariff->provision = rand(500, 800);
                $VFnumber++;
                $tariff->save();
            }
            elseif ($tariff->provider_id == 2){
                $tariff->name = "AY-Tariff-".$AYnumber;
                $tariff->tariff_code = "Code-AY-Tariff-".$AYnumber;
                $tariff->base_price = rand(25, 100);
                $tariff->provision = rand(500, 800);
                $AYnumber++;
                $tariff->save();
            }
            else{
                $tariff->name = "O2-Tariff-".$O2number;
                $tariff->tariff_code = "Code-O2-Tariff-".$O2number;
                $tariff->base_price = rand(25, 100);
                $tariff->provision = rand(500, 800);
                $O2number++;
                $tariff->save();
            }
        }
        */

        // Fetch the content of the shopping cart for the current authorized user.
        $contents = ShoppingCart
            ::where('employee_id', auth()->user()->id)
            ->get();

        $totalBasePrice = 0;
        $totalProvision = 0;
        foreach ($contents as $content){
            $totalBasePrice += Tariff::where('id', $content->product_id)->first()->base_price;
            $totalProvision += Tariff::where('id', $content->product_id)->first()->provision;
        }

        return view('contracts.shoppingCartORJ', compact('contents', 'totalBasePrice', 'totalProvision'));
    }

    /**
     * Add a new tariff to shopping cart.
     *
     */
    public function addTariff(Tariff $tariff, $isAdditionalTariff)
    {
        $item = new ShoppingCart();
        $item->producer_id = $tariff->provider_id;
        $item->product_type = 1; //Tariff:1, Handy: 2
        $item->product_id = $tariff->id;
        $item->employee_id = auth()->user()->id;
        $item->office_id = auth()->user()->office_id;
        $item->dealer_id = auth()->user()->dealer_id;
        $item->additional_tariff = $isAdditionalTariff;
        $item->save();

        $contents = ShoppingCart
            ::where('employee_id', auth()->user()->id)
            ->get();

        $provider = Provider::find($tariff->provider_id);
        //dd(session('providerID'));

        $totalBasePrice = 0;
        $totalProvision = 0;
        foreach ($contents as $content){
            $totalBasePrice += Tariff::where('id', $content->product_id)->first()->base_price;
            $totalProvision += Tariff::where('id', $content->product_id)->first()->provision;
        }

        return view('contracts.shoppingCartORJ', compact('contents', 'provider', 'totalBasePrice', 'totalProvision'));
    }
    public function deleteTariff(Tariff $tariff)
    {
        $item = ShoppingCart
            ::where('product_type', 1)
            ->where('product_id', $tariff->id)
            ->first();

        $item->delete();

        $contents = ShoppingCart
            ::where('product_type', 1)
            ->where('dealer_id', auth()->user()->dealer_id)
            ->where('office_id', auth()->user()->office_id)
            ->where('employee_id', auth()->user()->id)
            ->get();

        $provider = Provider::find($tariff->provider_id);

        $totalBasePrice = 0;
        $totalProvision = 0;
        foreach ($contents as $content){
            $totalBasePrice += Tariff::where('id', $content->product_id)->first()->base_price;
            $totalProvision += Tariff::where('id', $content->product_id)->first()->provision;
        }

        return view('contracts.shoppingCartORJ', compact('contents', 'provider', 'totalBasePrice', 'totalProvision'));
    }
    public function changeTariff(Tariff $tariff){
        //remove the tariff from the shopping cart
        $item = ShoppingCart
            ::where('product_type', 1)
            ->where('product_id', $tariff->id)
            ->first();

        $item->delete();

        // view the page to list the tariff according to the provider ID

        /* The below code is NOT necessary since it is already set.
        //providerID session variable is created here.
        if(session()->exists('providerID')){
            session()->forget('providerID');
        }
        else{
            Session::put('providerID',$provider->id);
        }
        */

        $provider = Provider::find(session('providerID'));
        $isAdditionalTariff = 0; // since the main tariff is to be changed.

        // Take tariffs of the provider.
        $tariffs = Tariff
            ::where('provider_id', session('providerID'))
            ->get();
        $tariffGroups = TariffsGroup
            ::where('provider_id', session('providerID'))
            ->get();

        // Determine all tariffs with on-tops for authenticated user's office (dealer) in "on_top" pivot table.
        $dealer = Dealer::find(auth()
            ->user()
            ->dealer_id);

        $tariffsWithOnTopForTheDealer = $dealer->tariffs()
            ->wherePivot('office_id', auth()
            ->user()->office_id)
            ->get();

        return view('tariffs.vodafone.index', compact('tariffs','tariffGroups', 'tariffsWithOnTopForTheDealer', 'provider', 'isAdditionalTariff'));
    }

    /**
     * called from resources/views/contracts/vodafone/enterSimImeiServices.blade.php
     */
    public function saveSimImeiServicesToSession(Request $request, Tariff $tariff, $isAdditionalTariff){

        // Save SIM number, IMEI option and services of the tariff to a Session as an associative array
        // It is used id app/VfGsm.php store()
        if($isAdditionalTariff == 1) // No connection fee
            $simImeiServicesOfTheTariff = [
            'tariffID' => $tariff->id,
            'isAdditionalTariff' => $isAdditionalTariff,
            'SIMNumber' => $request->SIMNumber,
            'IMEIOption' => $request->IMEIOption,
            'IMEINumber' => $request->IMEINumber,
            'contractStartDate' => $request->contractStartDate,

            'connectionOverview' => $request->connectionOverview,
            'destinationNumberRepresentation' => $request->destinationNumberRepresentation,
            'callBarring' => $request->callBarring,
            'mailbox' => $request->mailbox,
            'telephoneNumberTransmission' => $request->telephoneNumberTransmission,
            'additionalServices' => $request->additionalServices,
            'dataServices' => $request->dataServices
        ];
        else
            $simImeiServicesOfTheTariff = [
                'tariffID' => $tariff->id,
                'isAdditionalTariff' => $isAdditionalTariff,
                'SIMNumber' => $request->SIMNumber,
                'IMEIOption' => $request->IMEIOption,
                'IMEINumber' => $request->IMEINumber,
                'contractStartDate' => $request->contractStartDate,
                'connectionFee'=> $request->connectionFee,
                'connectionOverview' => $request->connectionOverview,
                'destinationNumberRepresentation' => $request->destinationNumberRepresentation,
                'callBarring' => $request->callBarring,
                'mailbox' => $request->mailbox,
                'telephoneNumberTransmission' => $request->telephoneNumberTransmission,
                'additionalServices' => $request->additionalServices,
                'dataServices' => $request->dataServices
            ];

        //Session::put($tariff->id, $request->SIMNumber); ***** Numerical values ($tariff->id) can NOT be a KEY

        if (session()->exists($tariff->name)) {
            session()->forget($tariff->name);
            Session::put($tariff->name, $simImeiServicesOfTheTariff);
        }
        else{
            Session::put($tariff->name, $simImeiServicesOfTheTariff);
        }
/*
                             foreach(ShoppingCart::all() as $shoppingCart){
                                 if($shoppingCart->product_type == 1){// the product is Tariff not handy
                                     $simImeiServicesFromSession = session($shoppingCart->product_id);
                                     echo "In For- ID: ".$shoppingCart->product_id;
                                     echo " \n";
                                     echo "SIM: ".$simImeiServicesFromSession['SIMNumber'];
                                     echo " \n";

                                 }
                             }

                $simImeiServicesFromSession = Session::get( 'VF-Tariff-1');
                echo "-: ".($simImeiServicesFromSession['IMEIOption']);
                echo "\n";
                $simImeiServicesFromSession = Session::get('VF-Tariff-4');
                 echo "-: ".($simImeiServicesFromSession['IMEIOption']);
                echo "\n";
*/


        // return to the shopping cart

        $contents = ShoppingCart
            ::where('product_type', 1)
            ->where('dealer_id', auth()->user()->dealer_id)
            ->where('office_id', auth()->user()->office_id)
            ->where('employee_id', auth()->user()->id)
            ->get();

        $provider = Provider::find($tariff->provider_id);

        $totalBasePrice = 0;
        $totalProvision = 0;
        foreach ($contents as $content){
            $totalBasePrice += Tariff::where('id', $content->product_id)->first()->base_price;
            $totalProvision += Tariff::where('id', $content->product_id)->first()->provision;
        }

        return view('contracts.shoppingCartORJ', compact('contents', 'provider', 'totalBasePrice', 'totalProvision'));
    }

    /**
     * called from  resources/views/contracts/shoppingCartORJ.blade.php
     *
     */
    public function callToSimImeiServicesGUI(Tariff $tariff, $isAdditionalTariff){
        return view('contracts.vodafone.enterSimImeiServices', compact('tariff', 'isAdditionalTariff'));
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
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }
}
