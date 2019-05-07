<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Customer;
use App\CustomerContact;
use App\CustomerPaymentTool;
use App\Output;
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

        // FIRST, store main info of the customer who is about to buy the tariff.
        Customer::store($request);

        // THEN, save the data in $request, related to the attributes in "Contacts" and "Contracts" table which is common for all contracts of the providers.
        // "Contacts" and "Contracts" table consists of customer_id which is not included by the $request.
        // It is produced automatically when the customer main info is saved to the "Customers" table.

        // So we need to RETRIEVE customer_id of the customer who has just stored to the "Customer" table in previous step.
        if($request->customerType == 1 or $request->customerType == 3 ) // Private and SoHo customer
            $customerID = Customer::where('identity_card_number', $request->mainCustomerIDNumber)->first()->identity_card_number;
        else if($request->customerType == 2) // Business customer
            $customerID = Customer::where('company_registration_number', $request->companyRegistrationNumber)->first()->company_registration_number;

        // store the contact info of the customer
        CustomerContact::store($customerID, $request);

        // save the bank and credit card info of the customer.
        CustomerPaymentTool::store($customerID, $request);

        // store the data related to the "Contracts" table.
        Contract::store($customerID, $request);

        // AND THEN, depending on the "provider_id" and "contract_type" forward the program execution to the related contract action;for VF: GSM, GSM-FNI porting, Porting, DC change, DSL.
        if($request->provider_id == 1) // Contract for Vodafone
        {
            if($request->contract_type == 1){ // new activation GSM - if($request->contract_type == 1 and $request->FNIPorting == 0)
                //VfGsm::store($request);
            }
            else if($request->contract_type == 1){ // new activation GSM-FNI porting - if($request->contract_type == 1 and $request->FNIPorting == 1)

            }
            else if($request->contract_type == 2){ // porting

            }
            else if($request->contract_type == 3){ // DC change

            }
            else if($request->contract_type == 4){ // DSL

            }
        }
        else if($request->provider_id == 2) // Contract for Ay Yıldız
        {

        }
        else if($request->provider_id == 3) // Contract for O2
        {

        }


    }
}
