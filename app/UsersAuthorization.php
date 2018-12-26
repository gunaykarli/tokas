<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersAuthorization extends Model
{
    protected $fillable = ['system_feature_id', 'user_id'];

    public function systemFeatures(){

        return $this->hasMany(SystemFeature::class);
    }
}
