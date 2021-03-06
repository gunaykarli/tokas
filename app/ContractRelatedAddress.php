<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractRelatedAddress extends Model
{
    protected $fillable = ['related_id', 'contract_id', 'street', 'house_number', 'city', 'postal_code', 'country'];

    /**
     * Define the relations
     */

    public function vfGsm(){
        return $this->belongsTo(VfGsm::class);
    }
}
