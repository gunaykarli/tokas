<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    protected $fillable = ['name', 'country', 'url'];
}
