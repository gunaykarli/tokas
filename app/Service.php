<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['code', 'name', 'is_favorite', 'provider_id'];

    public function vodafoneTariffs(){
        return $this->belongsToMany(VodafoneTariff::class);
    }
}
