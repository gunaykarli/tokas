<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LawText extends Model
{
    protected $guarded = [];

    public function vodafoneTariffs(){
        return $this->belongsToMany(VodafoneTariff::class);
    }
}
