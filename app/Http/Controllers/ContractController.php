<?php

namespace App\Http\Controllers;

use App\Contract;
use App\ShoppingCart;
use App\VfCreditActivation;
use App\VfGsm;
use Illuminate\Http\Request;

class ContractController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the GUI for creating a new contract.
     *
     */
    public function create(ShoppingCart $shoppingCart){

        // Depending on the provider id of the selected item in the shopping cart,
        // the program will be forwarded to the respective page to fill out the contract.

        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone.
        if($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 1)
            return view('contracts.vodafone.create', compact('shoppingCart'));
        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone.
        elseif ($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 2)
            return view('contracts.ayYildiz.create', compact('shoppingCart'));
        else
            return view('contracts.O2.create', compact('shoppingCart'));
    }

    /**
     * Forward the program execution to the related provider's controller's store function
     * according to the provider_id which is defined as hidden in the related create page (resources/views/contracts/vodafone/create.blade.php).
     */
    public function forward(Request $request)
    {
        // First, save the data in $request related to the attributes in "Contracts" table which is common for all contracts of the providers
        $contract = new Contract();

        // Then, depending on the "provider_id" and "contract_type" forward the program execution to the related contract action.
        if($request->provider_id == 1)// Contract for Vodafone
        {
            if($request->contract_type == 1){ // new activation GSM
                VfGsm::store($request);
            }

            else if($request->contract_type == 2){}
            // porting
            else if($request->contract_type == 3){}
            // DC change
            else if($request->contract_type == 4){}
            // DSL
        }
        else if($request->provider_id == 2)// Contract for Ay Yıldız
        {

        }
        else if($request->provider_id == 3)// Contract for O2
        {

        }
    }
}
