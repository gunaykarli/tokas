<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPaymentTool extends Model
{
    protected $fillable = ['customer_id', 'card_number', 'valid_to_month', 'valid_to_year', 'card_credit_institution',
        'different_account_owner', 'account_owner', 'IBAN', 'BIC', 'different_account_owner_address'
    ];

    /**
     * Define the relations
     */
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    /**
     * User defined functions
     */
    public static function store($customerID, $request){ // Execution forwarded from ContractController@forward

        $customerPaymentTool = new CustomerPaymentTool();

        $customerPaymentTool->customer_id = $customerID;

        // Bank info
        if($request->isAccountOwnerDifferent == 'on'){
            $customerPaymentTool->is_account_owner_different = 1;
            $customerPaymentTool->account_owner = $request->accountOwner;
        }
        else{
            // depending on the "customerType" account_owner is set.
            if($request->customerType == 1 or $request->customerType == 3){// Private or SoHo
                $customerPaymentTool->is_account_owner_different = 0;
                $customerPaymentTool->account_owner = $request->mainCustomerName .' '. $request->mainCustomerSurname;
            }
            else{// Business
                $customerPaymentTool->is_account_owner_different = 0;
                $customerPaymentTool->account_owner = $request->companyName;
            }

        }
        $customerPaymentTool->IBAN = $request->IBAN;
        $customerPaymentTool->BIC = $request->BIC;

        // Credit Card info

        $customerPaymentTool->card_number = $request->cardNumber;
        $customerPaymentTool->valid_to_month = $request->cardNumberValidToMonth;
        $customerPaymentTool->valid_to_year = $request->cardNumberValidToYear;
        $customerPaymentTool->card_credit_institution = $request->creditInstitution;



        $customerPaymentTool->save();

    }
}
