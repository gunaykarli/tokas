<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VfPorting extends Model
{
    protected $fillable = ['contract_id', 'phone_number_NDC', 'phone_number_MSISDN', 'subsequent_porting_type',
        'entry_date', 'previous_provider_name', 'previous_provider_contract_end_date', 'previous_provider_termination_date',
        'previous_provider_customer_name', 'previous_provider_customer_surname', 'previous_provider_customer_birth_date',
        'previous_provider_company_name', 'desired_card_type', 'same_contact_address',
        'tariff_id', 'connection_overview', 'represent_destination_number', 'objection', 'additional_contract',
        'customer_number', 'password', 'supplementary_services', 'data _services', 'mailbox',
        'call_barring', 'show_phone_numbers', 'porting_with_hardware'];
}
