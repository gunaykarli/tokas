<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemFeature extends Model
{
    protected $fillable = ['model', 'action', 'lang_key_for_feature', 'lang_key_for_description' ];


    public function rolesAuthorization(){

        return $this->hasOne(RolesAuthorization::class);
    }

    public function usersAuthorizations(){

        return $this->belongsToMany(UsersAuthorization::class);
    }
}
