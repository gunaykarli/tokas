<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Customer;
use App\CustomerContact;
use App\CustomerInvoiceAddress;
use App\CustomerPaymentTool;
use App\Dealer;
use App\MyCustomLibrary\ContractTexts\ContractTexts;
use App\MyCustomLibrary\ProducePDFWithFPDF;
use App\MyCustomLibrary\PDF\Pdf;
use App\Output;
use App\Property;
use App\Provider;
use App\Region;
use App\Service;
use App\ShoppingCart;
use App\Tariff;
use App\TariffsGroup;
use App\VfCreditActivation;
use App\VfGsm;
use Carbon\Carbon;
use Com\Tecnick\Pdf\Tcpdf;
use Crabbly\FPDF\FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Display a listing of the tariffs of all providers
     * it can be called
     * 1. For the first time when the dealer wants to make a contract the list of the tariff should be listed so it is called.
     * 2. From the shopping chart: in progressing of the making contract dealer visit the list of the tariffs and the shopping cart. So it is called from the shopping cart.
     *  when it is called from the shopping cart for the VODAFONE tariff, tariff type must be known, main tariff or additional tariff. Because of this "additionalTariff" variable should be used as a parameter
     */
    public function tariffs()
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


        return view('contracts.tariffs', compact('tariffs', 'tariffsWithOnTopForTheDealer', 'providers'));
    }

    /** filters the tariffs according to the filter parameters in "resources/views/contracts/tariffs.blade.php" */
    public function filterTariffs(Request $request)
    {
        $providerID = $request->get('providerID');
        $tariffGroupID = $request->get('tariffGroupID');
        $statusOfTariffs = 1; // it is used in listing the tariffs whose statuses are active (1) or disabled (0).


        // set filter parameters

        $filterParameters['networkID'] = $request->get('networkID');

        // if maxBasePrice is not specified in the GUI (tariffs/index.blade.php)
        if ($request->get('maxBasePrice') == "")
            $filterParameters['maxBasePrice'] = Tariff::max('base_price');
        else
            $filterParameters['maxBasePrice'] = $request->get('maxBasePrice');

        if ($request->get('minDataVolume') == "")
            $filterParameters['minDataVolume'] = 0;
        else
            $filterParameters['minDataVolume'] = $request->get('minDataVolume');

        if ($request->get('minBandWidth') == "")
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

        if ($statusOfTariffs == 1)// only active tariffs will be listed
            $status = 1;
        else if ($statusOfTariffs == 0) // only disabled tariffs will be listed
            $status = 0;


        // Fetch the group of the tariffs according to providerID.
        if ($providerID == 0)
            // $providerID is 0 means all providers has been selected. In this case tariff group must be "all".
            $tariffGroups = "";
        else
            $tariffGroups = TariffsGroup
                ::where('provider_id', $providerID)
                ->where('status', 1)
                ->get();

        // Take the tariffs from the DB according to the providerID, tariffGroupID and filter parameters sent by the tariff.index via public/js/allTariffListWithFilter2.js .
        // 0 indicates all...then fetch all tariffs of all providers.    //->properties()->where('name', 'max-Bandbreite')->wherePivot('value', '>=', $minBandWidth);
        if ($providerID == 0) {
            if ($statusOfTariffs == 1) // 1, show only active tariffs
                $tariffs = Tariff
                    ::where('status', $status)
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else if ($statusOfTariffs == 0) // 0, show only disabled tariffs
                $tariffs = Tariff
                    ::where('status', $status)
                    ->orderBy('updated_at', 'DESC')// last deactivated tariffs will be top of the list...
                    ->orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
            else if ($statusOfTariffs == 2) //  2, show all tariffs
                $tariffs = Tariff
                    ::orderBy('provider_id')
                    ->orderBy('group_id')
                    ->get();
        } else {
            // if providerID is not 0 then check if tariffGroupID is 0 or not...tariffGroupID of 0 indicates all groups
            if ($tariffGroupID == 0)
                // fetch all tariffs according to providerID and filter parameters
                if ($statusOfTariffs != 2)
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
            else if ($tariffGroupID == 1) //tariffGroupID 1 indicates that tariffs in "AktionsTarife" groups will be listed...
                // fetch all tariffs according to providerID and filter parameters
                if ($statusOfTariffs != 2)
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
                if ($statusOfTariffs != 2)
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
        $out = "";
        foreach ($tariffs as $tariff) {

            if ($this->checkFilterParametersForTariff($tariff, $filterParameters)) {
                $out .= "<tr>";
                $out .= "<td>" . $tariff->network->name . "</td>";
                $out .= "<td>" . $tariff->name . "</td>";

                $out .= "<td>";
                $out .= "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"m-popover\" title=\"" . $tariff->name . "\"";
                $out .= " data-html=\"true\" data-content= \" Lorem \"";

                /**
                 * if ($tariff->tariffsHighlight){
                 * if($tariff->tariffsHighlight->content['internet1'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['internet1'] ."</li>";
                 * if($tariff->tariffsHighlight->content['internet2'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['internet2'] ."</li>";
                 * if($tariff->tariffsHighlight->content['internet3'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['internet3'] ."</li>";
                 * if($tariff->tariffsHighlight->content['internet4'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['internet4'] ."</li>";
                 * if($tariff->tariffsHighlight->content['SMS1'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['SMS1'] ."</li>";
                 * if($tariff->tariffsHighlight->content['SMS2'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['SMS2'] ."</li>";
                 * if($tariff->tariffsHighlight->content['SMS3'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['SMS3'] ."</li>";
                 * if($tariff->tariffsHighlight->content['SMS4'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['SMS4'] ."</li>";
                 * if($tariff->tariffsHighlight->content['telephony1'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['telephony1'] ."</li>";
                 * if($tariff->tariffsHighlight->content['telephony2'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['telephony2'] ."</li>";
                 * if($tariff->tariffsHighlight->content['telephony3'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['telephony3'] ."</li>";
                 * if($tariff->tariffsHighlight->content['telephony4'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['telephony4'] ."</li>";
                 * if($tariff->tariffsHighlight->content['other1'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['other1'] ."</li>";
                 * if($tariff->tariffsHighlight->content['other2'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['other2'] ."</li>";
                 * if($tariff->tariffsHighlight->content['other3'] != '')
                 * $out .= "<li>". $tariff->tariffsHighlight->content['other3'] ."</li>";
                 * }
                 */
                $out .= ">Info";
                $out .= "</button></td>";

                $out .= "<td>" . $tariff->base_price . "</td>";
                $out .= "<td>" . $tariff->provision . "</td>";
                $out .= "<td>";

                foreach ($tariffsWithOnTopForTheDealer as $tariffWithOnTopForTheDealer) {
                    if ($tariffWithOnTopForTheDealer->id == $tariff->id)
                        $out .= $tariffWithOnTopForTheDealer->pivot->ontop;
                }
                $out .= "</td>";

                $out .= "<td>";

                foreach ($tariffsWithOnTopForTheDealer as $tariffWithOnTopForTheDealer) {
                    if ($tariffWithOnTopForTheDealer->id == $tariff->id)
                        $out .= $tariff->provision + $tariffWithOnTopForTheDealer->pivot->ontop;
                }
                $out .= "</td>";

                $out .= "<td>";
                $out .= "<a href=\"/contract/shopping-cart/add-tariff/" .$tariff->id . "\" class=\"btn btn-primary\" ><span>" . __('tariffs/index.order') . "</span></a>";
                $out .= "</td>";

                $out .= "</tr>";
            }
        }

        // Send the tariffGroups and out to "tariffList-Provider.js" in json format.
        return response()->json(['tariffGroups' => $tariffGroups, 'out' => $out]);
    }

    // checks if a tariffs's property meets filter parameters
    public function checkFilterParametersForTariff($tariff, $filterParameters)
    {

        // network check
        if ($filterParameters['networkID'] != 0) { // 0 means all networks. No filter.
            if ($tariff->network_id != $filterParameters['networkID']) {
                return 0;
            }
        }

        // maxBasePrice check
        if (!($tariff->base_price <= $filterParameters['maxBasePrice'])) {
            return 0;
        }

        /**
         * // max-Bandbreite check
         * // find the value of the property (max-Bandbreite) in pivot table for the tariff.
         * $minBandWidthObject = DB::table('property_tariff')
         * ->where('tariff_id', $tariff->id)
         * ->where('property_id', '=', Property
         * ::where('name', 'max-Bandbreite')
         * ->first()
         * ->id)
         * ->first();
         *
         * if($minBandWidthObject){
         * if( !($minBandWidthObject->amount_of_value >= $filterParameters['minBandWidth'])){
         * return 0;
         * }
         * }
         * else
         * //return 0;
         *
         * // Datenvolumen check
         * // find the value of the property (Datenvolumen) in pivot table for the tariff.
         * $minDataVolumeObject = DB::table('property_tariff')
         * ->where('tariff_id',$tariff->id)
         * ->where('property_id', '=', Property
         * ::where('name', 'Datenvolumen')
         * ->first()
         * ->id)
         * ->first();
         *
         * if($minDataVolumeObject){
         * if( !($minDataVolumeObject->amount_of_value >= $filterParameters['minDataVolume'])){
         * return 0;
         * }
         * }
         * else
         * //return 0;
         */
        // allNetFlatTelephony check
        if ($filterParameters['allNetFlatTelephony'] != "false") { // "false" means, "no filter" for "allNetFlatTelephony" parameter...
            // find the value of the property (allNetFlatTelephony) in pivot table for the tariff.
            $allNetFlatTelephonyObject = DB::table('property_tariff')
                ->where('tariff_id', $tariff->id)
                ->where('property_id', '=', Property
                    ::where('name', 'Telefonie')
                    ->first()
                    ->id)
                ->first();


            if ($allNetFlatTelephonyObject) {
                if ($allNetFlatTelephonyObject->amount_of_value != 1) {
                    return 0;
                }
            } else {
                return 0;
            }
        }


        // allNetFlatInternet check
        if ($filterParameters['allNetFlatInternet'] != "false") { // "false" means, "no filter" for "allNetFlatInternet" parameter...
            // find the value of the property (allNetFlatInternet) in pivot table for the tariff.
            $allNetFlatInternetObject = DB::table('property_tariff')
                ->where('tariff_id', $tariff->id)
                ->where('property_id', '=', Property
                    ::where('name', 'Internet')
                    ->first()
                    ->id)
                ->first();

            if ($allNetFlatInternetObject) {
                if ($allNetFlatInternetObject->amount_of_value != 1) {
                    return 0;
                }
            } else
                return 0;
        }

        // allNetFlatSMS check
        if ($filterParameters['allNetFlatSMS'] != "false") { // "false" means, "no filter" for "allNetFlatSMS" parameter...
            // find the value of the property (allNetFlatSMS) in pivot table for the tariff.
            $allNetFlatSMSObject = DB::table('property_tariff')
                ->where('tariff_id', $tariff->id)
                ->where('property_id', '=', Property
                    ::where('name', 'SMS')
                    ->first()
                    ->id)
                ->first();

            if ($allNetFlatSMSObject) {
                if ($allNetFlatSMSObject->amount_of_value != 1) {
                    return 0;
                }
            } else
                return 0;
        }


        // if all property of the tariff meet all filter parameters, then return 1. Otherwise function sends return 0 in above codes...
        return 1;

    }

    /**
     * Execution forwarded from "resources/views/contracts/shoppingCart.blade.php"
     * Show the GUI for creating a new contract.
     */
    public function create($providerID)
    {

        // Depending on the provider id of the selected item in the shopping cart,
        // the program will be forwarded to the respective page to fill out the contract.
        // NOT USED NOW...session('providerID') can be used. It is created in tariffs.providers.

        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone.
        if ($providerID == 1)
            return view('contracts.vodafone.create');
        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız.
        elseif ($providerID == 2)
            return view('contracts.ayYildiz.create', compact('shoppingCart'));
        elseif ($providerID == 3)
            return view('contracts.O2.create', compact('shoppingCart'));
    }

    public function create_1007()
    {

        // Depending on the provider id of the selected item in the shopping cart,
        // the program will be forwarded to the respective page to fill out the contract.
        // session('providerID') can be used. It is created in tariffs.providers.

        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone.
        if (session('providerID') == 1)
            return view('contracts.vodafone.create');
        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız.
        elseif (session('providerID') == 2)
            return view('contracts.ayYildiz.create', compact('shoppingCart'));
        else
            return view('contracts.O2.create', compact('shoppingCart'));
    }

    public function create_0705(Request $request, $shoppingCartID)
    {

        $shoppingCart = ShoppingCart
            ::where('id', $shoppingCartID)
            ->first();

        $SIMNumber = $request->SIMNumber[$shoppingCartID];
        $IMEIOption = $request->IMEIOption[$shoppingCartID];
        $IMEINumber = $request->IMEINumber[$shoppingCartID];

        // anbiete ya göre hangi tarif alınacak tespit et. ona göre dienstler çekilebilir pivottan. Data mı Weiter mı? pivota eklese...
        if ($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 1) {


        }

        // Depending on the provider id of the selected item in the shopping cart,
        // the program will be forwarded to the respective page to fill out the contract.
        // session('providerID') can be used. It is created in tariffs.providers.

        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone.
        if ($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 1)
            return view('contracts.vodafone.create', compact('shoppingCart', 'SIMNumber', 'IMEIOption', 'IMEINumber'));
        // if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız.
        elseif ($shoppingCart->product_type == 1 and $shoppingCart->producer_id == 2)
            return view('contracts.ayYildiz.create', compact('shoppingCart'));
        else
            return view('contracts.O2.create', compact('shoppingCart'));
    }

    /**
     * Execution forwarded from "resources/views/contracts/vodafone/create.blade.php"
     *
     * Forward the program execution to the related provider's controller's store function
     * according to the provider_id which is defined as hidden in the related create page (resources/views/contracts/vodafone/create.blade.php).
     */
    public function storeVodafone(Request $request)
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
        if ($request->customerType == 1 or $request->customerType == 3) // Private and SoHo customer
            $customerID = Customer
                ::where('identity_card_number', $request->mainCustomerIDNumber)
                ->first()->id;
        else if ($request->customerType == 2) // Business customer
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

        // fetch the tariffs belonging to the current employee and provider. And send the finalize page
        $contents = ShoppingCart
            ::where('producer_id', 1)
            ->where('product_type', 1)
            ->where('employee_id', auth()->user()->id)
            ->get();

        $totalBasePrice = 0;
        $totalProvision = 0;
        foreach ($contents as $content) {
            $totalBasePrice += Tariff::where('id', $content->product_id)->first()->base_price;
            $totalProvision += Tariff::where('id', $content->product_id)->first()->provision;
        }


        if ($request->contractType == 1) { // new activation GSM - if($request->contract_type == 1 and $request->FNIPorting == 0)
            VfGsm::store($contractID, $request);
            // To finalize the process, call the below GUI
            return view('contracts.vodafone.summaryGSM', compact('contractID', 'contents', 'totalBasePrice', 'totalProvision'));
        } else if ($request->contractType == 1) { // new activation GSM-FNI porting - if($request->contract_type == 1 and $request->FNIPorting == 1)

        } else if ($request->contractType == 2) { // porting

        } else if ($request->contractType == 3) { // DC change

        } else if ($request->contractType == 4) { // DSL

        }
    }

    /**
     * called in "summaryGSM.blade.php" by clicking print button
     */
    public function printVodafone($contractID){


        $text = "The year 1866 was marked by a
bizarre development, an unexplained and downright inexplicable phenomenon that surely no one has forgotten. Without getting into those rumors that upset civilians in the seaports and deranged the public mind even far inland, it must be said
that professional seamen were especially alarmed. Traders, shipowners, captains of vessels, skippers, and master mariners from Europe and America, naval officers from every country, and at their heels the various national governments on these two
continents, were all extremely disturbed by the business. In essence, over a period of time several ships had encountered \"an enormous thing\" at sea, a long spindle-shaped object, sometimes giving off a phosphorescent glow,
infinitely bigger and faster than any whale.";


        $pdf = new Pdf();
        $title = '20000 Leagues Under the Seas';
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Jules Verne');
        $pdf->PrintChapter(1,'A RUNAWAY REEF',$text.$text.$text.$text.$text.$text.$text.$text.$text.$text.$text.$text);
        $pdf->PrintChapter(2,'THE PROS AND CONS',$text.$text.$text.$text.$text);
        //$pdf->Output();
        //save file
        Storage::put('TokasPdf6.pdf', $pdf->Output('S'));
    }

    public function printVodafone_v1($contractID){
    // Die fpdf Daten werden inkludiert
    //include (app_path() . 'public/libraries/pdfPrint/CreditRequestTexte.php');
    //include ('C:\xampp\htdocs\UserDefined\TokasDraft\public\libraries\pdfPrint\fpdf4credit.php');
    //include (app_path() . 'public/libraries/pdfPrint/fpdi.php');
    //include ('C:\xampp\htdocs\UserDefined\TokasDraft\public\libraries\pdfPrint\CreditRequestTexte.php');


    // Fetch related data from the database...
    $contract = Contract
        ::where('id', $contractID)
        ->first();

    $tariff = Tariff::find($contract->tariff_id);

    $customer = Customer
        ::where('id', $contract->customer_id)
        ->first();

    $customerContact = CustomerContact
        ::where('customer_id', $customer->id)
        ->first();

    $customerInvoiceAddress = CustomerInvoiceAddress
        ::where('customer_id', $customer->id)
        ->first();

    $customerPaymentTool = CustomerPaymentTool
        ::where('customer_id', $customer->id)
        ->first();

    // there may be more than one gsm like additional gsm...
    $mainCardVfGsm = VfGSM
        ::where('contract_id', $contract->id)
        ->where('additional_tariff', 0) // 0 means the tariff is not additional, main.
        ->first();

    // Fetch the VF-GSM with the current contract ID from "VfGsm" table
    $allCardsVfGsmInTheContract = VfGsm
        ::where('contract_id', $contractID)
        ->get();

    $dateTime = Carbon::now();
    $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

    $eins = 1; //Setzen des Startpunktes f�r die Nummerierung der einzelnen Abs�tze
    $zwei = 1;

    //if($tariff->code != "VFZH24FFN"){
    if(1){


        //$DocAdresse = getTarif($enti[Tarif], TarifInfoDoc);
        $DocAdresse = "keine";



        //*********************************************************************************************************************
        //*********************************************************************************************************************
        //*********************************************************************************************************************

        $pdf= new Pdf();

        $pdf->SetMargins(10,22);
        $pdf->AddPage();


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Kopfzeile
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $textAufagskopf = "The year 1866 was marked by a
            bizarre development, an unexplained and downright inexplicable phenomenon that surely no one has forgotten. Without getting into those rumors that upset civilians in the seaports and deranged the public mind even far inland, it must be said
            that professional seamen were especially alarmed. Traders, shipowners, captains of vessels, skippers, and master mariners from Europe and America, naval officers from every country, and at their heels the various national governments on these two
            continents, were all extremely disturbed by the business. In essence, over a period of time several ships had encountered \"an enormous thing\" at sea, a long spindle-shaped object, sometimes giving off a phosphorescent glow,
            infinitely bigger and faster than any whale.";
        $x=10;
        $y=22;

        $pdf->SetFont('Arial','B',8);
        $pdf->SetY($y);
        $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

        $pdf->SetFont('Arial','',8);
        $pdf->SetXY($x+42,$y);
        $pdf->MultiCell(35,3.7,"[AuftragsTyp]"."\n"."[Vertragsbeginn]"."\n"."[Kundenkennwort]");

        $y=$pdf->GetY()+1;

        $pdf->SetFont('Arial','',5);
        $pdf->SetXY(10,$y);
        $pdf->MultiCell(90,2.5, $textAufagskopf);

        $y=$pdf->GetY()+1;


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Privatkunde
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $pdf->SetFont('Arial','B',8.5);
        $pdf->SetY($y);
        $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '."[Kundentyp]",1);

        $y=$pdf->GetY()+1;

        $pdf->SetFont('Arial','B',8);
        $pdf->SetY($y);
        $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY($x+42,$y);
        $pdf->MultiCell(35,3.7,"[Anrede]" ."\n".''."\n"."[Name]"."\n"."[Vorname]"."\n".substr("[Geburtsdatum]",8,2).".".substr("[Geburtsdatum]",5,2).".".substr("[Geburtsdatum]",0,4)."\n"."[Ausweisnummer]"."\n\n"."[BankKartenKreditInstitut]"."\n\n"."[BankKartenNummer]"."\n"."[BankKarteGueltigM]"." / "."[BankKarteGueltigJ]");

        $y=$pdf->GetY()+1;
        $pdf->SetFont('Arial','',5);
        $pdf->SetXY(10,$y);
        $pdf->MultiCell(90,2.5, $textAufagskopf);

        $y=$pdf->GetY()+1;
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Anschrift
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $pdf->SetFont('Arial','B',8.5);
        $pdf->SetY($y);
        $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Anschrift',1);

        $y=$pdf->GetY()+1;

        $pdf->SetFont('Arial','B',8);
        $pdf->SetY($y);
        $pdf->MultiCell(35,3.7,'Stra�e:'."\n".'PLZ, Ort:'."\n".'Telefon:'."\n".'E-Mail:'."\n".'Ansprechpartner:');

        $pdf->SetFont('Arial','',8);
        $pdf->SetXY($x+42,$y);
        $pdf->MultiCell(60,3.7,"[Strasse]"." "."[Hausnummer]"."\n"."PLZ]"." "."[Ort]"."\n"."0049"." / "."[Kontaktrufnummer]"."\n"."[Email]"."\n"."[Ansprechpartner]");
        $y=$pdf->GetY()+1;

        $pdf->SetFont('Arial','',5);
        $pdf->SetXY(10,$y);
        $pdf->MultiCell(90,2.5, $textAufagskopf.$textAufagskopf.$textAufagskopf.$textAufagskopf.$textAufagskopf);


        $y=$pdf->GetY()+1;


    }
    $DocAdresse = "Formulare/Vertragliche_Datenschutzhinweise.pdf";
    $pagecount = $pdf->setSourceFile($DocAdresse);

    $pdf->Output('d');
    Storage::put('TokasPdf1.pdf', $pdf->Output('d'));


    //save file
    //Storage::put('TokasPdf2.pdf', $pdf->Output('S'));


}

    public function printVodafone_v2($contractID){

        $eins = 1; //Setzen des Startpunktes f�r die Nummerierung der einzelnen Abs�tze
        $zwei = 1;


        // Die fpdf Daten werden inkludiert
        include ('CreditRequestTexte.php');
        //include ('fpdf4credit.php');
        include(app_path() . '/MyCustomLibrary/PDF/fpdi.php');

        //if($tariff->code != "VFZH24FFN"){
        if(1){
            $GLOBALS["festport"] = "ja";

            $pdf=new FPDI();

            /*
             * Wenn der Tarif Zuhause Festnetzflat ist, wird die Datei  ZuhauseFestnetzFlat_Portierungsformular zu Auftrag hinzugef�gt
             */
            $pagecount = $pdf->setSourceFile("Formulare/ZuhauseFestnetzFlat_Portierungsformular_3.pdf");

            // Standard fpdf Befehle f�r das Erstellen einer Seite
            $tplidx = $pdf->importPage(1);//Seitenzahl
            $pdf->addPage();
            $pdf->useTemplate($tplidx);



            //$DocAdresse = getTarif($enti[Tarif], TarifInfoDoc);
            $DocAdresse = "keine";

            //*********************************************************************************************************************
            //*********************************************************************************************************************
            //*********************************************************************************************************************

            $pdf= new Pdf();
            $pdf->SetMargins(10,22);
            $pdf->AddPage();


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Kopfzeile
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $textAufagskopf = "The year 1866 was marked by a
            bizarre development, an unexplained and downright inexplicable phenomenon that surely no one has forgotten. Without getting into those rumors that upset civilians in the seaports and deranged the public mind even far inland, it must be said
            that professional seamen were especially alarmed. Traders, shipowners, captains of vessels, skippers, and master mariners from Europe and America, naval officers from every country, and at their heels the various national governments on these two
            continents, were all extremely disturbed by the business. In essence, over a period of time several ships had encountered \"an enormous thing\" at sea, a long spindle-shaped object, sometimes giving off a phosphorescent glow,
            infinitely bigger and faster than any whale.";
            $x=10;
            $y=22;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x+42,$y);
            $pdf->MultiCell(35,3.7,"[AuftragsTyp]"."\n"."[Vertragsbeginn]"."\n"."[Kundenkennwort]");

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',5);
            $pdf->SetXY(10,$y);
            $pdf->MultiCell(90,2.5, $textAufagskopf);

            $y=$pdf->GetY()+1;


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Privatkunde
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '."[Kundentyp]",1);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');
            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x+42,$y);
            $pdf->MultiCell(35,3.7,"[Anrede]" ."\n".''."\n"."[Name]"."\n"."[Vorname]"."\n".substr("[Geburtsdatum]",8,2).".".substr("[Geburtsdatum]",5,2).".".substr("[Geburtsdatum]",0,4)."\n"."[Ausweisnummer]"."\n\n"."[BankKartenKreditInstitut]"."\n\n"."[BankKartenNummer]"."\n"."[BankKarteGueltigM]"." / "."[BankKarteGueltigJ]");

            $y=$pdf->GetY()+1;
            $pdf->SetFont('Arial','',5);
            $pdf->SetXY(10,$y);
            $pdf->MultiCell(90,2.5, $textAufagskopf);

            $y=$pdf->GetY()+1;
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Anschrift
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Anschrift',1);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(35,3.7,'Stra�e:'."\n".'PLZ, Ort:'."\n".'Telefon:'."\n".'E-Mail:'."\n".'Ansprechpartner:');

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x+42,$y);
            $pdf->MultiCell(60,3.7,"[Strasse]"." "."[Hausnummer]"."\n"."PLZ]"." "."[Ort]"."\n"."0049"." / "."[Kontaktrufnummer]"."\n"."[Email]"."\n"."[Ansprechpartner]");
            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',5);
            $pdf->SetXY(10,$y);
            $pdf->MultiCell(90,2.5, $textAufagskopf.$textAufagskopf.$textAufagskopf.$textAufagskopf.$textAufagskopf);


            $y=$pdf->GetY()+1;


        }
        $DocAdresse = "Formulare/Vertragliche_Datenschutzhinweise.pdf";
        $pagecount = $pdf->setSourceFile($DocAdresse);

        $pdf->Output('d');
        Storage::put('TokasPdf1.pdf', $pdf->Output('d'));


        //save file
        //Storage::put('TokasPdf2.pdf', $pdf->Output('S'));


    }

    public function printVodafone_v3_With_else_OK($contractID){
        // Die fpdf Daten werden inkludiert
        include (app_path() . 'public/libraries/pdfPrint/CreditRequestTexte.php');
        //include ('C:\xampp\htdocs\UserDefined\TokasDraft\public\libraries\pdfPrint\fpdf4credit.php');
        //include (app_path() . 'public/libraries/pdfPrint/fpdi.php');
        include ('C:\xampp\htdocs\UserDefined\TokasDraft\public\libraries\pdfPrint\CreditRequestTexte.php');


        // Fetch related data from the database...
        $contract = Contract
            ::where('id', $contractID)
            ->first();

        $tariff = Tariff::find($contract->tariff_id);

        $customer = Customer
            ::where('id', $contract->customer_id)
            ->first();

        $customerContact = CustomerContact
            ::where('customer_id', $customer->id)
            ->first();

        $customerInvoiceAddress = CustomerInvoiceAddress
            ::where('customer_id', $customer->id)
            ->first();

        $customerPaymentTool = CustomerPaymentTool
            ::where('customer_id', $customer->id)
            ->first();

        // there may be more than one gsm like additional gsm...
        $mainCardVfGsm = VfGSM
            ::where('contract_id', $contract->id)
            ->where('additional_tariff', 0) // 0 means the tariff is NOT additional, main.
            ->first();

        // Fetch the VF-GSM with the current contract ID from "VfGsm" table
        $allCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->orderBy('additional_tariff', 'DESC') // first instance will be main tariff
            ->get();

        $additionalCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->where('additional_tariff', 1) // 1 means the tariff is additional, main.
            ->get();

        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

        $eins = 1; //Setzen des Startpunktes f�r die Nummerierung der einzelnen Abs�tze
        $zwei = 1;

        //if($enti[Tarif] == "VFZH24FFN"){}

//*********************************************************************************************************************
//*********************************************************************************************************************
//*********************************************************************************************************************
        if($tariff->code != "VFZH24FFN"){

            //$DocAdresse = getTarif($enti[Tarif], TarifInfoDoc);
            $DocAdresse = "keine";

            if($DocAdresse != "keine"){

                $GLOBALS["festport"] = "ja";

                $pdf = new FPDI();
                $DocAdresse = "../../../" . getTarif($enti[Tarif], TarifInfoDoc);

                $pagecount = $pdf->setSourceFile($DocAdresse);
                $tplidx = $pdf->importPage(1);
                $pdf->addPage();
                $pdf->useTemplate($tplidx);

                $GLOBALS["festport"] = "nein";


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Kopfzeile
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->AddPage('P');
                $pdf->SetMargins(10,22);
                $y=22;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[AuftragsTyp]."\n".$enti[Vertragsbeginn]."\n".$enti[Kundenkennwort]);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetXY(10,$y);
                $pdf->MultiCell(90,2.5,$textAuftragskopf);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Privatkunde
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '.$enti[Kundentyp],1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[Anrede]."\n".''."\n".$enti[Name]."\n".$enti[Vorname]."\n".substr($enti[Geburtsdatum],8,2).".".substr($enti[Geburtsdatum],5,2).".".substr($enti[Geburtsdatum],0,4)."\n".$enti[Ausweisnummer]."\n\n".$enti[BankKartenKreditInstitut]."\n\n".$enti[BankKartenNummer]."\n".$enti[BankKarteGueltigM]." / ".$enti[BankKarteGueltigJ]);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anschrift
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Anschrift',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Stra�e:'."\n".'PLZ, Ort:'."\n".'Telefon:'."\n".'E-Mail:'."\n".'Ansprechpartner:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$enti[Strasse]." ".$enti[Hausnummer]."\n".$enti[PLZ]." ".$enti[Ort]."\n"."0049"." / ".$enti[Kontaktrufnummer]."\n".$enti[Email]."\n".$enti[Ansprechpartner]);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Rechnungsanschrift falls verf�gbar
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if ($enti[AbweichendeRechnungsanschrift]== "JA"){
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Rechnungsanschrift',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(35,3.5,'Name/Firma:'."\n".'Ansprechpartner:'."\n".'Telefon:'."\n".'Stra�e u. Postfach:'."\n".'PLZ, Ort:');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x+42,$y);
                    $pdf->MultiCell(35,3.5,$enti[RechnungVorname]." ".$enti[RechnungNachname]."\n".$enti[RechnungAnsprechpartner]."\n"."049 / / "."\n".$enti[RechnungStrasse].' '.$enti[RechnungHausnummer]."\n".$enti[RechnungPLZ].' '.$enti[RechnungOrt]);

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Papier Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Papier Rechnung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,$textPapierRechnung."\n\n");

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Online Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if($enti[RechnungsArt]==NurOnline){
                    $eins++;
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Online Rechnung',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,3.0,$textOnlineRechnung."\n\n");

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Bankverbindung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Bankverbindung/Auskunfts-/Einzugserm�chtigung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                if($enti[IBAN] == ""){
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'Konto Nr.:'."\n".'BLZ:'."\n".'Verwendungszweck:');
                }else{
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'IBAN:'."\n".'BIC:'."\n".'Verwendungszweck:');
                }

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                if($enti[IBAN] == ""){
                    $pdf->MultiCell(35,3.5,' '."\n".$enti[Kontonummer]."\n".$enti[Bankleitzahl]."\n".'Vodafone Rechnung');
                }else{
                    $pdf->MultiCell(50,3.5,' '."\n".$enti[IBAN]."\n".$enti[BIC]."\n".'Vodafone Rechnung');
                }

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textAbbuchungserlaubnis1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textBestaetigt);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,$textAbbuchungserlaubnis2);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,'Datum: '.$Date."\n".'Unterschrift des '."\n".'Kontoinhabers:       X___________________'."\n".'Name:                          '.$enti[Kontoinhaber]);
                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Auftrag f�r Vodafone Dienstleistungen
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //Evtl. Mehrkarten aus Datenbank lesen
                $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                $gesamtkarten = ($mehrkartenanzahl + 1);

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Auftrag f�r Vodafone-D2-Dienstleistungen',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,"Anzahl der Vodafone-Karten insgesamt: ".$gesamtkarten."\ndavon im Tarif \n");
                $y=$pdf->GetY()+1;


                //Erste Karte aus Hauptdatensatz nehmen
                $kartenart[0] = $enti;

                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);
                }


                //Schleife durchl�uft Hauptkarte + alle Mehrkarten
                for ($j=0;$j<$gesamtkarten;$j++){

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);

                    $rechtliches = explode (",", getTarif($kartenart[$j][Tarif], Rechtstexte));
                    $textanzahl = count ($rechtliches);

                    $bar = 2;
                    for ($foo=0;$foo<$textanzahl;$foo++){
                        if ($$rechtliches[$foo]){
                            $bar++;
                        }
                    }

                    for ($i=1; $i<$bar; $i++){
                        if ($i != $bar-1){
                            $exponenttext .= $i . ",";
                        }else{
                            $exponenttext .= $i;
                        }
                    }

                    if(($kartenart[$j][Tarif]=="FLATSFFOS")||($kartenart[$j][Tarif]=="FLATSFFMS")||($kartenart[$j][Tarif]=="DFLATSFFO")||($kartenart[$j][Tarif]=="DFLATSFFM"))$ZusatzBlattVFV="JA";

                    /*
                     ------------------------------------------------------------------
                     -DER HINZUGEF�GTE CODEABSCHNITT F�R TARIF RED S SPEZIAL (SIM ONLY)-
                     */
                    if ($kartenart[$j][Tarif]=="DPAASOS"){
                        if ($enti[VO]=="80855791"){

                        }elseif($enti[VO]=="80210035"){

                        }elseif($enti[VO]=="30855553"){

                        }elseif($enti[VO]=="80855786"){

                        }elseif($enti[VO]=="80855789"){

                        }else{
                            $enti[VO] = "80215378";
                        }
                    }
                    //------------------------------------------------------------------

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    $pdf->Write(3.5,$RichtigeTarifName." ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->subWrite(3.5, $exponenttext, '', 5, 4);
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Write(3.5,"\n");
                    $pdf->Write(3.5,"1 Karte, Serien-Nummer: ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->Write(3.5,$kartenart[$j][Sim]."\n");


                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $pdf->Cell(3,2.5,"1) ",0,L);
                    $pdf->MultiCell(90,2.5,$textTarifMindestlaufzeit);
                    $y=$pdf->GetY()+1;

                    /*
                     for ($rechtszaehler=0;$rechtszaehler<$textanzahl;$rechtszaehler++){

                        $y=$pdf->GetY()+1;

                        $pdf->SetFont('Arial','',7);
                        $pdf->SetY($y);

                        if ($$rechtliches[$rechtszaehler]){

                        $pdf->Cell(3,2.5,$rechtszaehler+2 .") ",0,L);
                        $pdf->MultiCell(90,2.5,$$rechtliches[$rechtszaehler],0,L);
                        $y=$pdf->GetY()+1;
                        }
                        }
                        */

                    $rechtReiheA = 2;
                    foreach ($rechtliches as $key => $value){
                        $RechtsText = getRecht($value);
                        if($RechtsText){
                            $pdf->Cell(3,2.5,"$rechtReiheA) ",0,L);
                            $pdf->MultiCell(90,2.5,$RechtsText,0,L);
                            $y=$pdf->GetY()+1;
                            $rechtReiheA++;
                        }
                    }

                    $y=$pdf->GetY()+1;
                }


                $pdf->SetFont('Arial','B',7.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,"Etwaige gebuchte Zusatzdienste/Tarifoptionen gem�� Anlage f�r Zusatzdienste\nSonstige Bemerkungen:");
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Verbindungs�bersicht / Nutzung von Daten
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Verbindungs�bersicht/Nutzung von Daten',1);
                $y=$pdf->GetY()+1;
                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,$textVerbindungs�bersicht,0,L);

                $y=$pdf->GetY()+1;

                if ($enti[Werbeverweigerung]!='JA'){
                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $y = $pdf->GetY();
                    if ($y>222)$pdf->ManualPageBreak();
                    $pdf->MultiCell(90,2.5,$textWerbebereitschaft,1,L);

                    $y=$pdf->GetY();
                }

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $y = $pdf->GetY();
                if ($y>222)$pdf->ManualPageBreak();
                $pdf->MultiCell(90,2.5,$textBeauftragung,1,L);
                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vertriebsorganisation
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Vertriebsorganisation',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->Write(3.0,"VO-Nummer: ");
                $pdf->SetFont('Arial','',8);
                $pdf->Write(3.0,$enti[VO]."\nWir best�tigen hiermit die Richtigkeit der Kundenangaben\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->Write(3.0,"Datum: ");
                $pdf->SetFont('Arial','',8);
                $pdf->Write(3.0,$Date."\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->MultiCell(90,3.0,"Unterschrift der \nVertriebsorganisation:                 __________________________");

                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anlage f�r Zusatzdienste
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $normal="JA";
                $pdf->AddPage('P');
                $x=10;
                $y=22;

                $pdf->SetFont('Arial','B',9);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.0,"Anlage f�r Zusatzdienste und \nzum Eintrag in Telefon-/Telefaxverzeichnisse und zur Auskunftserteilung",1, 'C');


                $y=$pdf->GetY()+5;
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Kunden-Name: ".$enti[Vorname]." ".$enti[Name]."                                                   Kundenauftrag vom: ".substr($enti[Erfassungsdatum],8,2).".".substr($enti[Erfassungsdatum],5,2).".".substr($enti[Erfassungsdatum],0,4)."\nKunden-Nr.:",0,L);


                $y=$pdf->GetY()+5;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $y=$pdf->GetY()+10;

                //Tabellenkopf schreiben
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(50,4.5,'Seriennummer',1);
                $pdf->SetXY($x+50,$y);
                $LineBegin=$pdf->GetY();
                $pdf->MultiCell(130,4.5,"Zus�tzliche Informationen zu den Karten\n",1);
                $aufzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen
                $hochzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen

/**
                //Evtl. Mehrkarten aus Datenbank lesen
                $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                $gesamtkarten = ($mehrkartenanzahl + 1);

                $kartenart[0] = $enti; //Erste Karte aus Hauptdatensatz nehmen


                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);

                }

                for ($j=0;$j<$gesamtkarten;$j++){ //Schleife durchl�uft Hauptkarte + alle Mehrkarten

                    **$pdf->SetFont('Arial','',8.5);
                    **$y=$pdf->GetY();
                    **$pdf->SetXY($x,$y);

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    **$pdf->MultiCell(50,4.5,$kartenart[$j][Sim]."\n".$RichtigeTarifName."\n\n\n\n\n\n\n",L,L);

                    //Dienste in Rohfassung aus der Datenbank lesen und in Array schreiben
                    $Datendienste = explode (",", $kartenart[$j][Datendienste]);
                    $DaNum = count($Datendienste);
                    $WeitereDienste = explode (",", $kartenart[$j][WeitereDienste]);
                    $WeNum = count($WeitereDienste);
                    $DienstNamen = "";

                    //Konstrukt um die Mailbox als Dienst anzuzeigen
                    if ($kartenart[$j][Mailbox]!='KEINE'){
                        $DienstNamen = getSonderdienst($kartenart[$j][Mailbox], DienstName);

                    }
                    $RechteArray = array();

                    //Dienstnamen aufl�sen und in Variable schreiben
                    for ($i=1;$i<$DaNum;$i++){
                        $DienstNamen = $DienstNamen . ", ". getSonderdienst($Datendienste[$i], DienstName);
                        $RTA= count(explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }
                    for ($i=1;$i<$WeNum;$i++){
                        if($WeitereDienste[$i] == "NOACTFEE" || $WeitereDienste[$i] == "MRKBEGSAP" || $WeitereDienste[$i] == "NOACFEDAT"){
                            $DienstNamen = $DienstNamen . ", Anschlusspreisbefreiung";
                        }else if($WeitereDienste[$i] == "YOUAGEVAL"){
                            $DienstNamen = $DienstNamen . ", VF Young check on age";
                        }else if($WeitereDienste[$i] == "YOUABIAGE"){
                            $DienstNamen = $DienstNamen . ", VF Young f�r Minderj�hrige";
                        }else if($WeitereDienste[$i]=="PYPCHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPSOCIAL"){ $DienstNamen = $DienstNamen . "Social Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PACHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PASOCIAL"){ 	$DienstNamen = $DienstNamen . "Social Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 10 Euro/Mon., ";
                        }else{
                            $DienstNamen = $DienstNamen . ", ". getSonderdienst($WeitereDienste[$i], DienstName);
                        }
                        $RTA= count(explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));

                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }


                    $RechtsTextAnzahl = count($RechteArray);
                    for ($i=0;$i<=$RechtsTextAnzahl;$i++){
                        if (strlen($$RechteArray[$i])>1){
                            $RechteBlaBla = $RechteBlaBla . "\n\n".$aufzaehler++ .") ". $$RechteArray[$i];
                        }
                    }

                    //Pflichtdienste aufschlüsseln und in Array schreiben
                    $Tarifpflichten=explode(",", getTarif($kartenart[$j][Tarif], Pflichten));
                    $vertragsbedingungen = "";
                    $zaehler = 1;

                    //Zuhause Adresse in Variable schreiben wenn Dienst aktiviert ist
                    if (in_array("HAPPYZH_1", $WeitereDienste)){
                        $ZuhauseAdresse = "Zuhause-Adresse: Der ZuhauseBereich soll für Ihre im folgenden aufgef�hrte Adresse eingerichtet werden.\nStrasse                 ".
                           $kartenart[$j][ZuhauseStrasse]." ".$kartenart[$j][ZuhauseHausnummer]."\nPLZ, Ort               ".$kartenart[$j][ZuhausePLZ]." ".$kartenart[$j][ZuhauseOrt];

                        if (in_array("HAPPYZH_1", $Tarifpflichten)){
                            $vertragsbedingungen = "";
                        }
                        else{
                            $vertragsbedingungen = $zaehler++.")".$textDienstZuhauseOption1."\n\n".$zaehler++.")".$textDienstZuhauseOption2."\n\n";
                        }
                    }

                    else {
                        $ZuhauseAdresse = "";
                    }


                    $pdf->SetXY($x+50,$y);
                    $pdf->MultiCell(130,4.5,"Grundgebühr: ".$kartenart[$j][GG]." Euro \nZusatzdienste / Tarifoptionen: ".$DienstNamen."\nAnrufsperren: ".getSonderdienst($kartenart[$j][Anrufsperre], DienstName)."\nVertragsbeginn: ".DateChanger($kartenart[$j][Vertragsbeginn])."\nZus�tzliche Vertragsbedingungen:\n".$vertragsbedingungen.$RechteBlaBla."\n\nVerbindungs�bersich: ".$kartenart[$j][Verbindungsuebersicht]."\nMobilfunknummernanzeige: ".getSonderdienst($kartenart[$j][RufNummerUebermittlung], DienstName)."\nTeilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".$ZuhauseAdresse,1,L);


                    //Linienkonstrukt, da die L�nge der 2. Spalte variiert
                    $y=$pdf->GetY();
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,60,$y);
                    $pdf->Line(10,$LineBegin,10,$y);
                }
 */



                foreach($allCardsVfGsmInTheContract as $cardVFGsmInTheContract){
                    $pdf->SetFont('Arial','',8.5);
                    $y=$pdf->GetY();
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(50,4.5,
                        $cardVFGsmInTheContract->SIM_serial_number."\n".
                        Tariff::find($cardVFGsmInTheContract->tariff_id)->name .
                        "\n\n\n\n\n\n\n",L,L
                    );
                    // establish a string containing the services' name ($DienstNamen)
                    $stringOfTheServices = "";
                    // for data services
                    foreach($cardVFGsmInTheContract->data_services as $dataServiceCode){// $cardVFGsmInTheContract->data_services contains the data services' code as an array.
                        $stringOfTheServices .= Service::where('code', $dataServiceCode)->first()->name . ", ";
                        // if the data service has "rechtext" it mast be shown in parantesis like (1) near the service name...
                    }

                    // for supplementary services
                    foreach($cardVFGsmInTheContract->supplementary_services as $supplementaryServiceCode){
                        if($supplementaryServiceCode == "NOACTFEE" || $supplementaryServiceCode == "MRKBEGSAP" || $supplementaryServiceCode == "NOACFEDAT"){
                            $DienstNamen = $DienstNamen . ", Anschlusspreisbefreiung";
                        }else if($supplementaryServiceCode == "YOUAGEVAL"){
                            $DienstNamen = $DienstNamen . ", VF Young check on age";
                        }else if($supplementaryServiceCode == "YOUABIAGE"){
                            $DienstNamen = $DienstNamen . ", VF Young f�r Minderj�hrige";
                        }else if($supplementaryServiceCode=="PYPCHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 0 Euro/Mon., ";
                        }else if($supplementaryServiceCode=="PYPSOCIAL"){ $DienstNamen = $DienstNamen . "Social Pass 0 Euro/Mon., ";
                        }else if($supplementaryServiceCode=="PYPMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 0 Euro/Mon., ";
                        }else if($supplementaryServiceCode=="PYPVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 0 Euro/Mon., ";
                        }else if($supplementaryServiceCode=="PACHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PASOCIAL"){ 	$DienstNamen = $DienstNamen . "Social Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 10 Euro/Mon., ";
                        }else{
                            $DienstNamen = $DienstNamen . ", ". getSonderdienst($WeitereDienste[$i], DienstName);
                        }

                        $stringOfTheServices .= Service::where('code', $supplementaryServiceCode)->first()->name . ", ";
                    }


                    $pdf->SetXY($x+50,$y);
                    $pdf->MultiCell(130,4.5,
                        "Grundgebühr: ".Tariff::find($cardVFGsmInTheContract->tariff_id)->base_price." Euro \n
                        Zusatzdienste / Tarifoptionen: ".$DienstNamen."\n
                        Anrufsperren: ".getSonderdienst($kartenart[$j][Anrufsperre], DienstName)."\n
                        Vertragsbeginn: ".DateChanger($kartenart[$j][Vertragsbeginn])."\n
                        Zus�tzliche Vertragsbedingungen:\n".$vertragsbedingungen.$RechteBlaBla."\n\n
                        Verbindungsübersich: ".$kartenart[$j][Verbindungsuebersicht]."\n
                        Mobilfunknummernanzeige: ".getSonderdienst($kartenart[$j][RufNummerUebermittlung], DienstName)."\n
                        Teilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".
                        $ZuhauseAdresse
                        ,1,L);


                    //Linienkonstrukt, da die'L'�nge der 2. Spalte variiert
                    $y=$pdf->GetY();
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,60,$y);
                    $pdf->Line(10,$LineBegin,10,$y);
                }


                $y=$pdf->GetY()+20;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Datum: ".$Date."                                                                            Datum:".$Date,0,L);

                $y=$pdf->GetY()+20;

                //Unterschrift von Allen
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Stempel/\nUnterschrift\ndes H�ndlers   ___________________________________\n                          Wir best�tigen hiermit die\n                          Richtigkeit der Kundenangaben",0,L);

                $pdf->SetXY($x+90,$y);
                $pdf->MultiCell(180,4.5,"\nUnterschrift\ndes Kunden   ___________________________________",0,L);


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone Stars
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if ($enti[Stars]=='JA'){

                    if (($enti[StarsWerbungSMS]=='perSMS')||($enti[StarsWerbungEmail]=='perEmail'))$Werbung="X";ELSE $Werbung=" ";
                    if ($enti[StarsWerbungSMS]=='perSMS')$perSMS="X";ELSE $perSMS=" ";
                    if ($enti[StarsWerbungEmail]=='perEmail')$perEmail="X";ELSE $perEmail=" ";

                    $pdf->AddPage('P');

                    $pdf->SetFont('Arial','',10);
                    $pdf->SetXY(10,10);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars');

                    $x=10;
                    $y=25;

                    $pdf->SetFont('Arial','B',14);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars - Gleich mitmachen und anmelden!');

                    $y=$pdf->GetY()+4;

                    $pdf->SetFont('Arial','',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Steigen Sie ein bei Vodafone-Stars, sammeln sie Punkte und tauschen Sie diese gegen Top-Pr�mien ein!');

                    $y=$pdf->GetY()+4;


                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone-Handy-Nummer:                                                                    [] CallYa        [X] Laufzeitvertrag');

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Ich nutze das Handy �berwiegend');

                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'(Angabe freiwillig)');

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"[X]\n\n\n[".$Werbung."]\n\n\n\n[X]");

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,"Ja, ich will mit der oben genannten Rufnummer bei Vodafone-Stars mitmachen, Punkte sammeln und gegen attraktive Pr�mien einl�sen.\n\nJa, ich will regelm��ig �ber Neuigkeiten bei Vodafone-Stars informiert werden.\n[".$perEmail."]  per Email\n[".$perSMS."]  per SMS\n\nJa, ich akzeptiere die Teilnahmebedingungen von Vodafone Stars.");
                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,'(Diese k�nnen in den Verkaufsr�umen eingesehen werden, im Internet unter www.vodafone.de/vodafonestars und �ber Vodafone-InfoFax Nr. 365 abgerufen sowie unter der Service Nr. 22 44 99 kostenlos aus dem VF D2-Netz abgeh�rt werden)');

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Einwilligung zur Nutzung meiner Bestands- und Verbindungsdaten");

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Ich willige - jetzt widerruflich - darin ein, dass Vodafone D2\n- meine Verkehrsdaten (Daten, die bei der Bereitstellung und Erbringung von Telekommunikationsdienstleistungen erhoben werden) zur Vermarktung und bedarfsgerechten Gestaltung von Vodafone-Telekommunikationsdienstleistungen oder zur Bereitstellung von Diensten mit Zusatznutzen f�r l�ngstens 6 Monate nach Rechnungsversand speichert, verarbeitet und nutzt;\n- mich zu Werbezwecken (auch automatisiert) anruft oder mir per Telefax oder in Form elektronischer nachrichten Werbung zusendet und\n- meine Bestandsdaten (Daten, die erhoben werden, um das Vertragsverh�ltnis einschlie�lich seiner inhaltlichen Ausgestaltung zu begr�nden oder zu �ndern) verarbeitet und nutzt, soweit dies zur Kundenberatung, Werbung und Marktforschung erforderlich ist.\n\nOhne Einwilligung bleiben etwaige gesetzliche Werbebeschr�nkungen bestehen.\n\nDatum:                                     ".$Date."\nUnterschrift des                        x\nAuftraggebers:                         __________________________________________\nName in Druckbuchstaben                    ",1);
                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Sofern unten ein abweichender Nutzer der Vodafone-Karte eingetragen ist, wird dieser anstatt des Vertragspartners der oben genannten Rufnummer als Teilnehmer von Vodafone-Stars registriert. Ich erteile hiermit meine Zustimmung, dass statt mir selbst der Nutzer Teilnehmer von Vodafone-Stars wird.");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Unterschrift des Vertragspartners,                              Datum\nder oben genannten Rufnummer\n\nVor-/Nachname\nin Druckbuchstaben");

                    $y=$pdf->GetY()+2;
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,205,$y);

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Adresse des Nutzers der Vodafone-Karte");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3,"Vor-/Nachname\nggf. Firma\n\nStra�e, Nr.\n\nPLZ, Ort\n\nE-Mail\n\nGeburtsdatum");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Mir ist bekannt, dass meine mit der Teilnahme verbundenen personenbezogenen Daten gem�� den geltenden Datenschutzbestimmungen verarbeitet und nur f�r Zwecke der Durchf�hrung des Programms Vodafone-Stars genutzt werden");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date."                              VO-ID: ".$enti[VO]);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Unterschrift des Nutzers,                                            Datum                                             (Eintrag erfolgt durch Vodafone-D2)\nfalls abweichend vom Vertragspartner");

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Mehr Infos zu Vodafone-Stars gibt's unter 22 44 88 oder im Internet unter www.vodafone.de/vodafonestars.\n................................................................................................................................................................................................................");

                    $y=$pdf->GetY();
                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Bitte vollst�ndig ausf�llen und unterschrieben zur�ckfaxen an:               [X]Teilnehmer wurde bereits �ber Vodafone-ePOS-Direct-Import Client angemeldet!\nVodafone D2 GmbH, Abteilung VCS, Fax: 0 21 02 / 98 65 75 ");

                }

            }
            else{

                //*********************************************************************************************************************
                //*********************************************************************************************************************
                //*********************************************************************************************************************

                $pdf = new FPDF();
                $pdf->SetMargins(10,22);
                $pdf->AddPage();


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Kopfzeile
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //$pdf->Image('Images/vf_logo.png', 145,5);

                $x=10;
                $y=22;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,$contract->contract_type."\n".$contract->contract_start."\n".$customer->password);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetXY(10,$y);
                $pdf->MultiCell(90,2.5,ContractTexts::$textA1);

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Privatkunde
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if($customer->customer_type == 1) $customerType = 'Privat';
                else if($customer->customer_type == 2) $customerType = 'SoHo';
                else if($customer->customer_type == 3) $customerType = 'Business';
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '.$customerType,1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');
                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(35,3.7,
                    $customer->salutation."\n".''."\n".
                    $customer->surname."\n".
                    $customer->name."\n".
                    $customer->birth_date."\n".
                    $customer->identity_type."\n\n".
                    $customerPaymentTool->card_credit_institution."\n\n".
                    $customerPaymentTool->card_number."\n".
                    $customerPaymentTool->valid_to_month." / ".
                    $customerPaymentTool->valid_to_year
                );

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anschrift
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Anschrift',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.7,'Strasse:'."\n".'PLZ, Ort:'."\n".'Telefon:'."\n".'E-Mail:'."\n".'Ansprechpartner:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                $pdf->MultiCell(60,3.7,
                    $customerContact->street." ".
                    $customerContact->house_number."\n".
                    $customerContact->postal_code." ".
                    $customerContact->city."\n"."0049"." / ".
                    $customerContact->phone_number."\n".
                    $customerContact->email."\n".
                    $customer->contact_person
                );


                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Zuhause Adresse falls verf�gbar
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /*Seit Version 3.2 nicht mehr verf�gbar
                $ZuhauseDienstCheck = explode (",", $enti[WeitereDienste]);
                if (($enti[ZuhauseAdresse] == 'OTHER') && (in_array("HAPPYZH_1", $ZuhauseDienstCheck))){
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Zuhause-Adresse',1);
                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(35,3.5,'Stra�e:'."\n".'PLZ, Ort:');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x+38,$y);
                    $pdf->MultiCell(35,3.5,$enti[ZuhauseStrasse]." ".$enti[ZuhauseHausnummer]."\n".$enti[ZuhausePLZ]." ".$enti[ZuhauseOrt]);
                    $y=$pdf->GetY()+1;
                    }
                if (umbruch($x, $y)=='spalte'){
                    $x=115;
                    $y=22;
                    }
                if (umbruch($x, $y)=='seite'){
                    $x=10;
                    $y=22;
                    $pdf->AddPage('P');
                $pdf->CreditHead();
                    }
                */


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Rechnungsanschrift falls verf�gbar
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if ($mainCardVfGsm->different_invoice_address == "JA"){
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Rechnungsanschrift',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(35,3.5,'Name/Firma:'."\n".'Ansprechpartner:'."\n".'Telefon:'."\n".'Stra�e u. Postfach:'."\n".'PLZ, Ort:');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x+42,$y);
                    /*
                    $pdf->MultiCell(35,3.5,
                        $enti[RechnungVorname]." ".
                        $enti[RechnungNachname]."\n".
                        $enti[RechnungAnsprechpartner]."\n"."049 / / "."\n".
                        $enti[RechnungStrasse].' '.
                        $enti[RechnungHausnummer]."\n".
                        $enti[RechnungPLZ].' '.
                        $enti[RechnungOrt]
                    );
                    */

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Papier Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Papier Rechnung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,
                    ContractTexts::$textPapierRechnung."\n\n"
                );

                $y=$pdf->GetY()+1;


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone-Online Rechnung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if($customerInvoiceAddress->medium_type == 2){ // 2 means 'online'
                    $eins++;
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Online Rechnung',1);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetY($y);
                    $pdf->MultiCell(90,3.0,ContractTexts::$textOnlineRechnung."\n\n");

                    $y=$pdf->GetY()+1;
                }


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Bankverbindung
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Bankverbindung/Auskunfts-/Einzugserm�chtigung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                if($customerPaymentTool->IBAN == ""){
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'Konto Nr.:'."\n".'BLZ:'."\n".'Verwendungszweck:');
                }
                else{
                    $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'IBAN:'."\n".'BIC:'."\n".'Verwendungszweck:');
                }

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                if($customerPaymentTool->IBAN == ""){
                    //$pdf->MultiCell(35,3.5,' '."\n".$enti[Kontonummer]."\n".$enti[Bankleitzahl]."\n".'Vodafone Rechnung');
                }
                else{
                    $pdf->MultiCell(50,3.5,' '."\n".
                        $customerPaymentTool->IBAN."\n".
                        $customerPaymentTool->BIC."\n".
                        'Vodafone Rechnung');
                }

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,ContractTexts::$textAbbuchungserlaubnis1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,ContractTexts::$textBestaetigt);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,ContractTexts::$textAbbuchungserlaubnis2);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,'Datum: '.$Date."\n".
                    'Unterschrift des '."\n".
                    'Kontoinhabers:       X___________________'."\n".'Name:                          '.$enti[Kontoinhaber]);
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Auftrag f�r Vodafone Dienstleistungen
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //Evtl. Mehrkarten aus Datenbank lesen
                //$mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                //$mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                //$gesamtkarten = ($mehrkartenanzahl + 1);

                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Auftrag f�r Vodafone-D2-Dienstleistungen',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,"Anzahl der Vodafone-Karten insgesamt: ".
                    $allCardsVfGsmInTheContract->count()."\n davon im Tarif \n");
                $y=$pdf->GetY()+1;


                //Erste Karte aus Hauptdatensatz nehmen
                $kartenart[0] = $enti;

                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);
                }

                //Schleife durchl�uft Hauptkarte + alle Mehrkarten
                for ($j=0;$j<$gesamtkarten;$j++){

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetY($y);

                    $rechtliches = explode (",", getTarif($kartenart[$j][Tarif], Rechtstexte));
                    $textanzahl = count ($rechtliches);

                    $bar = 2;
                    for ($foo=0;$foo<$textanzahl;$foo++){
                        if ($$rechtliches[$foo]){
                            $bar++;
                        }
                    }

                    for ($i=1; $i<$bar; $i++){
                        if ($i != $bar-1){
                            $exponenttext .= $i . ",";
                        }else{
                            $exponenttext .= $i;
                        }
                    }

                    if(($kartenart[$j][Tarif]=="FLATSFFOS")||($kartenart[$j][Tarif]=="FLATSFFMS")||($kartenart[$j][Tarif]=="DFLATSFFO")||($kartenart[$j][Tarif]=="DFLATSFFM"))
                        $ZusatzBlattVFV="JA";

                    /*
                    ------------------------------------------------------------------
                    -DER HINZUGEF�GTE CODEABSCHNITT F�R TARIF RED S SPEZIAL (SIM ONLY)-
                    */
                    if ($kartenart[$j][Tarif]=="DPAASOS"){
                        if ($enti[VO]=="80855791"){

                        }elseif($enti[VO]=="80210035"){

                        }elseif($enti[VO]=="30855553"){

                        }elseif($enti[VO]=="80855786"){

                        }elseif($enti[VO]=="80855789"){

                        }else{
                            $enti[VO] = "80215378";
                        }
                    }
                    //------------------------------------------------------------------

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    $pdf->Write(3.5,$RichtigeTarifName." ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->subWrite(3.5, $exponenttext, '', 5, 4);
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Write(3.5,"\n");
                    $pdf->Write(3.5,"1 Karte, Serien-Nummer: ");
                    $pdf->SetFont('Arial','',8);
                    $pdf->Write(3.5,$kartenart[$j][Sim]."\n");


                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $pdf->Cell(3,2.5,"1) ",0,L);
                    $pdf->MultiCell(90,2.5,ContractTexts::$textTarifMindestlaufzeit);
                    $y=$pdf->GetY()+1;

                    /*
                    for ($rechtszaehler=0;$rechtszaehler<$textanzahl;$rechtszaehler++){

                        //$y=$pdf->GetY()+1;

                        $pdf->SetFont('Arial','',7);
                        $pdf->SetY($y);

                        if ($$rechtliches[$rechtszaehler]){
                            $pdf->Cell(3,2.5,$rechtszaehler+2 .") ",0,L);
                            $pdf->MultiCell(90,2.5,$$rechtliches[$rechtszaehler],0,L);
                            $y=$pdf->GetY()+1;
                        }

                    }
                    */

                    $rechtReihe = 2;
                    foreach ($rechtliches as $key => $value){
                        $RechtsText = getRecht($value);
                        if($RechtsText){
                            $pdf->Cell(3,2.5,"$rechtReihe) ",0,L);
                            $pdf->MultiCell(90,2.5,$RechtsText,0,L);
                            $y=$pdf->GetY()+1;
                            $rechtReihe++;
                        }
                    }

                    $y=$pdf->GetY()+1;
                }


                $pdf->SetFont('Arial','B',7.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,2.5,"Etwaige gebuchte Zusatzdienste/Tarifoptionen gem�� Anlage f�r Zusatzdienste\nSonstige Bemerkungen:");
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Verbindungs�bersicht / Nutzung von Daten
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Verbindungs�bersicht/Nutzung von Daten',1);
                $y=$pdf->GetY()+1;
                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,ContractTexts::$textVerbindungsUbersicht,0,L);

                $y=$pdf->GetY()+1;

                if ($mainCardVfGsm->objection != 1){
                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y);
                    $y = $pdf->GetY();
                    if ($y>222)$pdf->ManualPageBreak();
                    $pdf->MultiCell(90,2.5,ContractTexts::$textWerbebereitschaft,1,L);

                    $y=$pdf->GetY();
                }

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $y = $pdf->GetY();
                if ($y>222)$pdf->ManualPageBreak();
                $pdf->MultiCell(90,2.5,ContractTexts::$textBeauftragung,1,L);
                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Ihr Vodafone Kundennummern
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                /*
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Ihre Vodafone-Kunden-Nummern:',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,$textVodafoneNummer,0,L);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.5,"Kunden-Nummern: ".$enti[Kundennummer]."\nIch habe meine Vodafone-Karte(n) und die g�ltige(n) Preisliste(n) erhalten.\n\nDatum: ".$Date."\nUnterschrift:             X_______________________________");

                $y=$pdf->GetY()+1;
                */

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vertriebsorganisation
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins++.'. Vertriebsorganisation',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->Write(3.0,"VO-Nummer: ");
                $pdf->SetFont('Arial','',8);
                //$pdf->Write(3.0,$enti[VO]."\nWir bestätigen hiermit die Richtigkeit der Kundenangaben\n");
                $pdf->Write(3.0,auth()->user()->id."\nWir bestätigen hiermit die Richtigkeit der Kundenangaben\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->Write(3.0,"Datum: ");
                $pdf->SetFont('Arial','',8);
                $pdf->Write(3.0,$dateTime."\n");
                $pdf->SetFont('Arial','B',8);
                $pdf->MultiCell(90,3.0,"Unterschrift der \nVertriebsorganisation:                 __________________________");

                $y=$pdf->GetY()+1;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Anlage für Zusatzdienste
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $normal="JA";
                $pdf->AddPage('P');
                $x=10;
                $y=22;

                $pdf->SetFont('Arial','B',9);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.0,"Anlage für Zusatzdienste und \nzum Eintrag in Telefon-/Telefaxverzeichnisse und zur Auskunftserteilung",1, 'C');

                /*
                $y=$pdf->GetY()+5;
                $x=10;
                $pdf->SetX($x);
                $pdf->SetY($y);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Write(4.0,"Kunden-Name:");
                $x=$pdf->GetX()+20;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Write(4.0,$enti[Vorname]." ".$enti[Name]);

                $x=$pdf->GetX()+70;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Write(4.0,"Kundenauftrag vom:");
                $x=$pdf->GetX()+15;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Write(4.0,substr($enti[Erfassungsdatum],8,2).".".substr($enti[Erfassungsdatum],5,2).".".substr($enti[Erfassungsdatum],0,4));

                $x=10;
                $y=27;
                $pdf->SetXY($x,$y);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Write(4.0,"Kunden-Nr.:");
                $x=$pdf->GetX()+20;
                $pdf->SetX($x);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Write(4.0,$enti[Vorname]);

                $x=10;
                $y=27;
                $pdf->SetXY($x,$y);
                */


                $y=$pdf->GetY()+5;
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Kunden-Name: ".
                    $customer->surname." ".
                    $customer->name."                                                   Kundenauftrag vom: ".substr($enti[Erfassungsdatum],8,2).".".substr($enti[Erfassungsdatum],5,2).".".substr($enti[Erfassungsdatum],0,4)."\nKunden-Nr.:",0,L);


                $y=$pdf->GetY()+5;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $y=$pdf->GetY()+10;

                //Tabellenkopf schreiben
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(50,4.5,'Seriennummer',1);
                $pdf->SetXY($x+50,$y);
                $LineBegin=$pdf->GetY();
                $pdf->MultiCell(130,4.5,"Zus�tzliche Informationen zu den Karten\n",1);
                $aufzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen
                $hochzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen

                /*
                //Evtl. Mehrkarten aus Datenbank lesen
                $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
                $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
                $gesamtkarten = ($mehrkartenanzahl + 1);

                $kartenart[0] = $enti; //Erste Karte aus Hauptdatensatz nehmen


                for ($j=1;$j<=$gesamtkarten;$j++){
                    $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);
                }

                for ($j=0;$j<$gesamtkarten;$j++){ //Schleife durchl�uft Hauptkarte + alle Mehrkarten

                    $pdf->SetFont('Arial','',8.5);
                    $y=$pdf->GetY();
                    $pdf->SetXY($x,$y);

                    // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                    $aktuellTarif = $kartenart[$j][Tarif];
                    if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                        if(strpos($aktuellTarif, "_") !== false){
                            $reihe = strrpos($aktuellTarif, "_");
                            $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                            if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                                if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                    $reihe2 = strrpos($OriginalTarifCode, "_");
                                    $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                                }
                            }
                        }else{
                            $OriginalTarifCode = $aktuellTarif;
                        }
                    }else{
                        $OriginalTarifCode = $kartenart[$j][Tarif];
                    }

                    $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                    $pdf->MultiCell(50,4.5,$kartenart[$j][Sim]."\n".$RichtigeTarifName."\n\n\n\n\n\n\n",L,L);
                    //Dienste in Rohfassung aus der Datenbank lesen und in Array schreiben
                    $Datendienste = explode (",", $kartenart[$j][Datendienste]);
                    $DaNum = count($Datendienste);
                    $WeitereDienste = explode (",", $kartenart[$j][WeitereDienste]);
                    $WeNum = count($WeitereDienste);
                    $DienstNamen = "";


                    //Konstrukt um die Mailbox als Dienst anzuzeigen
                    if ($kartenart[$j][Mailbox]!='KEINE'){
                        $DienstNamen = getSonderdienst($kartenart[$j][Mailbox], DienstName);

                    }
                    $RechteArray = array();

                    //Dienstnamen aufl�sen und in Variable schreiben
                    for ($i=1;$i<$DaNum;$i++){
                        $DienstNamen = $DienstNamen . ", ". getSonderdienst($Datendienste[$i], DienstName);
                        $RTA= count(explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }

                    for ($i=1;$i<$WeNum;$i++){
                        if($WeitereDienste[$i] == "NOACTFEE" || $WeitereDienste[$i] == "MRKBEGSAP" || $WeitereDienste[$i] == "NOACFEDAT"){
                            $DienstNamen = $DienstNamen . ", Anschlusspreisbefreiung";
                        }else if($WeitereDienste[$i] == "YOUAGEVAL"){
                            $DienstNamen = $DienstNamen . ", VF Young check on age";
                        }else if($WeitereDienste[$i] == "YOUABIAGE"){
                            $DienstNamen = $DienstNamen . ", VF Young f�r Minderj�hrige";
                        }else if($WeitereDienste[$i]=="PYPCHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPSOCIAL"){ $DienstNamen = $DienstNamen . "Social Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PYPVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 0 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PACHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PASOCIAL"){ 	$DienstNamen = $DienstNamen . "Social Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 5 Euro/Mon., ";
                        }else if($WeitereDienste[$i]=="PAVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 10 Euro/Mon., ";
                        }else{
                            $DienstNamen = $DienstNamen . ", ". getSonderdienst($WeitereDienste[$i], DienstName);
                        }
                        $RTA= count(explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));

                        $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));
                        if (strlen($$RechteArray[$i])>1){
                            for ($k=0;$k<$RTA;$k++){
                                $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                            }
                        }
                    }





                    $RechtsTextAnzahl = count($RechteArray);
                    for ($i=0;$i<=$RechtsTextAnzahl;$i++){
                        if (strlen($$RechteArray[$i])>1){
                            $RechteBlaBla = $RechteBlaBla . "\n\n".$aufzaehler++ .") ". $$RechteArray[$i];
                        }
                    }



                    //Pflichtdienste aufschl�sseln und in Array schreiben
                    $Tarifpflichten=explode(",", getTarif($kartenart[$j][Tarif], Pflichten));
                    $vertragsbedingungen = "";
                    $zaehler = 1;

                    //Zuhause Adresse in Variable schreiben wenn Dienst aktiviert ist
                    if (in_array("HAPPYZH_1", $WeitereDienste)){
                        $ZuhauseAdresse = "Zuhause-Adresse: Der ZuhauseBereich soll f�r Ihre im folgenden aufgef�hrte Adresse eingerichtet werden.\nStrasse                 ".$kartenart[$j][ZuhauseStrasse]." ".$kartenart[$j][ZuhauseHausnummer]."\nPLZ, Ort               ".$kartenart[$j][ZuhausePLZ]." ".$kartenart[$j][ZuhauseOrt];

                        if (in_array("HAPPYZH_1", $Tarifpflichten)){
                            $vertragsbedingungen = "";
                        }
                        else{
                            $vertragsbedingungen = $zaehler++.")".$textDienstZuhauseOption1."\n\n".$zaehler++.")".$textDienstZuhauseOption2."\n\n";
                        }
                    }

                    else {
                        $ZuhauseAdresse = "";
                    }



                    /*

                    if (in_array("VFZHMFLAT", $WeitereDienste)){
                        $vertragsbedingungen = $vertragsbedingungen. $zaehler++.") ".$textDienstZuhauseFlatrate1."\n\n".$zaehler++.") ".$textDienstZuhauseFlatrate2."\n\n";
                            }

                    if (in_array("VFZHINTFL", $WeitereDienste)){
                        $vertragsbedingungen =$vertragsbedingungen. $zaehler++.")".$textDienstHappyInternational1."\n\n".$zaehler++.") ".$textDienstHappyInternational2."\n\n";
                        }

                    if (in_array("STUDRAB", $WeitereDienste)){
                        $vertragsbedingungen =$vertragsbedingungen. $zaehler++.")".$textDienstStudentenrabatt."\n\n";
                        }


                    $pdf->SetXY($x+50,$y);
                    $pdf->MultiCell(130,4.5,"Grundgeb�hr: ".$kartenart[$j][GG]." Euro \nZusatzdienste / Tarifoptionen: ".$DienstNamen."\nAnrufsperren: ".getSonderdienst($kartenart[$j][Anrufsperre], DienstName)."\nVertragsbeginn: ".DateChanger($kartenart[$j][Vertragsbeginn])."\nZus�tzliche Vertragsbedingungen:\n".$vertragsbedingungen.$RechteBlaBla."\n\nVerbindungs�bersich: ".$kartenart[$j][Verbindungsuebersicht]."\nMobilfunknummernanzeige: ".getSonderdienst($kartenart[$j][RufNummerUebermittlung], DienstName)."\nTeilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".$ZuhauseAdresse,1,L);

                    //Linienkonstrukt, da die L�nge der 2. Spalte variiert
                    $y=$pdf->GetY();
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,60,$y);
                    $pdf->Line(10,$LineBegin,10,$y);
                }
                */

                foreach($allCardsVfGsmInTheContract as $cardVFGsmInTheContract){
                    $pdf->SetFont('Arial','',8.5);
                    $y=$pdf->GetY();
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(50,4.5,
                        $cardVFGsmInTheContract->SIM_serial_number."\n".
                        Tariff::find($cardVFGsmInTheContract->tariff_id)->name .
                        "\n\n\n\n\n\n\n",L,L
                    );
                    // establish a string containing the services' name ($DienstNamen)
                    $stringOfTheServices = "";
                    // for data services
                    if($cardVFGsmInTheContract->data_services)
                    foreach($cardVFGsmInTheContract->data_services as $dataServiceCode){// $cardVFGsmInTheContract->data_services contains the data services' code as an array.
                        $stringOfTheServices .= Service::where('code', $dataServiceCode)->first()->name . ", ";
                        // if the data service has "rechtext" it mast be shown in parantesis like (1) near the service name...
                    }

                    // for supplementary services
                    if($cardVFGsmInTheContract->supplementary_services)
                    foreach($cardVFGsmInTheContract->supplementary_services as $supplementaryServiceCode){
                        if($supplementaryServiceCode == "NOACTFEE" || $supplementaryServiceCode == "MRKBEGSAP" || $supplementaryServiceCode == "NOACFEDAT")
                            $stringOfTheServices .= ", Anschlusspreisbefreiung";
                        else if($supplementaryServiceCode == "YOUAGEVAL") $stringOfTheServices .= ", VF Young check on age";
                        else if($supplementaryServiceCode == "YOUABIAGE") $stringOfTheServices .= ", VF Young für Minderj�hrige";
                        else if($supplementaryServiceCode =="PYPCHAT") $stringOfTheServices .= "Chat Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PYPSOCIAL") $stringOfTheServices .= "Social Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PYPMUSIC") $stringOfTheServices .= "Music Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PYPVIDEO")	$stringOfTheServices .= "Video Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PACHAT") $stringOfTheServices .= "Chat Pass 5 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PASOCIAL") $stringOfTheServices .= "Social Pass 5 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PAMUSIC") $stringOfTheServices .= "Music Pass 5 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PAVIDEO") $stringOfTheServices .= "Video Pass 10 Euro/Mon., ";
                        else
                            $stringOfTheServices .= Service::where('code', $supplementaryServiceCode)->first()->name . ", ";
                    }

                    if($cardVFGsmInTheContract->call_barring == "SO_SO") $textForAnrufsperre = "Anrufe zum Service 190";
                    else $textForAnrufsperre = "Keine";

                    if($cardVFGsmInTheContract->show_phone_numbers == "NRDEFJA") $textForShowPhoneNumber = "ein, fallweise aus";
                    else if($cardVFGsmInTheContract->show_phone_numbers == "NRDEFNEIN") $textForShowPhoneNumber = "aus, fallweise ein";
                    $pdf->SetXY($x+50,$y);
                    $pdf->MultiCell(130,4.5,
                        "Grundgebühr: " . Tariff::find($cardVFGsmInTheContract->tariff_id)->base_price . " Euro \n
                        Vertragsbeginn: " . $cardVFGsmInTheContract->contract_start . "\n\n
                        
                        Zusatzdienste / Tarifoptionen: ".$stringOfTheServices."\n\n
                        Verbindungsübersich: " . $cardVFGsmInTheContract->connection_overview . "\n
                        Zielrufnummerdarstellung: " . $cardVFGsmInTheContract->represent_destination_number . "\n
                        Anrufsperre: " . $textForAnrufsperre . "\n
                        Mailbox: " . $cardVFGsmInTheContract->mailbox . "\n
                        Mobilfunknummernanzeige - Rufnummer Übertragung:" . $textForShowPhoneNumber . "\n


                        Zusatzdienste / Tarifoptionen: ".$stringOfTheServices."\n
                       
                        Zus�tzliche Vertragsbedingungen:\n"."vertragsbedingungen.RechteBlaBla"."\n\n
                       
                        Teilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".
                        "ZuhauseAdresse"
                        ,1,L);


                    //Linienkonstrukt, da die L�nge der 2. Spalte variiert
                    $y=$pdf->GetY();
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,60,$y);
                    $pdf->Line(10,$LineBegin,10,$y);
                }


                $y=$pdf->GetY()+20;

                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,190,$y);

                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Datum: ".$dateTimeString."                                                                            Datum:".$dateTimeString,0, 'L');


                $y=$pdf->GetY()+20;



                //Unterschrift von Allen
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(180,4.5,"Stempel/\nUnterschrift\ndes H�ndlers   ___________________________________\n                          Wir best�tigen hiermit die\n                          Richtigkeit der Kundenangaben",0, 'L');

                $pdf->SetXY($x+90,$y);
                $pdf->MultiCell(180,4.5,"\nUnterschrift\ndes Kunden   ___________________________________",0, 'L');


                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //Vodafone Stars
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /**
                if ($enti[Stars]=='JA'){

                    if (($enti[StarsWerbungSMS]=='perSMS')||($enti[StarsWerbungEmail]=='perEmail'))$Werbung="X";ELSE $Werbung=" ";
                    if ($enti[StarsWerbungSMS]=='perSMS')$perSMS="X";ELSE $perSMS=" ";
                    if ($enti[StarsWerbungEmail]=='perEmail')$perEmail="X";ELSE $perEmail=" ";






                    $pdf->AddPage('P');


                    $pdf->SetFont('Arial','',10);
                    $pdf->SetXY(10,10);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars');





                    $x=10;
                    $y=25;

                    $pdf->SetFont('Arial','B',14);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone Stars - Gleich mitmachen und anmelden!');

                    $y=$pdf->GetY()+4;

                    $pdf->SetFont('Arial','',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Steigen Sie ein bei Vodafone-Stars, sammeln sie Punkte und tauschen Sie diese gegen Top-Pr�mien ein!');

                    $y=$pdf->GetY()+4;


                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Vodafone-Handy-Nummer:                                                                    [] CallYa        [X] Laufzeitvertrag');

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'Ich nutze das Handy �berwiegend');

                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,'(Angabe freiwillig)');

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"[X]\n\n\n[".$Werbung."]\n\n\n\n[X]");

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,"Ja, ich will mit der oben genannten Rufnummer bei Vodafone-Stars mitmachen, Punkte sammeln und gegen attraktive Pr�mien einl�sen.\n\nJa, ich will regelm��ig �ber Neuigkeiten bei Vodafone-Stars informiert werden.\n[".$perEmail."]  per Email\n[".$perSMS."]  per SMS\n\nJa, ich akzeptiere die Teilnahmebedingungen von Vodafone Stars.");
                    $y=$pdf->GetY()+0;

                    $pdf->SetFont('Arial','',7);
                    $pdf->SetXY($x+5,$y);
                    $pdf->MultiCell(170,3.7,'(Diese k�nnen in den Verkaufsr�umen eingesehen werden, im Internet unter www.vodafone.de/vodafonestars und �ber Vodafone-InfoFax Nr. 365 abgerufen sowie unter der Service Nr. 22 44 99 kostenlos aus dem VF D2-Netz abgeh�rt werden)');

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Einwilligung zur Nutzung meiner Bestands- und Verbindungsdaten");

                    $y=$pdf->GetY()+2;
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Ich willige - jetzt widerruflich - darin ein, dass Vodafone D2\n- meine Verkehrsdaten (Daten, die bei der Bereitstellung und Erbringung von Telekommunikationsdienstleistungen erhoben werden) zur Vermarktung und bedarfsgerechten Gestaltung von Vodafone-Telekommunikationsdienstleistungen oder zur Bereitstellung von Diensten mit Zusatznutzen f�r l�ngstens 6 Monate nach Rechnungsversand speichert, verarbeitet und nutzt;\n- mich zu Werbezwecken (auch automatisiert) anruft oder mir per Telefax oder in Form elektronischer nachrichten Werbung zusendet und\n- meine Bestandsdaten (Daten, die erhoben werden, um das Vertragsverh�ltnis einschlie�lich seiner inhaltlichen Ausgestaltung zu begr�nden oder zu �ndern) verarbeitet und nutzt, soweit dies zur Kundenberatung, Werbung und Marktforschung erforderlich ist.\n\nOhne Einwilligung bleiben etwaige gesetzliche Werbebeschr�nkungen bestehen.\n\nDatum:                                     ".$Date."\nUnterschrift des                        x\nAuftraggebers:                         __________________________________________\nName in Druckbuchstaben                    ",1);
                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Sofern unten ein abweichender Nutzer der Vodafone-Karte eingetragen ist, wird dieser anstatt des Vertragspartners der oben genannten Rufnummer als Teilnehmer von Vodafone-Stars registriert. Ich erteile hiermit meine Zustimmung, dass statt mir selbst der Nutzer Teilnehmer von Vodafone-Stars wird.");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Unterschrift des Vertragspartners,                              Datum\nder oben genannten Rufnummer\n\nVor-/Nachname\nin Druckbuchstaben");

                    $y=$pdf->GetY()+2;
                    $pdf->SetLineWidth(0.3);
                    $pdf->Line(10,$y,205,$y);

                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Adresse des Nutzers der Vodafone-Karte");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3,"Vor-/Nachname\nggf. Firma\n\nStra�e, Nr.\n\nPLZ, Ort\n\nE-Mail\n\nGeburtsdatum");
                    $y=$pdf->GetY()+2;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"Mir ist bekannt, dass meine mit der Teilnahme verbundenen personenbezogenen Daten gem�� den geltenden Datenschutzbestimmungen verarbeitet und nur f�r Zwecke der Durchf�hrung des Programms Vodafone-Stars genutzt werden");

                    $y=$pdf->GetY()+3;

                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(170,3.7,"________________________________          ".$Date."                              VO-ID: ".$enti[VO]);

                    $y=$pdf->GetY()+1;

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Unterschrift des Nutzers,                                            Datum                                             (Eintrag erfolgt durch Vodafone-D2)\nfalls abweichend vom Vertragspartner");


                    $y=$pdf->GetY()+1;


                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Mehr Infos zu Vodafone-Stars gibt's unter 22 44 88 oder im Internet unter www.vodafone.de/vodafonestars.\n................................................................................................................................................................................................................");

                    $y=$pdf->GetY();
                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetXY($x,$y);
                    $pdf->MultiCell(190,3.7,"Bitte vollst�ndig ausf�llen und unterschrieben zur�ckfaxen an:               [X]Teilnehmer wurde bereits �ber Vodafone-ePOS-Direct-Import Client angemeldet!\nVodafone D2 GmbH, Abteilung VCS, Fax: 0 21 02 / 98 65 75 ");

                }

                if(($enti[FNI]!=0) && ($Tarif[$Info]="VFZH24FFN")){

                    /* if($enti[FNI]!=0)

                    $pdf->setSourceFile('portierungsformular.pdf');
                    $tplidx = $pdf->importPage(1);//Seitenzahl
                    $pdf->addPage();
                    $pdf->useTemplate($tplidx, 0, 0, 210);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY(45,36.5);
                    $pdf->MultiCell(40,30,$enti[Name]);
                    $pdf->SetXY(45,43.5);
                    $pdf->MultiCell(40,30,$enti[Vorname]);
                    $pdf->SetXY(45,50);
                    $pdf->MultiCell(40,30,$enti[Strasse]." ".$enti[Hausnummer]);
                    $pdf->SetXY(45,57.5);
                    $pdf->MultiCell(140,30,$enti[PLZ]."                                                       ".$enti[Ort]);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetXY(77,189);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetXY(174,197);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetXY(45,213);
                    $pdf->MultiCell(100,40,$enti[Vorname]." ".$enti[Name]);

                }


                if($ZusatzBlattVFV=="NEIN") { || if($getSonderdienst=="24MIN60")  {

                    /* Hier wird die Zusatzvereinbarung.pdf ab dem 03.10.2011 als Bild ausgegeben
                    $pdf->addPage();
                    $pdf->Image('zusatzvereinbarung.jpg', 0,0,210,297);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetXY(45,36.5);
                    $pdf->MultiCell(40,30,$enti[Name]);
                    $pdf->SetXY(45,43.5);
                    $pdf->MultiCell(40,30,$enti[Vorname]);
                    $pdf->SetXY(45,50);
                    $pdf->MultiCell(40,30,$enti[Strasse]." ".$enti[Hausnummer]);
                    $pdf->SetXY(45,57.5);
                    $pdf->MultiCell(140,30,$enti[PLZ]."                                                       ".$enti[Ort]);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetXY(77,189);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetXY(174,197);
                    $pdf->MultiCell(70,30,$Date);
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetXY(45,213);
                    $pdf->MultiCell(100,40,$enti[Vorname]." ".$enti[Name]);
                }
                */

            }

        }

        /**
        $DocAdresse = getTarif($enti[Tarif], TarifInfoDoc);

        // Am Ende vom Auftrag wird noch die pdf-Datei Vertragliche_Datenschutzhinweise hinzugef�gt
        if($DocAdresse != "keine"){
            $GLOBALS["datenschutz"] = "ja";

            $DocAdresse = "Formulare/Vertragliche_Datenschutzhinweise.pdf";
            $pagecount = $pdf->setSourceFile($DocAdresse);

            $tplidx = $pdf->importPage(1);
            $pdf->addPage();
            $pdf->useTemplate($tplidx);

            $tplidx = $pdf->importPage(2);
            $pdf->addPage();
            $pdf->useTemplate($tplidx);

            $tplidx = $pdf->importPage(3);
            $pdf->addPage();
            $pdf->useTemplate($tplidx);
        }


        $pdf->Output();
        */
        $pdf->Output('d');
        Storage::put('TokasPdf1.pdf', $pdf->Output('d'));

    }
    public function printVodafone_v4($contractID){
        // Die fpdf Daten werden inkludiert

        // Fetch related data from the database...
        $contract = Contract
            ::where('id', $contractID)
            ->first();

        $tariff = Tariff::find($contract->tariff_id);

        $customer = Customer
            ::where('id', $contract->customer_id)
            ->first();

        $customerContact = CustomerContact
            ::where('customer_id', $customer->id)
            ->first();

        $customerInvoiceAddress = CustomerInvoiceAddress
            ::where('customer_id', $customer->id)
            ->first();

        $customerPaymentTool = CustomerPaymentTool
            ::where('customer_id', $customer->id)
            ->first();

        // there may be more than one gsm like additional gsm...
        $mainCardVfGsm = VfGSM
            ::where('contract_id', $contract->id)
            ->where('additional_tariff', 0) // 0 means the tariff is NOT additional, main.
            ->first();

        // Fetch the VF-GSM with the current contract ID from "VfGsm" table
        $allCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->orderBy('additional_tariff', 'DESC') // first instance will be main tariff
            ->get();

        $additionalCardsVfGsmInTheContract = VfGsm
            ::where('contract_id', $contractID)
            ->where('additional_tariff', 1) // 1 means the tariff is additional, main.
            ->get();

        $dateTime = Carbon::now();
        $dateTimeString = $dateTime->year .'-'. $dateTime->month .'-'. $dateTime->day .'-'. $dateTime->hour .'-'. $dateTime->minute .'-'. $dateTime->second;

        $eins = 1; //Setzen des Startpunktes f�r die Nummerierung der einzelnen Abs�tze
        $zwei = 1;



            $pdf = new Pdf();
            $pdf->AddFont('Arial','','arial.php');
            $pdf->SetMargins(10,22);
            $pdf->AddPage();


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Kopfzeile
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //$pdf->Image('Images/vf_logo.png', 145,5);

            $x=10;
            $y=22;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(35,3.7,$eins++.' .Auftrag:'."\n".$eins++.'. Vertragsbeginn:'."\n".$eins++.'. Kundenkennwort:');

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x+42,$y);
            $pdf->MultiCell(35,3.7,$contract->contract_type."\n".$mainCardVfGsm->contract_start."\n".$customer->password);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',7);
            $pdf->SetXY(10,$y);
            $pdf->MultiCell(90,2.5,utf8_decode(ContractTexts::$textA1));

            $y=$pdf->GetY()+1;


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Privatkunde
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if($customer->customer_type == 1) $customerType = 'Privat';
            else if($customer->customer_type == 2) $customerType = 'SoHo';
            else if($customer->customer_type == 3) $customerType = 'Business';
            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' '.$customerType,1);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(35,3.7,'Anrede:'."\n".'Titel:'."\n".'Name:'."\n".'Vorname:'."\n".'Geburtsdatum:'."\n".'Personalausweis-Nr.:'."\n".'Bank-, EC- oder'."\n".'Maestrokarte:'."\n".'Bank-, EC- oder'."\n".'Maestrokarten-Nr.:'."\n".'G�ltig bis:');
            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x+42,$y);
            $pdf->MultiCell(35,3.7,
                $customer->salutation."\n".''."\n".
                utf8_decode($customer->surname)."\n".
                utf8_decode($customer->name)."\n".
                $customer->birth_date."\n".
                $customer->identity_type."\n\n".
                $customerPaymentTool->card_credit_institution."\n\n".
                $customerPaymentTool->card_number."\n".
                $customerPaymentTool->valid_to_month." / ".
                $customerPaymentTool->valid_to_year
            );

            $y=$pdf->GetY()+1;


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Anschrift
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Anschrift',1);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(35,3.7,'Strasse:'."\n".'PLZ, Ort:'."\n".'Telefon:'."\n".'E-Mail:'."\n".'Ansprechpartner:');

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x+42,$y);
            $pdf->MultiCell(60,3.7,
                $customerContact->street." ". $customerContact->house_number."\n".
                $customerContact->postal_code." ". $customerContact->city."\n"."0049"." / ".
                $customerContact->phone_number."\n".
                $customerContact->email."\n".
                $customer->contact_person
            );


            $y=$pdf->GetY()+1;


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Zuhause Adresse falls verf�gbar
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /*Seit Version 3.2 nicht mehr verf�gbar
            $ZuhauseDienstCheck = explode (",", $enti[WeitereDienste]);
            if (($enti[ZuhauseAdresse] == 'OTHER') && (in_array("HAPPYZH_1", $ZuhauseDienstCheck))){
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Zuhause-Adresse',1);
                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(35,3.5,'Stra�e:'."\n".'PLZ, Ort:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+38,$y);
                $pdf->MultiCell(35,3.5,$enti[ZuhauseStrasse]." ".$enti[ZuhauseHausnummer]."\n".$enti[ZuhausePLZ]." ".$enti[ZuhauseOrt]);
                $y=$pdf->GetY()+1;
                }
            if (umbruch($x, $y)=='spalte'){
                $x=115;
                $y=22;
                }
            if (umbruch($x, $y)=='seite'){
                $x=10;
                $y=22;
                $pdf->AddPage('P');
            $pdf->CreditHead();
                }
            */


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Rechnungsanschrift falls verf�gbar
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if(0){//if ($mainCardVfGsm->different_invoice_address == "JA"){
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'.'.$zwei++.' Rechnungsanschrift',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','B',8);
                $pdf->SetY($y);
                $pdf->MultiCell(35,3.5,'Name/Firma:'."\n".'Ansprechpartner:'."\n".'Telefon:'."\n".'Stra�e u. Postfach:'."\n".'PLZ, Ort:');

                $pdf->SetFont('Arial','',8);
                $pdf->SetXY($x+42,$y);
                /*
                $pdf->MultiCell(35,3.5,
                    $enti[RechnungVorname]." ".
                    $enti[RechnungNachname]."\n".
                    $enti[RechnungAnsprechpartner]."\n"."049 / / "."\n".
                    $enti[RechnungStrasse].' '.
                    $enti[RechnungHausnummer]."\n".
                    $enti[RechnungPLZ].' '.
                    $enti[RechnungOrt]
                );
                */

                $y=$pdf->GetY()+1;
            }


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Vodafone-Papier Rechnung
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $eins++;
            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Papier Rechnung',1);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',8);
            $pdf->SetY($y);
            $pdf->MultiCell(90,3.0,
                ContractTexts::$textPapierRechnung."\n\n"
            );

            $y=$pdf->GetY()+1;


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Vodafone-Online Rechnung
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if($customerInvoiceAddress->medium_type == 2){ // 2 means 'online'
                $eins++;
                $pdf->SetFont('Arial','B',8.5);
                $pdf->SetY($y);
                $pdf->MultiCell(90,4.5,$eins.'. Vodafone-Online Rechnung',1);

                $y=$pdf->GetY()+1;

                $pdf->SetFont('Arial','',8);
                $pdf->SetY($y);
                $pdf->MultiCell(90,3.0,ContractTexts::$textOnlineRechnung."\n\n");

                $y=$pdf->GetY()+1;
            }


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Bankverbindung
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $eins++;
            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins.'. Bankverbindung/Auskunfts-/Einzugserm�chtigung',1);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            if($customerPaymentTool->IBAN == ""){
                $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'Konto Nr.:'."\n".'BLZ:'."\n".'Verwendungszweck:');
            }
            else{
                $pdf->MultiCell(35,3.5,'Kreditinstitut:'."\n".'IBAN:'."\n".'BIC:'."\n".'Verwendungszweck:');
            }

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x+42,$y);
            if($customerPaymentTool->IBAN == ""){
                //$pdf->MultiCell(35,3.5,' '."\n".$enti[Kontonummer]."\n".$enti[Bankleitzahl]."\n".'Vodafone Rechnung');
            }
            else{
                $pdf->MultiCell(50,3.5,' '."\n".
                    $customerPaymentTool->IBAN."\n".
                    $customerPaymentTool->BIC."\n".
                    'Vodafone Rechnung');
            }

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',7);
            $pdf->SetY($y);
            $pdf->MultiCell(90,2.5,ContractTexts::$textAbbuchungserlaubnis1);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',8);
            $pdf->SetY($y);
            $pdf->MultiCell(90,2.5,ContractTexts::$textBestaetigt);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',7);
            $pdf->SetY($y);
            $pdf->MultiCell(90,2.5,ContractTexts::$textAbbuchungserlaubnis2);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(90,3.5,'Datum: '. $dateTimeString. "\n".
                'Unterschrift des '."\n".
                'Kontoinhabers:       X___________________'."\n".'Name:                          '. $customerPaymentTool->account_owner);
            $y=$pdf->GetY()+1;

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Auftrag f�r Vodafone Dienstleistungen
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //Evtl. Mehrkarten aus Datenbank lesen
            //$mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
            //$mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
            //$gesamtkarten = ($mehrkartenanzahl + 1);

            $eins++;
            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins++.'. Auftrag für Vodafone-D2-Dienstleistungen',1);
            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(90,3.5,"Anzahl der Vodafone-Karten insgesamt: ".
                $allCardsVfGsmInTheContract->count()."\n davon im Tarif \n");
            $y=$pdf->GetY()+1;


            //Erste Karte aus Hauptdatensatz nehmen
            /**DELETED*/

            //Schleife durchl�uft Hauptkarte + alle Mehrkarten
            /** DELETED for ($j=0;$j<$gesamtkarten;$j++) */


            $pdf->SetFont('Arial','B',7.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,2.5,"Etwaige gebuchte Zusatzdienste/Tarifoptionen gem�� Anlage f�r Zusatzdienste\nSonstige Bemerkungen:");
            $y=$pdf->GetY()+1;

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Verbindungs�bersicht / Nutzung von Daten
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins++.'. Verbindungsübersicht/Nutzung von Daten',1);
            $y=$pdf->GetY()+1;
            $pdf->SetFont('Arial','',7);
            $pdf->SetY($y);
            $pdf->MultiCell(90,3.0,ContractTexts::$textVerbindungsUbersicht.ContractTexts::$textVerbindungsUbersicht.ContractTexts::$textVerbindungsUbersicht,0,'L');

            $y=$pdf->GetY()+1;

            if ($mainCardVfGsm->objection != 1){
                $pdf->SetFont('Arial','',7);
                $pdf->SetY($y);
                $y = $pdf->GetY();
                //if ($y>222)$pdf->ManualPageBreak();
                //if ($y>222){$pdf->SetY(0); $pdf->AddPage();}
                $pdf->MultiCell(90,2.5,ContractTexts::getTextWerbebereitschaft($customer->id),1, 'L');

                $y=$pdf->GetY();
            }

            $pdf->SetFont('Arial','',7);
            $pdf->SetY($y);
            $y = $pdf->GetY();
            //if ($y>222)$pdf->ManualPageBreak();
            //if ($y>222){$pdf->SetY(0); $pdf->AddPage();}
            $pdf->MultiCell(90,2.5,ContractTexts::getTextBeauftragung($customer->id),1, 'L');
            $y=$pdf->GetY()+1;

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Ihr Vodafone Kundennummern
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            /*
            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins++.'. Ihre Vodafone-Kunden-Nummern:',1);
            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',7);
            $pdf->SetY($y);
            $pdf->MultiCell(90,3.5,$textVodafoneNummer,0, 'L');

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->MultiCell(90,3.5,"Kunden-Nummern: ".$enti[Kundennummer]."\nIch habe meine Vodafone-Karte(n) und die g�ltige(n) Preisliste(n) erhalten.\n\nDatum: ".$Date."\nUnterschrift:             X_______________________________");

            $y=$pdf->GetY()+1;
            */

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Vertriebsorganisation
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetY($y);
            $pdf->MultiCell(90,4.5,$eins++.'. Vertriebsorganisation',1);
            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($y);
            $pdf->Write(3.0,"VO-Nummer: ");
            $pdf->SetFont('Arial','',8);
            //$pdf->Write(3.0,$enti[VO]."\nWir bestätigen hiermit die Richtigkeit der Kundenangaben\n");
            $pdf->Write(3.0,auth()->user()->id."\nWir bestätigen hiermit die Richtigkeit der Kundenangaben\n");
            $pdf->SetFont('Arial','B',8);
            $pdf->Write(3.0,"Datum: ");
            $pdf->SetFont('Arial','',8);
            $pdf->Write(3.0,$dateTime."\n");
            $pdf->SetFont('Arial','B',8);
            $pdf->MultiCell(90,3.0,"Unterschrift der \nVertriebsorganisation:                 __________________________");

            $y=$pdf->GetY()+1;

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Anlage für Zusatzdienste
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $normal="JA";
            $pdf->AddPage('P');
            $x=10;
            $y=22;

            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(180,4.0,"Anlage für Zusatzdienste und \nzum Eintrag in Telefon-/Telefaxverzeichnisse und zur Auskunftserteilung",1, 'C');

            /*
            $y=$pdf->GetY()+5;
            $x=10;
            $pdf->SetX($x);
            $pdf->SetY($y);
            $pdf->SetFont('Arial','B',8.5);
            $pdf->Write(4.0,"Kunden-Name:");
            $x=$pdf->GetX()+20;
            $pdf->SetX($x);
            $pdf->SetFont('Arial','',8.5);
            $pdf->Write(4.0,$enti[Vorname]." ".$enti[Name]);

            $x=$pdf->GetX()+70;
            $pdf->SetX($x);
            $pdf->SetFont('Arial','B',8.5);
            $pdf->Write(4.0,"Kundenauftrag vom:");
            $x=$pdf->GetX()+15;
            $pdf->SetX($x);
            $pdf->SetFont('Arial','',8.5);
            $pdf->Write(4.0,substr($enti[Erfassungsdatum],8,2).".".substr($enti[Erfassungsdatum],5,2).".".substr($enti[Erfassungsdatum],0,4));

            $x=10;
            $y=27;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',8.5);
            $pdf->Write(4.0,"Kunden-Nr.:");
            $x=$pdf->GetX()+20;
            $pdf->SetX($x);
            $pdf->SetFont('Arial','',8.5);
            $pdf->Write(4.0,$enti[Vorname]);

            $x=10;
            $y=27;
            $pdf->SetXY($x,$y);
            */


            $y=$pdf->GetY()+5;
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(180,4.5,"Kunden-Name: ".
                $customer->surname." ".
                $customer->name."                                                   Kundenauftrag vom: ".$dateTimeString."\nKunden-Nr.:",0, 'L');


            $y=$pdf->GetY()+5;

            $pdf->SetLineWidth(0.3);
            $pdf->Line(10,$y,190,$y);

            $y=$pdf->GetY()+10;

            //Tabellenkopf schreiben
            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(50,4.5,'Seriennummer',1);
            $pdf->SetXY($x+50,$y);
            $LineBegin=$pdf->GetY();
            $pdf->MultiCell(130,4.5,"Zus�tzliche Informationen zu den Karten\n",1);
            $aufzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen
            $hochzaehler = 1;//Variable um die Rechtstexte der Zusatzdienste durchlaufend zu bekommen

            /*
            //Evtl. Mehrkarten aus Datenbank lesen
            $mehrkartenabfrage = mysql_query("SELECT * FROM VF_Mehrkarten WHERE Auftragsnummer  = $ID");
            $mehrkartenanzahl = mysql_num_rows($mehrkartenabfrage);
            $gesamtkarten = ($mehrkartenanzahl + 1);

            $kartenart[0] = $enti; //Erste Karte aus Hauptdatensatz nehmen


            for ($j=1;$j<=$gesamtkarten;$j++){
                $kartenart[$j] = mysql_fetch_assoc($mehrkartenabfrage);
            }

            for ($j=0;$j<$gesamtkarten;$j++){ //Schleife durchl�uft Hauptkarte + alle Mehrkarten

                $pdf->SetFont('Arial','',8.5);
                $y=$pdf->GetY();
                $pdf->SetXY($x,$y);

                // KONVERTIERUNG VON SPEZIAL TARIFCODE ZU SEINEM ORIGINAL TARIFCODE
                $aktuellTarif = $kartenart[$j][Tarif];
                if($aktuellTarif!="VFZH24FFN" && (getTarif($aktuellTarif, Gruppe)!="DataGo Tarife")){
                    if(strpos($aktuellTarif, "_") !== false){
                        $reihe = strrpos($aktuellTarif, "_");
                        $OriginalTarifCode = substr($aktuellTarif, 0, $reihe);
                        if(getTarif($OriginalTarifCode, Gruppe) == "Aktionstarife" || getTarif($OriginalTarifCode, Gruppe) == "Spezial Tarife" || getTarif($OriginalTarifCode, Gruppe) == "Bundle Tarife"){
                            if(substr($OriginalTarifCode, 0, 3) != "MBB"){
                                $reihe2 = strrpos($OriginalTarifCode, "_");
                                $OriginalTarifCode = substr($OriginalTarifCode, 0, $reihe2);
                            }
                        }
                    }else{
                        $OriginalTarifCode = $aktuellTarif;
                    }
                }else{
                    $OriginalTarifCode = $kartenart[$j][Tarif];
                }

                $RichtigeTarifName = getTarif($aktuellTarif, TarifName);

                $pdf->MultiCell(50,4.5,$kartenart[$j][Sim]."\n".$RichtigeTarifName."\n\n\n\n\n\n\n", 'L', 'L');
                //Dienste in Rohfassung aus der Datenbank lesen und in Array schreiben
                $Datendienste = explode (",", $kartenart[$j][Datendienste]);
                $DaNum = count($Datendienste);
                $WeitereDienste = explode (",", $kartenart[$j][WeitereDienste]);
                $WeNum = count($WeitereDienste);
                $DienstNamen = "";


                //Konstrukt um die Mailbox als Dienst anzuzeigen
                if ($kartenart[$j][Mailbox]!='KEINE'){
                    $DienstNamen = getSonderdienst($kartenart[$j][Mailbox], DienstName);

                }
                $RechteArray = array();

                //Dienstnamen aufl�sen und in Variable schreiben
                for ($i=1;$i<$DaNum;$i++){
                    $DienstNamen = $DienstNamen . ", ". getSonderdienst($Datendienste[$i], DienstName);
                    $RTA= count(explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                    $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($Datendienste[$i], Rechtstexte)));
                    if (strlen($$RechteArray[$i])>1){
                        for ($k=0;$k<$RTA;$k++){
                            $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                        }
                    }
                }

                for ($i=1;$i<$WeNum;$i++){
                    if($WeitereDienste[$i] == "NOACTFEE" || $WeitereDienste[$i] == "MRKBEGSAP" || $WeitereDienste[$i] == "NOACFEDAT"){
                        $DienstNamen = $DienstNamen . ", Anschlusspreisbefreiung";
                    }else if($WeitereDienste[$i] == "YOUAGEVAL"){
                        $DienstNamen = $DienstNamen . ", VF Young check on age";
                    }else if($WeitereDienste[$i] == "YOUABIAGE"){
                        $DienstNamen = $DienstNamen . ", VF Young f�r Minderj�hrige";
                    }else if($WeitereDienste[$i]=="PYPCHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 0 Euro/Mon., ";
                    }else if($WeitereDienste[$i]=="PYPSOCIAL"){ $DienstNamen = $DienstNamen . "Social Pass 0 Euro/Mon., ";
                    }else if($WeitereDienste[$i]=="PYPMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 0 Euro/Mon., ";
                    }else if($WeitereDienste[$i]=="PYPVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 0 Euro/Mon., ";
                    }else if($WeitereDienste[$i]=="PACHAT"){ 	$DienstNamen = $DienstNamen . "Chat Pass 5 Euro/Mon., ";
                    }else if($WeitereDienste[$i]=="PASOCIAL"){ 	$DienstNamen = $DienstNamen . "Social Pass 5 Euro/Mon., ";
                    }else if($WeitereDienste[$i]=="PAMUSIC"){ 	$DienstNamen = $DienstNamen . "Music Pass 5 Euro/Mon., ";
                    }else if($WeitereDienste[$i]=="PAVIDEO"){ 	$DienstNamen = $DienstNamen . "Video Pass 10 Euro/Mon., ";
                    }else{
                        $DienstNamen = $DienstNamen . ", ". getSonderdienst($WeitereDienste[$i], DienstName);
                    }
                    $RTA= count(explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));

                    $RechteArray = array_merge_recursive($RechteArray, explode(",",getSonderdienst($WeitereDienste[$i], Rechtstexte)));
                    if (strlen($$RechteArray[$i])>1){
                        for ($k=0;$k<$RTA;$k++){
                            $DienstNamen = $DienstNamen . " (".$hochzaehler++ .")";
                        }
                    }
                }





                $RechtsTextAnzahl = count($RechteArray);
                for ($i=0;$i<=$RechtsTextAnzahl;$i++){
                    if (strlen($$RechteArray[$i])>1){
                        $RechteBlaBla = $RechteBlaBla . "\n\n".$aufzaehler++ .") ". $$RechteArray[$i];
                    }
                }



                //Pflichtdienste aufschl�sseln und in Array schreiben
                $Tarifpflichten=explode(",", getTarif($kartenart[$j][Tarif], Pflichten));
                $vertragsbedingungen = "";
                $zaehler = 1;

                //Zuhause Adresse in Variable schreiben wenn Dienst aktiviert ist
                if (in_array("HAPPYZH_1", $WeitereDienste)){
                    $ZuhauseAdresse = "Zuhause-Adresse: Der ZuhauseBereich soll f�r Ihre im folgenden aufgef�hrte Adresse eingerichtet werden.\nStrasse                 ".$kartenart[$j][ZuhauseStrasse]." ".$kartenart[$j][ZuhauseHausnummer]."\nPLZ, Ort               ".$kartenart[$j][ZuhausePLZ]." ".$kartenart[$j][ZuhauseOrt];

                    if (in_array("HAPPYZH_1", $Tarifpflichten)){
                        $vertragsbedingungen = "";
                    }
                    else{
                        $vertragsbedingungen = $zaehler++.")".$textDienstZuhauseOption1."\n\n".$zaehler++.")".$textDienstZuhauseOption2."\n\n";
                    }
                }

                else {
                    $ZuhauseAdresse = "";
                }



                /*

                if (in_array("VFZHMFLAT", $WeitereDienste)){
                    $vertragsbedingungen = $vertragsbedingungen. $zaehler++.") ".$textDienstZuhauseFlatrate1."\n\n".$zaehler++.") ".$textDienstZuhauseFlatrate2."\n\n";
                        }

                if (in_array("VFZHINTFL", $WeitereDienste)){
                    $vertragsbedingungen =$vertragsbedingungen. $zaehler++.")".$textDienstHappyInternational1."\n\n".$zaehler++.") ".$textDienstHappyInternational2."\n\n";
                    }

                if (in_array("STUDRAB", $WeitereDienste)){
                    $vertragsbedingungen =$vertragsbedingungen. $zaehler++.")".$textDienstStudentenrabatt."\n\n";
                    }


                $pdf->SetXY($x+50,$y);
                $pdf->MultiCell(130,4.5,"Grundgeb�hr: ".$kartenart[$j][GG]." Euro \nZusatzdienste / Tarifoptionen: ".$DienstNamen."\nAnrufsperren: ".getSonderdienst($kartenart[$j][Anrufsperre], DienstName)."\nVertragsbeginn: ".DateChanger($kartenart[$j][Vertragsbeginn])."\nZus�tzliche Vertragsbedingungen:\n".$vertragsbedingungen.$RechteBlaBla."\n\nVerbindungs�bersich: ".$kartenart[$j][Verbindungsuebersicht]."\nMobilfunknummernanzeige: ".getSonderdienst($kartenart[$j][RufNummerUebermittlung], DienstName)."\nTeilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".$ZuhauseAdresse,1, 'L');

                //Linienkonstrukt, da die L�nge der 2. Spalte variiert
                $y=$pdf->GetY();
                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,60,$y);
                $pdf->Line(10,$LineBegin,10,$y);
            }
            */

            foreach($allCardsVfGsmInTheContract as $cardVFGsmInTheContract){
                $pdf->SetFont('Arial','',8.5);
                $y=$pdf->GetY();
                $pdf->SetXY($x,$y);
                $pdf->MultiCell(50,4.5,
                    $cardVFGsmInTheContract->SIM_serial_number."\n".
                    Tariff::find($cardVFGsmInTheContract->tariff_id)->name .
                    "\n\n\n\n\n\n\n", 'L' , 'L'
                );
                // establish a string containing the services' name ($DienstNamen)
                $stringOfTheServices = "";
                // for data services
                if($cardVFGsmInTheContract->data_services)
                    foreach($cardVFGsmInTheContract->data_services as $dataServiceCode){// $cardVFGsmInTheContract->data_services contains the data services' code as an array.
                        $stringOfTheServices .= Service::where('code', $dataServiceCode)->first()->name . ", ";
                        // if the data service has "rechtext" it mast be shown in parantesis like (1) near the service name...
                    }

                // for supplementary services
                if($cardVFGsmInTheContract->supplementary_services)
                    foreach($cardVFGsmInTheContract->supplementary_services as $supplementaryServiceCode){
                        if($supplementaryServiceCode == "NOACTFEE" || $supplementaryServiceCode == "MRKBEGSAP" || $supplementaryServiceCode == "NOACFEDAT")
                            $stringOfTheServices .= ", Anschlusspreisbefreiung";
                        else if($supplementaryServiceCode == "YOUAGEVAL") $stringOfTheServices .= ", VF Young check on age";
                        else if($supplementaryServiceCode == "YOUABIAGE") $stringOfTheServices .= ", VF Young für Minderj�hrige";
                        else if($supplementaryServiceCode =="PYPCHAT") $stringOfTheServices .= "Chat Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PYPSOCIAL") $stringOfTheServices .= "Social Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PYPMUSIC") $stringOfTheServices .= "Music Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PYPVIDEO")	$stringOfTheServices .= "Video Pass 0 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PACHAT") $stringOfTheServices .= "Chat Pass 5 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PASOCIAL") $stringOfTheServices .= "Social Pass 5 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PAMUSIC") $stringOfTheServices .= "Music Pass 5 Euro/Mon., ";
                        else if($supplementaryServiceCode =="PAVIDEO") $stringOfTheServices .= "Video Pass 10 Euro/Mon., ";
                        else
                            $stringOfTheServices .= Service::where('code', $supplementaryServiceCode)->first()->name . ", ";
                    }

                if($cardVFGsmInTheContract->call_barring == "SO_SO") $textForAnrufsperre = "Anrufe zum Service 190";
                else $textForAnrufsperre = "Keine";

                if($cardVFGsmInTheContract->show_phone_numbers == "NRDEFJA") $textForShowPhoneNumber = "ein, fallweise aus";
                else if($cardVFGsmInTheContract->show_phone_numbers == "NRDEFNEIN") $textForShowPhoneNumber = "aus, fallweise ein";
                $pdf->SetXY($x+50,$y);
                $pdf->MultiCell(130,4.5,
                    "Grundgebühr: " . Tariff::find($cardVFGsmInTheContract->tariff_id)->base_price . " Euro \n
                        Vertragsbeginn: " . $cardVFGsmInTheContract->contract_start . "\n\n
                        
                        Zusatzdienste / Tarifoptionen: ".$stringOfTheServices."\n\n
                        Verbindungsübersich: " . $cardVFGsmInTheContract->connection_overview . "\n
                        Zielrufnummerdarstellung: " . $cardVFGsmInTheContract->represent_destination_number . "\n
                        Anrufsperre: " . $textForAnrufsperre . "\n
                        Mailbox: " . $cardVFGsmInTheContract->mailbox . "\n
                        Mobilfunknummernanzeige - Rufnummer Übertragung:" . $textForShowPhoneNumber . "\n

                                     
                        Zus�tzliche Vertragsbedingungen:\n"."vertragsbedingungen.RechteBlaBla"."\n\n
                       
                        Teilnehmerkennwort:                         Vodafone-Nummer(Wunsch):\n".
                    "ZuhauseAdresse"
                    ,1, 'L');


                //Linienkonstrukt, da die L�nge der 2. Spalte variiert
                $y=$pdf->GetY();
                $pdf->SetLineWidth(0.3);
                $pdf->Line(10,$y,60,$y);
                $pdf->Line(10,$LineBegin,10,$y);
            }


            $y=$pdf->GetY()+20;

            $pdf->SetLineWidth(0.3);
            $pdf->Line(10,$y,190,$y);

            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(180,4.5,"Datum: ".$dateTimeString."                                                               Datum:".$dateTimeString,0, 'L');


            $y=$pdf->GetY()+20;



            //Unterschrift von Allen
            $pdf->SetFont('Arial','B',8.5);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(180,4.5,"Stempel/\nUnterschrift\ndes H�ndlers   ___________________________________\n                          Wir best�tigen hiermit die\n                          Richtigkeit der Kundenangaben",0, 'L');

            $pdf->SetXY($x+90,$y);
            $pdf->MultiCell(180,4.5,"\nUnterschrift\ndes Kunden   ___________________________________",0, 'L');


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Vodafone Stars
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /**
            if ($enti[Stars]=='JA'){

            if (($enti[StarsWerbungSMS]=='perSMS')||($enti[StarsWerbungEmail]=='perEmail'))$Werbung="X";ELSE $Werbung=" ";
            if ($enti[StarsWerbungSMS]=='perSMS')$perSMS="X";ELSE $perSMS=" ";
            if ($enti[StarsWerbungEmail]=='perEmail')$perEmail="X";ELSE $perEmail=" ";






            $pdf->AddPage('P');


            $pdf->SetFont('Arial','',10);
            $pdf->SetXY(10,10);
            $pdf->MultiCell(190,3.7,'Vodafone Stars');





            $x=10;
            $y=25;

            $pdf->SetFont('Arial','B',14);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,'Vodafone Stars - Gleich mitmachen und anmelden!');

            $y=$pdf->GetY()+4;

            $pdf->SetFont('Arial','',9);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,'Steigen Sie ein bei Vodafone-Stars, sammeln sie Punkte und tauschen Sie diese gegen Top-Pr�mien ein!');

            $y=$pdf->GetY()+4;


            $pdf->SetFont('Arial','B',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,'Vodafone-Handy-Nummer:                                                                    [] CallYa        [X] Laufzeitvertrag');

            $y=$pdf->GetY()+3;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,'Ich nutze das Handy �berwiegend');

            $y=$pdf->GetY()+0;

            $pdf->SetFont('Arial','',7);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,'(Angabe freiwillig)');

            $y=$pdf->GetY()+2;

            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,"[X]\n\n\n[".$Werbung."]\n\n\n\n[X]");

            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY($x+5,$y);
            $pdf->MultiCell(170,3.7,"Ja, ich will mit der oben genannten Rufnummer bei Vodafone-Stars mitmachen, Punkte sammeln und gegen attraktive Pr�mien einl�sen.\n\nJa, ich will regelm��ig �ber Neuigkeiten bei Vodafone-Stars informiert werden.\n[".$perEmail."]  per Email\n[".$perSMS."]  per SMS\n\nJa, ich akzeptiere die Teilnahmebedingungen von Vodafone Stars.");
            $y=$pdf->GetY()+0;

            $pdf->SetFont('Arial','',7);
            $pdf->SetXY($x+5,$y);
            $pdf->MultiCell(170,3.7,'(Diese k�nnen in den Verkaufsr�umen eingesehen werden, im Internet unter www.vodafone.de/vodafonestars und �ber Vodafone-InfoFax Nr. 365 abgerufen sowie unter der Service Nr. 22 44 99 kostenlos aus dem VF D2-Netz abgeh�rt werden)');

            $y=$pdf->GetY()+2;
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"Einwilligung zur Nutzung meiner Bestands- und Verbindungsdaten");

            $y=$pdf->GetY()+2;
            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"Ich willige - jetzt widerruflich - darin ein, dass Vodafone D2\n- meine Verkehrsdaten (Daten, die bei der Bereitstellung und Erbringung von Telekommunikationsdienstleistungen erhoben werden) zur Vermarktung und bedarfsgerechten Gestaltung von Vodafone-Telekommunikationsdienstleistungen oder zur Bereitstellung von Diensten mit Zusatznutzen f�r l�ngstens 6 Monate nach Rechnungsversand speichert, verarbeitet und nutzt;\n- mich zu Werbezwecken (auch automatisiert) anruft oder mir per Telefax oder in Form elektronischer nachrichten Werbung zusendet und\n- meine Bestandsdaten (Daten, die erhoben werden, um das Vertragsverh�ltnis einschlie�lich seiner inhaltlichen Ausgestaltung zu begr�nden oder zu �ndern) verarbeitet und nutzt, soweit dies zur Kundenberatung, Werbung und Marktforschung erforderlich ist.\n\nOhne Einwilligung bleiben etwaige gesetzliche Werbebeschr�nkungen bestehen.\n\nDatum:                                     ".$Date."\nUnterschrift des                        x\nAuftraggebers:                         __________________________________________\nName in Druckbuchstaben                    ",1);
            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"Sofern unten ein abweichender Nutzer der Vodafone-Karte eingetragen ist, wird dieser anstatt des Vertragspartners der oben genannten Rufnummer als Teilnehmer von Vodafone-Stars registriert. Ich erteile hiermit meine Zustimmung, dass statt mir selbst der Nutzer Teilnehmer von Vodafone-Stars wird.");

            $y=$pdf->GetY()+3;

            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"________________________________          ".$Date);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"Unterschrift des Vertragspartners,                              Datum\nder oben genannten Rufnummer\n\nVor-/Nachname\nin Druckbuchstaben");

            $y=$pdf->GetY()+2;
            $pdf->SetLineWidth(0.3);
            $pdf->Line(10,$y,205,$y);

            $y=$pdf->GetY()+2;

            $pdf->SetFont('Arial','B',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"Adresse des Nutzers der Vodafone-Karte");
            $y=$pdf->GetY()+2;

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3,"Vor-/Nachname\nggf. Firma\n\nStra�e, Nr.\n\nPLZ, Ort\n\nE-Mail\n\nGeburtsdatum");
            $y=$pdf->GetY()+2;

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"Mir ist bekannt, dass meine mit der Teilnahme verbundenen personenbezogenen Daten gem�� den geltenden Datenschutzbestimmungen verarbeitet und nur f�r Zwecke der Durchf�hrung des Programms Vodafone-Stars genutzt werden");

            $y=$pdf->GetY()+3;

            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(170,3.7,"________________________________          ".$Date."                              VO-ID: ".$enti[VO]);

            $y=$pdf->GetY()+1;

            $pdf->SetFont('Arial','',8);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,"Unterschrift des Nutzers,                                            Datum                                             (Eintrag erfolgt durch Vodafone-D2)\nfalls abweichend vom Vertragspartner");


            $y=$pdf->GetY()+1;


            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,"Mehr Infos zu Vodafone-Stars gibt's unter 22 44 88 oder im Internet unter www.vodafone.de/vodafonestars.\n................................................................................................................................................................................................................");

            $y=$pdf->GetY();
            $pdf->SetFont('Arial','B',7);
            $pdf->SetXY($x,$y);
            $pdf->MultiCell(190,3.7,"Bitte vollst�ndig ausf�llen und unterschrieben zur�ckfaxen an:               [X]Teilnehmer wurde bereits �ber Vodafone-ePOS-Direct-Import Client angemeldet!\nVodafone D2 GmbH, Abteilung VCS, Fax: 0 21 02 / 98 65 75 ");

            }

            if(($enti[FNI]!=0) && ($Tarif[$Info]="VFZH24FFN")){

            /* if($enti[FNI]!=0)

            $pdf->setSourceFile('portierungsformular.pdf');
            $tplidx = $pdf->importPage(1);//Seitenzahl
            $pdf->addPage();
            $pdf->useTemplate($tplidx, 0, 0, 210);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY(45,36.5);
            $pdf->MultiCell(40,30,$enti[Name]);
            $pdf->SetXY(45,43.5);
            $pdf->MultiCell(40,30,$enti[Vorname]);
            $pdf->SetXY(45,50);
            $pdf->MultiCell(40,30,$enti[Strasse]." ".$enti[Hausnummer]);
            $pdf->SetXY(45,57.5);
            $pdf->MultiCell(140,30,$enti[PLZ]."                                                       ".$enti[Ort]);
            $pdf->SetFont('Arial','B',10);
            $pdf->SetXY(77,189);
            $pdf->MultiCell(70,30,$Date);
            $pdf->SetXY(174,197);
            $pdf->MultiCell(70,30,$Date);
            $pdf->SetFont('Arial','B',11);
            $pdf->SetXY(45,213);
            $pdf->MultiCell(100,40,$enti[Vorname]." ".$enti[Name]);

            }


            if($ZusatzBlattVFV=="NEIN") { || if($getSonderdienst=="24MIN60")  {

            /* Hier wird die Zusatzvereinbarung.pdf ab dem 03.10.2011 als Bild ausgegeben
            $pdf->addPage();
            $pdf->Image('zusatzvereinbarung.jpg', 0,0,210,297);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetXY(45,36.5);
            $pdf->MultiCell(40,30,$enti[Name]);
            $pdf->SetXY(45,43.5);
            $pdf->MultiCell(40,30,$enti[Vorname]);
            $pdf->SetXY(45,50);
            $pdf->MultiCell(40,30,$enti[Strasse]." ".$enti[Hausnummer]);
            $pdf->SetXY(45,57.5);
            $pdf->MultiCell(140,30,$enti[PLZ]."                                                       ".$enti[Ort]);
            $pdf->SetFont('Arial','B',10);
            $pdf->SetXY(77,189);
            $pdf->MultiCell(70,30,$Date);
            $pdf->SetXY(174,197);
            $pdf->MultiCell(70,30,$Date);
            $pdf->SetFont('Arial','B',11);
            $pdf->SetXY(45,213);
            $pdf->MultiCell(100,40,$enti[Vorname]." ".$enti[Name]);
            }
             */

        //$pdf->PrintChapter(1, 'Lorem Ipsum', 'Lorem Ipsum');
        //$pdf->Output('d');

        //$printPDF = new Pdf();
        //$printPDF->PrintChapter(1, 'Lorem Ipsum', 'Lorem Ipsum');

        Storage::put('TokasPdf5.pdf', $pdf->Output('s'));

    }


    /**
     * Execution forwarded from "resources/views/contracts/vodafone/finalize.blade.php"
     *
     * Forward the program execution to the related provider's controller's store function
     * according to the provider_id which is defined as hidden in the related create page (resources/views/contracts/vodafone/create.blade.php).
     */
    public function finalizeGSMVodafone(Request $request)
    {

        // Since "Finalize Vertrag" button has been pushed, "status" attribute of the contract table will be chanced.

        Contract::changeStatusOfContract($request->contractID, 1);

        // And, XML file will be produced.
        Contract::produceXMLForGsmVodafoneContract($request->contractID);

        // After the XML has been produced, shopping cart must be emptied and related session variables must be deleted.
        ShoppingCart::emptyShoppingCart(auth()->user()->id, 1);
        Session::flash('messageContractFinalised', 'contractFinalised');
        return $this->tariffs();
    }


    /**
     * Initialized when entering http://tokasdraft.com/contract/generate-XML
     *
     */
    public function callToGenerateXMLGUI()
    {
        return view('contracts.vodafone.generateXMLTRY');
    }

    /**
     * Initialized URL: "/contracts/vodafone/XML/takeXML"
     */
    public function viewTakeXML()
    {
        return view('contracts.vodafone.takeXML');
    }

    /**
     * forwarded from resources/views/contracts/vodafone/takeXML.blade.php by post method.
     */
    public function forwardToReadXML(Request $request)
    {
        Contract::readXML($request);
    }


    public function forwardToStoreTRY_DELETE(Request $request)
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
        if ($formDataInCreateContract->customerType == 1 or $formDataInCreateContract->customerType == 3) // Private and SoHo customer
            $customerID = Customer
                ::where('identity_card_number', $formDataInCreateContract->mainCustomerIDNumber)
                ->first()->identity_card_number;
        else if ($formDataInCreateContract->customerType == 2) // Business customer
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

        if ($formDataInCreateContract->providerID == 1) // Contract for Vodafone
        {
            if ($formDataInCreateContract->contractType == 1) { // new activation GSM - if($request->contract_type == 1 and $request->FNIPorting == 0)
                VfGsm::store($contractID, $formDataInCreateContract);
            } else if ($formDataInCreateContract->contractType == 1) { // new activation GSM-FNI porting - if($request->contract_type == 1 and $request->FNIPorting == 1)

            } else if ($formDataInCreateContract->contractType == 2) { // porting

            } else if ($formDataInCreateContract->contractType == 3) { // DC change

            } else if ($formDataInCreateContract->contractType == 4) { // DSL

            }
        } else if ($formDataInCreateContract->providerID == 2) // Contract for Ay Yıldız
        {

        } else if ($formDataInCreateContract->providerID == 3) // Contract for O2
        {

        }
    }

    /**
     * Execution forwarded from "resources/views/contracts/vodafone/generateXMLTRY.blade.php"
     *
     */
    public function forwardToGenerateXML_DELETE(Request $request)
    {
        // And, XML file will be produced.
        Contract::produceXMLForGsmVodafoneContract($request->contractID);

        redirect()->home();
    }
}

