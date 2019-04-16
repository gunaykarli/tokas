<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VfDcChange extends Model
{
    protected $fillable = ['contract_id', 'contract_start', 'entry_date',
        'phone_number_NDC', 'phone_number_MSISDN', 'previous_provider_name',
        'birth_date', 'IMEI_type',
        'same_contact_address',
        'tariff_id', 'connection_overview', 'represent_destination_number', 'objection', 'additional_contract',
        'customer_number', 'password', 'supplementary_services', 'data _services', 'mailbox',
        'call_barring', 'show_phone_numbers', 'porting_with_hardware'];
}
