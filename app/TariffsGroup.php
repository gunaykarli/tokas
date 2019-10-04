<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffsGroup extends Model
{
    protected $guarded = [];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function tariffs(){
        return $this->hasMany(Tariff::class);
    }

    /** Control the status of the group, and alter if it is necessary
     * forwarded form TariffController@changeStatusOfTariff
     */
    // After changing the status of the tariff, status of the group which the tariff whose status has been changed, belongs to should be controlled.
    // After the changing of the status of the tariff from 1 to 0, if all tariffs belonging the group are with disabled status,
    // then the status of the group must be altered from 1 to 0.
    // After the changing of the status of the tariff from 0 to 1, if the group has min one tariff with enabled status,
    // then the status of the group must be altered from 0 to 1.
    public static function controlAndAlterStatusOfGroup($tariffID){


        // determine the group of the tariff whose status has been just changed in TariffController@changeStatusOfTariff.
        $theGroup = TariffsGroup::find(Tariff::find($tariffID)->group_id);

        // check if the status of the group of the tariff whose status has been just changed in TariffController@changeStatusOfTariff, must be altered or not
        // if the group has at least one tariff with enabled status (1), the status of the group must be 1 otherwise it must be 0
        // first, fetch the all tariff belonging to the group with  "$tariffGroupID"
        $tariffs = Tariff::where('group_id', $theGroup->id)->get();
        $theNumberOfTariffWithStatus1 = 0;
        foreach($tariffs as $tariff){
            if($tariff->status == 1){
                $theNumberOfTariffWithStatus1++;
                //break;
            }
        }

        if($theNumberOfTariffWithStatus1 > 0) // the group has at least one tariff with enabled status (1)
            $theGroup->status = 1;
        else
            $theGroup->status = 0;

        $theGroup->save();
    }

    /** forwarded from app/Tariff.php setBasicInfo() and updateBasicInfo()
     * Assigns 1 to the status of the group when the new tariff is created and assigned to the group
     */
    public static function assignOneToStatusOfGroup($tariffGroupID){
        // determine the group of the tariff whose status has will receive 1.
        $theGroup = TariffsGroup::find($tariffGroupID);

        // Assign 1 to the status of the group without checking is the status already 1 or not.
        // Since a new tariff has been assigned to the group in app/Tariff.php setBasicInfo(). The status must be 1 anyway.
        $theGroup->status = 1;
        $theGroup->save();
    }
}
