<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\VodafoneTariff;

class Service extends Model
{
    protected $fillable = ['code', 'name', 'provider_id'];

    //**  */ Relationships with the other Models (Classes)

    public function vodafoneTariffs(){
        return $this->belongsToMany(VodafoneTariff::class, 'service_vodafonetariff',  'service_id', 'vodafone_tariff_id')
            ->withPivot('property', 'is_favorite');
        //** property and is_favorite are extra attributes of the pivot table.*/ */
    }


    //** User defined functions */

    public function setVodafoneTariffServices($vodafoneTariff, Request $request){

        //** Take all service info of newly created tariff from the excel to an array */
        if($request->hasFile('vodafoneTariffServiceProperty')) {
            $tariffServicePropertiesInExcel = Excel::load($request->file('vodafoneTariffServiceProperty')->getRealPath());
            $tariffServicePropertiesInArray = $tariffServicePropertiesInExcel->toArray();

            foreach ($tariffServicePropertiesInArray as $key => $row) {
                //** if current service is not inadmissible (x-unzulässig-ausschulüsse )(ok or !) then save it to the ServiceVodafoneTariff table. */
                if($row['property'] != 'X'){
                    $service = Service::where('code', $row['code'])->first();


                    //** Set value of property and favorite according to the value type in related tables. */
                    if($row['property'] =='ok'){
                        $propertyValue = 1;
                    }
                    else
                        $propertyValue = 0;

                   //** Excel de isFavorite kolon ismini tanımıyor....
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
