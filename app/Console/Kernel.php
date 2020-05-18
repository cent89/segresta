<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Storage;

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
      // Backup
      if(config('backup.enable')){
        $schedule->command('backup:clean')->daily()->at('00:00');
        $schedule->command('backup:run')->daily()->at('00:30');
      }

      //Email compleanni
      $schedule->call(function() {
        //invia report presenze alle 8.00 del giorno 3 di ogni mese
        \Modules\User\Http\Controllers\UserController::sendEmailCompleanni();
      })->dailyAt("01:00");

      $schedule->call(function() {
        // Cancella tutti file nella cartella temp
        foreach(Storage::disk('public')->allDirectories('attachments') as $dir){
          $files = Storage::disk('public')->allFiles($dir);
          Storage::disk('public')->delete($files);
        }

        // Cancella tutti file nella cartella atachments
        foreach(Storage::disk('public')->allDirectories('temp') as $dir){
          $files = Storage::disk('public')->allFiles($dir);
          Storage::disk('public')->delete($files);
        }

      })->dailyAt('23:00');

      $schedule->call(function() {
        // Cancello i vecchi audits
        \App\Audit::where('created_at', '<', Carbon::now()->subDays(7)->toDateTimeString())->delete();

      })->dailyAt('22:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
