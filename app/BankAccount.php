<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['IBAN', 'cash_deposit', 'entity_type', 'entity_id'];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    public function addBankAccountOfDealer($dealerID, $request){

        $bankAccount = new BankAccount();

        $bankAccount->entity_id = $dealerID;
        $bankAccount->entity_type = "Dealer";
        $bankAccount->IBAN = $request->IBAN;
        $bankAccount->cash_deposit = $request->cashDeposit;

        $bankAccount->save();

    }

    public function updateBankAccountOfDealer($bankAccount, $request){

        //$bankAccount->entity_id = $dealerID;
        //$bankAccount->entity_type = "Dealer";
        $bankAccount->IBAN = $request->IBAN;
        $bankAccount->cash_deposit = $request->cashDeposit;

        $bankAccount->save();

    }
}
