<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Customer;
use App\CustomerContact;
use App\CustomerPaymentTool;
use App\Output;
use App\Service;
use App\ShoppingCart;
use App\Tariff;
use App\VfCreditActivation;
use App\VfGsm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Execution forwarded from "resources/views/contracts/shoppingCart.blade.php"
     * Show the GUI for creating a new contract.
     *
     */
    public function create(Request $request, $shoppingCartID){

        $shoppingCart = ShoppingCart
            ::where('id', $shoppingCartID)
            ->first();

        $SIMNumber =  $request->SIMNumber[$shoppingCartID];
        $IMEIOption = $request->IMEIOption[$shoppingCartID];
        $IMEINumber = $request->IMEINumber[$shoppingCartID];

        // anbiete ya göre hangi tarif alınacak tespit et. ona göre dienstler çekilebilir pivottan. Data mı Weiter mı? pivota eklese...
        if($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 1){


        }

        // Depending on the provider id of the selected item in the shopping cart,
        // the program will be forwarded to the respective page to fill out the contract.

        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone.
        if($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 1)
            return view('contracts.vodafone.create', compact('shoppingCart','SIMNumber', 'IMEIOption', 'IMEINumber' ));
        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız.
        elseif ($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 2)
            return view('contracts.ayYildiz.create', compact('shoppingCart'));
        else
            return view('contracts.O2.create', compact('shoppingCart'));
    }

    /**
     * Initialized when entering http://tokasdraft.com/contract/generate-XML
     *
     */
    public function callToGenerateXMLGUI(){
        return view('contracts.vodafone.generateXMLTRY');
    }
    /**
     * Execution forwarded from "resources/views/contracts/vodafone/generateXMLTRY.blade.php"
     *
     */
    public function forwardToGenerateXML(Request $request){


        // And, XML file will be produced.
        Contract::produceXMLForGsmVodafoneContract($request->contractID);

        redirect()->home();
    }



    /**
     * Execution forwarded from "resources/views/contracts/vodafone/finalize.blade.php"
     *
     * Forward the program execution to the related provider's controller's store function
     * according to the provider_id which is defined as hidden in the related create page (resources/views/contracts/vodafone/create.blade.php).
     */
    public function forwardToFinalize(Request $request){

        // Since "Finalize Vertrag" button has been pushed, "status" attribute of the contract table will be chanced.

        Contract::changeStatusOfContract($request->contractID, 1);

        // And, XML file will be produced.
        Contract::produceXMLForGsmVodafoneContract($request->contractID, $request);

        redirect('home');
    }

    /**
     * Execution forwarded from "resources/views/contracts/vodafone/create.blade.php"
     *
     * Forward the program execution to the related provider's controller's store function
     * according to the provider_id which is defined as hidden in the related create page (resources/views/contracts/vodafone/create.blade.php).
     */
    public function forwardToStore(Request $request)
    {
        /** 1 */
        // FIRST, store main info of the customer who is about to buy the tariff.
        Customer::store($request);

        /** 2 */
        // THEN, save the data in $request, related to the attributes in "CustomerContacts", "CustomerPaymentTool" and "Contracts" table which is common for all contracts of the providers.
        // And, depending on the provider and contract type related "store" function is called.
        // For example, "providerID" is 1 and "contractType" is 1 then "VfGsm::store($contractID, $request);" is called.

        // "CustomerContacts", "CustomerPaymentTool" and "Contracts" tables consist of "customer_id" field which is not included by the $request.
        // It is produced automatically when the customer main info is saved to the "Customers" table in previous step.
        // So we need to RETRIEVE customer_id of the customer who has just stored to the "Customer" table in previous step.
        if($request->customerType == 1 or $request->customerType == 3 ) // Private and SoHo customer
            $customerID = Customer
                ::where('identity_card_number', $request->mainCustomerIDNumber)
                ->first()->id;
        else if($request->customerType == 2) // Business customer
            $customerID = Customer
                ::where('company_registration_number', $request->companyRegistrationNumber)
                ->first()->id;

        // store the data related to the "CustomerContacts" of the customer
        CustomerContact::store($customerID, $request);

        // store the data related to the "CustomerPaymentTool" of the customer.
        CustomerPaymentTool::store($customerID, $request);

        // store the data related to the "Contracts" table.
        Contract::store($customerID, $request);

        /** 3 */
        // AND THEN, depending on the "provider_id" and "contract_type", forward the program execution to the related contract action;for VF: GSM, GSM-FNI porting, Porting, DC change, DSL.
        // But first, contract_id of the contract which has been stored in previous step is needed and must be retrieved.
        $contractID = DB::table('contracts')->latest()->first()->id;

        if($request->providerID == 1) // Contract for Vodafone
        {
            if($request->contractType == 1){ // new activation GSM - if($request->contract_type == 1 and $request->FNIPorting == 0)
                VfGsm::store($contractID, $request);
                // To finalize the process, call the below GUI
                return view('contracts.vodafone.finalize', compact('contractID'));
            }
            else if($request->contractType == 1){ // new activation GSM-FNI porting - if($request->contract_type == 1 and $request->FNIPorting == 1)

            }
            else if($request->contractType == 2){ // porting

            }
            else if($request->contractType == 3){ // DC change

            }
            else if($request->contractType == 4){ // DSL

            }
        }
        else if($request->providerID == 2) // Contract for Ay Yıldız
        {

        }
        else if($request->providerID == 3) // Contract for O2
        {

        }
    }
    public function forwardToStoreTRY(Request $request)
    {
        $formDataInCreateContract = $request->formDataInCreateContract;
        dd($request->formDataInCreateContract);

        /** 1 */
        // FIRST, store main info of the customer who is about to buy the tariff.
        Customer::store($formDataInCreateContract);

        /** 2 */
        // THEN, save the data in $request, related to the attributes in "CustomerContacts", "CustomerPaymentTool" and "Contracts" table which is common for all contracts of the providers.
        // And, depending on the provider and contract type related "store" function is called.
        // For example, "providerID" is 1 and "contractType" is 1 then "VfGsm::store($contractID, $request);" is called.

        // "CustomerContacts", "CustomerPaymentTool" and "Contracts" tables consist of "customer_id" field which is not included by the $request.
        // It is produced automatically when the customer main info is saved to the "Customers" table in previous step.
        // So we need to RETRIEVE customer_id of the customer who has just stored to the "Customer" table in previous step.
        if($formDataInCreateContract->customerType == 1 or $formDataInCreateContract->customerType == 3 ) // Private and SoHo customer
            $customerID = Customer
                ::where('identity_card_number', $formDataInCreateContract->mainCustomerIDNumber)
                ->first()->identity_card_number;
        else if($formDataInCreateContract->customerType == 2) // Business customer
            $customerID = Customer
                ::where('company_registration_number', $formDataInCreateContract->companyRegistrationNumber)
                ->first()->company_registration_number;

        // store the data related to the "CustomerContacts" of the customer
        CustomerContact::store($customerID, $formDataInCreateContract);

        // store the data related to the "CustomerPaymentTool" of the customer.
        CustomerPaymentTool::store($customerID, $formDataInCreateContract);

        // store the data related to the "Contracts" table.
        Contract::store($customerID, $formDataInCreateContract);

        /** 3 */
        // AND THEN, depending on the "provider_id" and "contract_type", forward the program execution to the related contract action;for VF: GSM, GSM-FNI porting, Porting, DC change, DSL.
        // But first, contract_id of the contract which has been stored in previous step is needed and must be retrieved.
        $contractID = DB::table('contracts')->latest()->first()->id;

        if($formDataInCreateContract->providerID == 1) // Contract for Vodafone
        {
            if($formDataInCreateContract->contractType == 1){ // new activation GSM - if($request->contract_type == 1 and $request->FNIPorting == 0)
                VfGsm::store($contractID, $formDataInCreateContract);
            }
            else if($formDataInCreateContract->contractType == 1){ // new activation GSM-FNI porting - if($request->contract_type == 1 and $request->FNIPorting == 1)

            }
            else if($formDataInCreateContract->contractType == 2){ // porting

            }
            else if($formDataInCreateContract->contractType == 3){ // DC change

            }
            else if($formDataInCreateContract->contractType == 4){ // DSL

            }
        }
        else if($formDataInCreateContract->providerID == 2) // Contract for Ay Yıldız
        {

        }
        else if($formDataInCreateContract->providerID == 3) // Contract for O2
        {

        }
    }
}
