<?php

namespace App\Console;

use App\Models\Shop;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use function foo\func;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function (){
            $model = new Shop();
          $data =   $model->query()->from('jh_user_shop as a')
                ->leftJoin('jh_area_rent as b','a.area_id','b.area_id')
                ->leftJoin('jh_warte_electric_rant as c','c.shop_id','b.id')
                ->where(['a.is_del'=>0])
                ->get();
            $returnData  = [];
          if(!empty($data)){
              foreach($data as $value){

              }
          }

        })->monthlyOn(25,'8:00');
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
