<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\VodafoneTariff;

class Service extends Model
{
    protected $fillable = ['code', 'name', 'type', 'provider_id'];

    //**  */ Relationships with the other Models (Classes)

    public function vodafoneTariffs(){
        return $this->belongsToMany(VodafoneTariff::class, 'service_vodafonetariff',  'service_id', 'vodafone_tariff_id')
            ->withPivot('property', 'is_favorite')
            ->withTimestamps();
        //** property and is_favorite are extra attributes of the pivot table.*/ */
    }


    /** User defined functions */

    // called from VodafoneTariff@manageCreationProcess
    public function setVodafoneTariffServices($vodafoneTariff, Request $request){

        //** Take all service info of newly created tariff from the excel to an array */
        if($request->hasFile('vodafoneTariffServiceProperty')) {
            $tariffServicePropertiesInExcel = Excel::load($request->file('vodafoneTariffServiceProperty')->getRealPath());
            $tariffServicePropertiesInArray = $tariffServicePropertiesInExcel->toArray();

            foreach ($tariffServicePropertiesInArray as $key => $row) {
                //** if current service is not inadmissible (x-unzulässig-ausschulüsse )(ok or !) then save it to the ServiceVodafoneTariff table. */
                if($row['property'] != 'X' and $row['property'] != 'x'){ // X - unzulässig-ausschulüsse
                    $service = Service::where('code', $row['code'])->first();
                    /** IF THE CURRENT SERVIS in the "ServiceForNewVFTariff" excel table, IS NOT IN THE SERVICE TABLE in the DB, IT MUST BE ADDED TO THE SERVICE TABLE in the DB FIRST. */
                    //** Set value of property and favorite according to the value type in related tables. */
                    if($row['property'] =='!'){ // ! - Pflichtfeld
                        $propertyValue = 1;
                    }
                    else if($row['property'] =='ok' and $row['property'] =='OK') // ok - zulässig
                        $propertyValue = 2;
                    else
                        $propertyValue = 3;

                   //** Excel de isFavorite kolon ismini tanımıyor....camel case tanınmıyor...
                    if($row['favorite'] == 1)
                        $isFavoriteValue = true;
                    else
                        $isFavoriteValue = false;

                    //** save the values to the 'service_vodafonetariff pivot table' */
                    $service->vodafoneTariffs()->attach($vodafoneTariff->id, ['property' => $propertyValue, 'is_favorite' => $isFavoriteValue]);
                }
            }
        }
    }
}
