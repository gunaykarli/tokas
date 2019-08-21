<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = ['salesperson_id', 'office_id', 'dealer_id', 'product_type', 'product_id', 'additional_tariff'];

    public static function emptyShoppingCart($employeeID){



        // fetch the tariffs belonging to the current employee
        $contents = ShoppingCart
            ::where('product_type', 1)
            ->where('employee_id', $employeeID)
            ->get();

        // forget the related session variables
        foreach ($contents as $content){
            session()->forget(Tariff::where('id', $content->product_id)->first()->name);
        }

        if(session()->exists('VF-Tariff-1')){
            $simImeiServicesFromSession = session()->get( 'VF-Tariff-1');
            echo "-: ".($simImeiServicesFromSession['IMEIOption']);
            dd('Stop');
        }


        // and delete the items from the shopping cart
        foreach ($contents as $content){
            $content->delete();
        }


    }
}
