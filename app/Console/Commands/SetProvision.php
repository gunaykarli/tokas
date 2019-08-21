<?php

namespace App\Console\Commands;

use App\Output;
use App\Tariff;
use App\TariffsProvision;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetProvision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provision:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the provisions of the tariffs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //** Take the provisions whose status is 2 in "tariffs_provisions" table.
        // 2 indicates that the provision will be updated in specific date that valid_from field shows.*/
        $tariffsProvisions = TariffsProvision::where('status', 2)->get();


        //** Control the valid_from fields. If it is today, than change the status from 2 to 1 and
        // update the "provision" and "base_price" fields in "tariff" table according to the values of "provision" and "base_price" fields of "tariffs_provisions" table
        foreach($tariffsProvisions as $tariffsProvision){
            //$output->output = $tariffsProvision->valid_from; $output->save();

            //$validFrom = $tariffsProvision->valid_from->toDateTimeString();
            if(Carbon::now()->diffInDays($tariffsProvision->valid_from) == 0){ //$validFrom->equalTo(Carbon::today()->toDateTimeString())
                $tariffsProvision->status = 1; $tariffsProvision->save();

                $tariff = Tariff::where('id', $tariffsProvision->tariff_id)->first();
                $tariff->provision = $tariffsProvision->provision;
                $tariff->base_price = $tariffsProvision->base_price;
                $tariff->save();
            }
        }
    }
}
