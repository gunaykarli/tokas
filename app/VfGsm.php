<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class VfGsm extends Model
{
    protected $fillable = ['contract_id', 'AO_bundle_offering_code', 'group_change_group_id', 'objection', 'additional_contract', 'customer_number',  'activation_with_hardware',
        'additional_tariff', 'SIM_serial _number', 'SIM_IMEI_type',
        'tariff_id', 'contract_start', 'different_invoice_address', 'different_home_address', 'connection_overview',
        'represent_destination_number', 'supplementary_services', 'data_services',
        'mailbox', 'call_barring', 'show_phone_numbers', 'disabled_card_id', 'disability_degree'
    ];

    protected $casts = [
        'data_services' => 'array',
        'supplementary_services' => 'array',
    ];

    /** Define the relations  */

    public function contract(){
        return $this->belongsTo(Contract::class);
    }

    public function relatedAddress(){
        return $this->hasOne(ContractRelatedAddress::class, 'related_id');
    }

    /** User defined functions */

    /** Stores the data related to the fields in vf_gsm table
     the following method is working without problem...*/
    public static function storeWithOutSession_NOT_USED($contractID, $request){ // Execution forwarded from ContractController@forwardToStore
        $VfGsmContract = new VfGsm();

        $VfGsmContract->contract_id = $contractID;
        $VfGsmContract->AO_bundle_offering_code = 'Deneme';//*** min occurs = 0
        $VfGsmContract->group_change_group_id = 0;//*** min occurs = 0
        $VfGsmContract->activation_with_hardware = 0;/*** USE for activation with hardware...*/
        $VfGsmContract->SIM_serial_number = $request->SIMNumber;
        $VfGsmContract->tariff_id = ShoppingCart::where('id', $request->shoppingCartID)->first()->product_id; /** ek kart olduğunda bu sorgu değişebilir... */

        // connection_overview codes come from the ".xsd" file.
        if($request->connectionOverview == 1)
            $VfGsmContract->connection_overview = 'Uebersicht Mini';
        else if($request->connectionOverview == 2)
            $VfGsmContract->connection_overview = 'Uebersicht';
        else if($request->connectionOverview == 3)
            $VfGsmContract->connection_overview = 'keine';

        // represent_destination_number codes come from the ".xsd" file.
        if($request->destinationNumberRepresentation == 1)
            $VfGsmContract->represent_destination_number = 'vollstaendig';
        else if($request->destinationNumberRepresentation == 2)
            $VfGsmContract->represent_destination_number = 'verkuerzt';

        $VfGsmContract->tariff_and_services = 'Deneme'; /** Burası sadece tag ismi, değer yok...Silinebilir...  */
        $VfGsmContract->supplementary_services = $request->additionalServices; // "additionalService" checkbox list (in resources/views/contracts/vodafone/create.blade.php) saved as an array to "supplementary_services" field.
        $VfGsmContract->data_services = $request->dataServices; // "dataServices" checkbox list saved as an array to "data_services" field.

        // mailbox codes come from the "Plausi. für buchbare Dienste" sheet.
        if($request->mailbox == 1)
            $VfGsmContract->mailbox = 'MAILBOX';
        else if($request->mailbox == 2)
            $VfGsmContract->mailbox = 'MAILBOXZH';
        else if($request->mailbox == 3)
            $VfGsmContract->mailbox = 'MAILBOXP';
        else if($request->mailbox == 4)
            $VfGsmContract->mailbox = 'KEINE';

        // call_barring codes come from the "Plausi. für buchbare Dienste" sheet.
        if($request->callBarring == 1)
            $VfGsmContract->call_barring = 'KEINE';
        else if($request->callBarring == 2)
            $VfGsmContract->call_barring = 'SO_SO';

        // show_phone_numbers codes come from the "Plausi. für buchbare Dienste" sheet.
        if($request->telephoneNumberTransmission == 1)/*** Rufnummereinzeige???*/
            $VfGsmContract->show_phone_numbers = 'NRDEFJA';
        else  if($request->telephoneNumberTransmission == 2)
            $VfGsmContract->show_phone_numbers = 'NRDEFNEIN';

        if($request->objection == 'on'){
            $VfGsmContract->objection = 1;
        }
        else{
            $VfGsmContract->objection = 0 ;
        }

       if($request->additionalContract == 'on'){
           $VfGsmContract->additional_contract = 1;
           $VfGsmContract->customer_number = $request->additionalContractCustomerNumber ;
       }
       else{
           $VfGsmContract->additional_contract = 0;
       }


       /**begin: IMEI set up */

       /** if "IMEI on demand" fields active */
       if(SystemVariable::where('name', 'isIMEIOnDemandFieldActive')->first()->value == 1){
            if($request->IMEIOption == 3){ // Dealer has entered his own IMEI number
                $VfGsmContract->SIM_IMEI_type = $request->IMEINumber;
            }
            else if($request->IMEIOption == 2){ // "IMEI on demand"
                // take IMEI number from the table named 'IMEIOnDemand' */
                // first, check if there is an available IMEI in the table.
                if($IMEIOnDemand = ImeiOnDemand::where('provider_id', $request->providerID)->where('status', 0)->first()){
                    $VfGsmContract->SIM_IMEI_type = $IMEIOnDemand->IMEI;
                    // change the 'status' field of the current (row)IMEIOnDemand instance from 0 to 2 which means 'reserved'
                    $IMEIOnDemand->status = 2;
                    $IMEIOnDemand->contract_id = $contractID;
                    /** CHECK if it is necessary to save vf_gsm_id */ // $IMEIOnDemand->vf_gsm_id
                    $IMEIOnDemand->salesperson_id = auth()->user()->id;
                    $IMEIOnDemand->save();
                }
                else
                    $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
            }
            else if($request->IMEIOption == 1){ // No device, take IMEI from the IMEI Pool
                // take IMEI number from the table named 'IMEIPool' */
                // check if 1. IMEI pool is active 2. IMEI pool Date is ok 3. And there is an available IMEI in the table.
                // If none of the above is true then assign 'nachtraeglicheErfassung' as a value of $VfGsmContract->SIM_IMEI_type
                if(SystemVariable::where('name', 'isIMEIPoolActive')->first()->value == 1){
                    $IMEIPoolActiveFrom = SystemVariable::where('name', 'IMEIPoolActiveFrom')->first()->value;
                    $IMEIPoolActiveTo = SystemVariable::where('name', 'IMEIPoolActiveTo')->first()->value;
                    if(Carbon::today()->greaterThanOrEqualTo(Carbon::parse($IMEIPoolActiveFrom)) and Carbon::today()->lessThanOrEqualTo(Carbon::parse($IMEIPoolActiveTo)) )
                        if($IMEIPool = ImeiPool::where('provider_id', $request->providerID)->where('status', 0)->first()){
                            $VfGsmContract->SIM_IMEI_type = $IMEIPool->IMEI;
                            // change the 'status' of the current IMEIOnDemand instance from 0 to 2 which means 'reserved'
                            $IMEIPool->status = 2;
                            $IMEIPool->contract_id = $contractID;
                            /** CHECK if it necessray to save vf_gsm_id */ //$IMEIPool->vf_gsm_id
                            $IMEIPool->salesperson_id = auth()->user()->id;
                            $IMEIPool->save();
                        }
                        else
                            $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
                    else
                        $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
                }
                else
                    $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
            }
       }
       /** IMEI on demand field is NOT active so take IMEI from the IMEI Pool */
       else if(SystemVariable::where('name', 'isIMEIPoolActive')->first()->value == 1){
           $IMEIPoolActiveFrom = SystemVariable::where('name', 'IMEIPoolActiveFrom')->first()->value;
           $IMEIPoolActiveTo = SystemVariable::where('name', 'IMEIPoolActiveTo')->first()->value;
           if(Carbon::today()->greaterThanOrEqualTo(Carbon::parse($IMEIPoolActiveFrom)) and Carbon::today()->lessThanOrEqualTo(Carbon::parse($IMEIPoolActiveTo)) )
               if($IMEIPool = ImeiPool::where('provider_id', $request->providerID)->where('status', 0)->first()){
                   $VfGsmContract->SIM_IMEI_type = $IMEIPool->IMEI;
                   // change the 'status' of the current IMEIOnDemand instance from 0 to 2 which means 'reserved'
                   $IMEIPool->status = 2;
                   $IMEIPool->contract_id = $contractID;
                   /** CHECK if it necessray to save vf_gsm_id */ //$IMEIPool->vf_gsm_id
                   $IMEIPool->salesperson_id = auth()->user()->id;
                   $IMEIPool->save();
               }
               else
                   $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
           else
               $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
       }
       else
           $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'

       /**end: IMEI set up */


       if($request->isInvoiceAddressDifferent == 'on'){
            $VfGsmContract->different_invoice_address = 1;
            /** store the invoice address from GUI (in $request) to the 'Customer Invoices' table */
            CustomerInvoiceAddress::store(1, Contract::where('id', $contractID)->first()->customer_id, $request);
       }
       else{
            $VfGsmContract->different_invoice_address = 0;
            /** store the invoice address from 'Customer Contact' table to the 'Customer Invoices table' */
           CustomerInvoiceAddress::store(0, Contract::where('id', $contractID)->first()->customer_id, $request);
       }

       if($request->isDisabledDiscount == 'on'){
            $VfGsmContract->disabled_card_id = $request->disabledPersonCardNumber;
            $VfGsmContract->disability_degree = $request->disabilityDegree ;
       }

       $VfGsmContract->save();
    }
    public static function store($contractID, $request){ // Execution forwarded from ContractController@forwardToStore

        $products = ShoppingCart
            ::where('product_type', 1)
            ->where('dealer_id', auth()->user()->dealer_id)
            ->where('office_id', auth()->user()->office_id)
            ->where('employee_id', auth()->user()->id)
            ->get();

        foreach($products as $product){
            $VfGsmContract = new VfGsm();
            // begin:: Variables from the Session - set up data which are different for each tariff in the shopping cart.

            // take the variables from the Session created as 'tariff->name' associative array in "ShoppingCartController@saveSimImeiServicesToSession"
            $simImeiServicesFromSession = Session::get(Tariff::where('id', $product->product_id)->first()->name);
            $VfGsmContract->additional_tariff = $simImeiServicesFromSession['isAdditionalTariff'];
            $VfGsmContract->tariff_id = $simImeiServicesFromSession['tariffID'];
            $VfGsmContract->contract_start = $simImeiServicesFromSession['contractStartDate'];
            $VfGsmContract->SIM_serial_number = $simImeiServicesFromSession['SIMNumber'];
            $VfGsmContract->activation_with_hardware = 0; // deneme

            /** begin: IMEI set up */

            /** if "IMEI on demand" fields active */
            if(SystemVariable::where('name', 'isIMEIOnDemandFieldActive')->first()->value == 1){
                if($simImeiServicesFromSession['IMEIOption'] == 3){ // Dealer has entered his own IMEI number
                    $VfGsmContract->SIM_IMEI_type = $simImeiServicesFromSession['IMEINumber'];
                }
                else if($simImeiServicesFromSession['IMEIOption'] == 2){ // "IMEI on demand"
                    // take IMEI number from the table named 'IMEIOnDemand' */
                    // first, check if there is an available IMEI in the table.
                    if($IMEIOnDemand = ImeiOnDemand::where('provider_id', $request->providerID)->where('status', 0)->first()){
                        $VfGsmContract->SIM_IMEI_type = $IMEIOnDemand->IMEI;
                        // change the 'status' field of the current (row)IMEIOnDemand instance from 0 to 2 which means 'reserved'
                        $IMEIOnDemand->status = 2;
                        $IMEIOnDemand->contract_id = $contractID;
                        /** CHECK if it is necessary to save vf_gsm_id */ // $IMEIOnDemand->vf_gsm_id
                        $IMEIOnDemand->salesperson_id = auth()->user()->id;
                        $IMEIOnDemand->save();
                    }
                    else
                        $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
                }
                else if($simImeiServicesFromSession['IMEIOption'] == 1){ // No device, take IMEI from the IMEI Pool
                    // take IMEI number from the table named 'IMEIPool' */
                    // check if 1. IMEI pool is active 2. IMEI pool Date is ok 3. And there is an available IMEI in the table.
                    // If none of the above is true then assign 'nachtraeglicheErfassung' as a value of $VfGsmContract->SIM_IMEI_type
                    if(SystemVariable::where('name', 'isIMEIPoolActive')->first()->value == 1){
                        $IMEIPoolActiveFrom = SystemVariable::where('name', 'IMEIPoolActiveFrom')->first()->value;
                        $IMEIPoolActiveTo = SystemVariable::where('name', 'IMEIPoolActiveTo')->first()->value;
                        if(Carbon::today()->greaterThanOrEqualTo(Carbon::parse($IMEIPoolActiveFrom)) and Carbon::today()->lessThanOrEqualTo(Carbon::parse($IMEIPoolActiveTo)) )
                            if($IMEIPool = ImeiPool::where('provider_id', $request->providerID)->where('status', 0)->first()){
                                $VfGsmContract->SIM_IMEI_type = $IMEIPool->IMEI;
                                // change the 'status' of the current IMEIOnDemand instance from 0 to 2 which means 'reserved'
                                $IMEIPool->status = 2;
                                $IMEIPool->contract_id = $contractID;
                                /** CHECK if it necessray to save vf_gsm_id */ //$IMEIPool->vf_gsm_id
                                $IMEIPool->salesperson_id = auth()->user()->id;
                                $IMEIPool->save();
                            }
                            else
                                $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
                        else
                            $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
                    }
                    else
                        $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
                }
            }
            /** IMEI on demand field is NOT active so take IMEI from the IMEI Pool */
            else if(SystemVariable::where('name', 'isIMEIPoolActive')->first()->value == 1){
                $IMEIPoolActiveFrom = SystemVariable::where('name', 'IMEIPoolActiveFrom')->first()->value;
                $IMEIPoolActiveTo = SystemVariable::where('name', 'IMEIPoolActiveTo')->first()->value;
                if(Carbon::today()->greaterThanOrEqualTo(Carbon::parse($IMEIPoolActiveFrom)) and Carbon::today()->lessThanOrEqualTo(Carbon::parse($IMEIPoolActiveTo)) )
                    if($IMEIPool = ImeiPool::where('provider_id', $request->providerID)->where('status', 0)->first()){
                        $VfGsmContract->SIM_IMEI_type = $IMEIPool->IMEI;
                        // change the 'status' of the current IMEIOnDemand instance from 0 to 2 which means 'reserved'
                        $IMEIPool->status = 2;
                        $IMEIPool->contract_id = $contractID;
                        /** CHECK if it necessray to save vf_gsm_id */ //$IMEIPool->vf_gsm_id
                        $IMEIPool->salesperson_id = auth()->user()->id;
                        $IMEIPool->save();
                    }
                    else
                        $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
                else
                    $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
            }
            else
                $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'

            /** end: IMEI set up */

            // connection_overview codes come from the ".xsd" file.
            if($simImeiServicesFromSession['connectionOverview'] == 1)
                $VfGsmContract->connection_overview = 'Uebersicht Mini';
            else if($simImeiServicesFromSession['connectionOverview'] == 2)
                $VfGsmContract->connection_overview = 'Uebersicht';
            else if($simImeiServicesFromSession['connectionOverview'] == 3)
                $VfGsmContract->connection_overview = 'keine';

            // represent_destination_number codes come from the ".xsd" file.
            if($simImeiServicesFromSession['destinationNumberRepresentation'] == 1)
                $VfGsmContract->represent_destination_number = 'vollstaendig';
            else if($simImeiServicesFromSession['destinationNumberRepresentation'] == 2)
                $VfGsmContract->represent_destination_number = 'verkuerzt';

            // call_barring codes come from the "Plausi. für buchbare Dienste" sheet.
            if($simImeiServicesFromSession['callBarring'] == 1)
                $VfGsmContract->call_barring = 'KEINE';
            else if($simImeiServicesFromSession['callBarring'] == 2)
                $VfGsmContract->call_barring = 'SO_SO';

            // mailbox codes come from the "Plausi. für buchbare Dienste" sheet.
            if($simImeiServicesFromSession['mailbox'] == 1)
                $VfGsmContract->mailbox = 'MAILBOX';
            else if($simImeiServicesFromSession['mailbox'] == 2)
                $VfGsmContract->mailbox = 'MAILBOXZH';
            else if($simImeiServicesFromSession['mailbox'] == 3)
                $VfGsmContract->mailbox = 'MAILBOXP';
            else if($simImeiServicesFromSession['mailbox'] == 4)
                $VfGsmContract->mailbox = 'KEINE';

            // show_phone_numbers codes come from the "Plausi. für buchbare Dienste" sheet.
            if($simImeiServicesFromSession['telephoneNumberTransmission'] == 1)/*** Rufnummereinzeige???*/
                $VfGsmContract->show_phone_numbers = 'NRDEFJA';
            else  if($simImeiServicesFromSession['telephoneNumberTransmission'] == 2)
                $VfGsmContract->show_phone_numbers = 'NRDEFNEIN';

            //$VfGsmContract->tariff_and_services = 'Deneme'; /** Burası sadece tag ismi, değer yok...Silinebilir...  */
            $VfGsmContract->supplementary_services = $simImeiServicesFromSession['additionalServices']; // "additionalService" checkbox list (in resources/views/contracts/vodafone/create.blade.php) saved as an array to "supplementary_services" field.
            $VfGsmContract->data_services = $simImeiServicesFromSession['dataServices']; // "dataServices" checkbox list saved as an array to "data_services" field.
            // end:: Variables from the Session


            // begin:: set up data which are same for each tariff in the shopping cart.
            $VfGsmContract->contract_id = $contractID;

            if($request->additionalContract == 'on'){
                $VfGsmContract->additional_contract = 1;
                $VfGsmContract->customer_number = $request->additionalContractCustomerNumber ;
            }
            else{
                $VfGsmContract->additional_contract = 0;
            }
            $VfGsmContract->AO_bundle_offering_code = 'Deneme';//*** min occurs = 0
            $VfGsmContract->group_change_group_id = 0;//*** min occurs = 0
            $VfGsmContract->activation_with_hardware = 0;/*** USE for activation with hardware...*/


            if($request->objection == 'on'){
                $VfGsmContract->objection = 1;
            }
            else{
                $VfGsmContract->objection = 0 ;
            }

            if($request->isInvoiceAddressDifferent == 'on'){
                $VfGsmContract->different_invoice_address = 1;
                /** store the invoice address from GUI (in $request) to the 'Customer Invoices' table */
                CustomerInvoiceAddress::store(1, Contract::where('id', $contractID)->first()->customer_id, $request);
            }
            else{
                $VfGsmContract->different_invoice_address = 0;
                /** store the invoice address from 'Customer Contact' table to the 'Customer Invoices table' */
                CustomerInvoiceAddress::store(0, Contract::where('id', $contractID)->first()->customer_id, $request);
            }

            if($request->isDisabledDiscount == 'on'){
                $VfGsmContract->disabled_card_id = $request->disabledPersonCardNumber;
                $VfGsmContract->disability_degree = $request->disabilityDegree ;
            }
            // end:: set up data which are same for each tariff in the shopping cart.

            $VfGsmContract->save();
        }
    }
}