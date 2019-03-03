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

    public function dealerRegionVBs(){
        return  $this->hasMany(DealerRegionVb::class);
    }

    public function tariffs(){
        return $this->belongsToMany(Tariff::class, 'ontop')->withPivot('office_id', 'amount')->withTimestamps();
        //** In naming pivot table, Eloquent will join the two related model names  in alphabetical order . However, you are free to override this convention.
        // Normally the name of the pivot table is 'dealer_tariff'. We have overrided this convention by giving 'ontop'
        // additionally 'office_id', 'amount' are extra attributes of the pivot table.*/
    }
}
