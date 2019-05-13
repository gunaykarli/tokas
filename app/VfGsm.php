<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VfGsm extends Model
{
    protected $fillable = ['contract_id', 'AO_bundle_offering_code', 'group_change_group_id', 'objection', 'additional_contract', 'customer_number',  'activation_with_hardware',
        'SIM_serial _number', 'SIM_IMEI_type',
        'tariff_and_services', 'tariff_id', 'different_invoice_address', 'different_home_address', 'connection_overview',
        'represent_destination_number', 'supplementary_services', 'data_services',
        'mailbox', 'call_barring', 'show_phone_numbers', 'disabled_card_id', 'disability_degree'
    ];

    /** Define the relations  */

    public function contract(){
        return $this->belongsTo(Contract::class);
    }

    public function relatedAddress(){
        return $this->hasOne(ContractRelatedAddress::class, 'related_id');
    }

    /** User defined functions */

    public static function store($contractID, $request){ // Execution forwarded from ContractController@forward
        $VfGsmContract = new VfGsm();

        $VfGsmContract->contract_id = $contractID;
        $VfGsmContract->AO_bundle_offering_code = 'Deneme';//*** min occurs = 0
        $VfGsmContract->group_change_group_id = 0;//*** min occurs = 0

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

       $VfGsmContract->activation_with_hardware = 0;/*** USE...*/
       $VfGsmContract->SIM_serial_number = $request->SIMNumber;

       /** IMEI set up */
       if(SystemVariable::where('name', 'isIMEIOnDemandFieldActive')->first()->value == 1){/** if IMEI on demand field active */
            if($request->IMEIOption == 3){// Dealer has entered his own IMEI number
                $VfGsmContract->SIM_IMEI_type = $request->IMEINumber;
            }
            else if($request->IMEIOption == 2){// IMEI on demand
                // take IMEI number from the table named 'IMEIOnDemand' */
                // first, check if there is an available IMEI in the table.
                if($IMEIOnDemand = ImeiOnDemand::where('provider_id', $request->providerID)->where('status', 0)->first()){
                    $VfGsmContract->SIM_IMEI_type = $IMEIOnDemand->IMEI;
                    // change the 'status' of the current IMEIOnDemand instance from 0 to 2 which means 'reserved'
                    $IMEIOnDemand->status = 2;
                    $IMEIOnDemand->contract_id = $contractID;
                    /** CHECK if it necessray to save vf_gsm_id */ //$IMEIOnDemand->vf_gsm_id
                    $IMEIOnDemand->salesperson_id = auth()->user()->id;
                    $IMEIOnDemand->save();
                }
                else
                    $VfGsmContract->SIM_IMEI_type = 4; //'nachtraeglicheErfassung'
            }
            else if($request->IMEIOption == 1){ // No device, take IMEI from the IMEI Pool
                // take IMEI number from the table named 'IMEIPool' */
                // check if
                // 1. IMEI pool is active
                // 2. IMEI pool Date is ok
                // 3. And there is a IMEI in the table.
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
       else if(SystemVariable::where('name', 'isIMEIPoolActive')->first()->value == 1){ // IMEI on demand field is NOT active so take IMEI from the IMEI Pool
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


        $VfGsmContract->tariff_id = ShoppingCart::where('id', $request->shoppingCartID)->first()->product_id; /** ek kart olduğunda bu sorgu değişebilir... */

       $VfGsmContract->tariff_and_services = 'Deneme'; /**  */


       if($request->isInvoiceAddressDifferent == 'on'){
            $VfGsmContract->different_invoice_address = 1;
            /** store the invoice address from GUI (in $request) to the 'Customer Invoices' table */
       }
       else{
            $VfGsmContract->different_invoice_address = 0;
            /** store the invoice address from 'Customer Contact' table to the 'Customer Invoices table' */
       }

        $VfGsmContract->connection_overview = $request->connectionOverview;
        $VfGsmContract->represent_destination_number = $request->destinationNumberRepresentation;
        $VfGsmContract->supplementary_services = 'Deneme' ; /**  */
        $VfGsmContract->data_services = 'Deneme'; /**  */
        $VfGsmContract->mailbox = $request->mailbox;
        $VfGsmContract->call_barring = $request->callBarring;
        $VfGsmContract->show_phone_numbers = $request->telephoneNumberTransmission;//*** Rufnummereinzeige???

        if($request->isDisabledDiscount == 'on'){
            $VfGsmContract->disabled_card_id = $request->disabledPersonCardNumber;
            $VfGsmContract->disability_degree = $request->disabilityDegree ;
        }

        $VfGsmContract->save();
    }
}
