<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['contract_type', 'provider_id', 'customer_id', 'salesperson_id', 'office_id', 'dealer_id', 'VO_id', 'contract_start', 'status'];

    /**
     * Define the relations
     */
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function vfGsms(){
        return $this->hasMany(VfGsm::class);
    }

    public function vfPorting(){
        return $this->hasOne(VfPorting::class);
    }

    public function vfDcChange(){
        return $this->hasOne(VfDcChange::class);
    }

    /**
     * User defined functions
     */
    public static function store($customerID, $request){ // Execution forwarded from ContractController@forward

        $contract = new Contract();

        $contract->contract_type = $request->contractType;
        $contract->provider_id = $request->providerID;
        $contract->customer_id = $customerID;
        $contract->salesperson_id = auth()->user()->id;
        $contract->office_id = auth()->user()->office_id;
        $contract->dealer_id = auth()->user()->dealer_id;
        $contract->VO_id = DealersMemberCode::where('dealer_id', auth()->user()->dealer_id)->first()->vodafone_UVP;
        //$contract->tariff_id has been excluded from the Contracts table...since there might be more than one tariff in the shopping cart.
        $contract->contract_start = "2019-04-30";
        $contract->status = 1;

        $contract->save();
    }
}
