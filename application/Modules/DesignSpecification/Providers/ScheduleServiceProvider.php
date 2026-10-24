<?php
/** ---------------------------------------------------------------------------------
 * [MODULES]
 * Schedule cronjob tasks
 * @source Nextloop
 *-----------------------------------------------------------------------------------*/
namespace Modules\DesignSpecification\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider {

    public function boot() {

        //after app has booted
        $this->app->booted(function () {

            //start
            $schedule = $this->app->make(Schedule::class);

            //run the email ccronjob to send PDF email of specification
            $schedule->call(new \Modules\DesignSpecification\Cronjobs\EmailCron)->everyMinute();
        });

    }

    public function register() {
    }
}