<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VfGsm extends Model
{
    protected $fillable = ['VF_credit_activation_id', 'subscriber_id', 'SIM_serial _number', 'SIM_IMEI_type',
        'tariff_and_services', 'tariff_id', 'same_contact_address', 'connection_overview',
        'represent_destination_number', 'supplementary_services', 'data _services',
        'mailbox', 'call_barring', 'show_phone_numbers', 'disabled_card_id', 'disability_degree'];
}
