<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = ['name', 'type', 'status', 'category_id', 'owner_surname', 'owner_name', 'owner_mobile', 'owner_email'];

    public function offices(){
        return $this->hasMany(Office::class);
    }

    public function address(){
        return $this->hasOne(Address::class, 'entity_id');
    }

    public function dealersMemberCode(){
        return $this->hasOne(DealersMemberCode::class);
    }

    public function user(){
        return $this->hasMany(User::class, 'dealer_id');
    }

    public function bankAccount(){
        return $this->hasOne(BankAccount::class,'entity_id');
    }

    public function dealerRegionVB(){
        return  $this->hasOne(DealerRegionVb::class);
    }

}
