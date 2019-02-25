<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $fillable = ['name'];

    public function tariffs(){
        return $this->hasMany(Tariff::class);
    }
}
