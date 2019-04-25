<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VfDsl extends Model
{
    protected $fillable = ['contract_id', 'AO_bundle_offering_code', 'group_change_group_id', 'objection', 'additional_contract', 'customer_number', 'password',
        'subscriber_id', 'tariff_id', 'tariff_and _services',
        'owner_name', 'owner_surname', 'same_contact_address_owner', 'DSL_available', 'approval_DSL_downgrade',
        'NTBA_installation', 'house_type', 'apartment', 'entrance', 'floor', 'location_TAE _box',
        'same_contact_address_for_installation', 'same_contact_address_for_shipping', 'salutation_for_shipping',
        'name_for_shipping', 'surname_for_shipping', 'company_name_for_shipping'];
}
