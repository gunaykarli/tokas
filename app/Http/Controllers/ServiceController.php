<?php

namespace App\Http\Controllers;

use App\Output;
use App\Service;
use App\Tariff;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    /**
     *
     * To redirect to login page when session timeout
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tariff = Tariff::where('id', 2)->first();
        return view('tariffs.vodafone.serviceTariff', compact('tariff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //** Bu fonksiyon deneme için kullanıldı. Şuan silinebilir.. */
    public function store(Request $request)
    {

        //** Take all representative of selected provider from excel to array */
        if($request->hasFile('vodafoneTariffServiceProperty')) {
            $tariffServicePropertiesInExcel = Excel::load($request->file('vodafoneTariffServiceProperty')->getRealPath());
            $tariffServicePropertiesInArray = $tariffServicePropertiesInExcel->toArray();


            foreach ($tariffServicePropertiesInArray as $key => $row) {

               /*
                $out = new Output();
                $out->output1 = array_key_exists('code', $row). ' * ' . $row['code'];
                $out->output2 = array_key_exists('property', $row). ' * ' . $row['property'];
                //$out->output3 = array_key_exists('isFavorite', $row). '*' . $row['isFavorite'];
                $out->save();
                */

                //** if current service is not inadmissible (x-unzulässig-ausschulüsse )(ok or !) then save it to the ServiceVodafoneTariff table. */
                if($row['property'] != 'X'){
                    $service = Service::where('code', $row['code'])->first();

                    $out1 = new Output();
                    $out1->output1 = $service->id . ' * ' . $service->code;
                    $out1->output2 = array_key_exists('property', $row). ' *in if* ' . $row['property'];
                    $out1->output3 = $request->tariffID . ': vft id';
                    $out1->save();

                    if($row['property'] =='ok'){
                        $propertyValue = 1;
                    }
                    else
                        $propertyValue = 0;

                    if($row['favorite'] == 1)
                        $isFavoriteValue = true;
                    else
                        $isFavoriteValue = false;

                    //$vodafoneTariff->services()->attach($service->id, ['property' => $row['property']]);
                    $service->vodafoneTariffs()->attach(2, ['property' => $propertyValue , 'is_favorite' => $isFavoriteValue]);
                }
            }
            return back()->with('success', 'ok');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
