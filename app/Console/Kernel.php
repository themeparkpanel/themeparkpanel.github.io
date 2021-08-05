<?php

namespace App\Console;

use App\ChangeEmail;
use App\License;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->call(function () {
            $date = new \DateTime();
            $date->modify('-60 minutes');
            $formatted = $date->format('Y-m-d H:i:s');
            ChangeEmail::where('updated_at', '<=', $formatted)->delete();
        })->hourly();

        $schedule->call(function () {
            DB::delete('DELETE licenses, usages FROM licenses INNER JOIN usages ON licenses.id=usages.license_id WHERE licenses.expires_at<=CURRENT_TIMESTAMP()');
        })->hourly();
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
