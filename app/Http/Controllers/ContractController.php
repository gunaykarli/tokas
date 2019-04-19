<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use Illuminate\Http\Request;

class ContractController extends Controller
{
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
}
