<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\Certification;
use App\Notifications\PostPublished;
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
     *k
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $certifications = Certification::where('certification_date_after',Carbon::now()->addDays(2)->toDateString())->get();
            if($certifications)
            {
                foreach($certifications as $certification)
                {
                    $certification->notify(new PostPublished($certification));
                }
            }
        })->dailyAt('23:45');
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
