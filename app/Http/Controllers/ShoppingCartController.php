<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use App\Tariff;
use Illuminate\Http\Request;

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

        return view('contracts.shoppingCart', compact('contents'));
    }

    /**
     * Add a new tariff to shopping cart.
     *
     */
    public function addTariff(Tariff $tariff)
    {
        $item = new ShoppingCart();
        $item->producer_id = $tariff->provider_id;
        $item->product_type = 1; //Tariff:1, Handy: 2
        $item->product_id = $tariff->id;
        $item->employee_id = auth()->user()->id;
        $item->office_id = auth()->user()->office_id;
        $item->dealer_id = auth()->user()->dealer_id;
        $item->save();

        $contents = ShoppingCart
            ::where('employee_id', auth()->user()->id)
            ->get();

        return view('contracts.shoppingCart', compact('contents'));

    }
    public function deleteTariff(Tariff $tariff)
    {
        $item = ShoppingCart
            ::where('product_type', 1)
            ->where('product_id', $tariff->id)
            ->first();

        $item->delete();

        $contents = ShoppingCart
            ::where('employee_id', auth()->user()->id)
            ->get();

        return view('contracts.shoppingCart', compact('contents'));
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
