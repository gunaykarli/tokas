<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VfGsm extends Model
{
    protected $fillable = ['contract_id', 'AO_bundle_offering_code', 'group_change_group_id', 'objection', 'additional_contract', 'customer_number',  'activation_with_hardware',
        'subscriber_id', 'SIM_serial _number', 'SIM_IMEI_type',
        'tariff_and_services', 'tariff_id', 'same_contact_address', 'connection_overview',
        'represent_destination_number', 'supplementary_services', 'data _services',
        'mailbox', 'call_barring', 'show_phone_numbers', 'disabled_card_id', 'disability_degree'
    ];

    public static function store($request){
        // Execution forwarded from Contractcontroller@forward

        // Store the contact info of the customer which is about to buy the tariff.
        Customer::store($request);
    }
}
