<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use Carbon\Carbon;

class LogClear extends Command
{
  private $days = 3;
  /**
  * The name and signature of the console command.
  *
  * @var string
  */
  protected $signature = 'log:clear';

  /**
  * The console command description.
  *
  * @var string
  */
  protected $description = 'Cancella i log più vecchi di N giorni';

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
    // Cancello il file laravel.log
    Storage::disk('log')->delete('laravel.log');

    // Cancello tutto tranne i log degli ultimi N giorni
    foreach(Storage::disk('log')->files() as $file){
      try{
        $name = explode("-", $file);
        $data = $name[1]."-".$name[2]."-".explode(".", $name[3])[0];
        $data = Carbon::parse($data);
        if($data->lte(Carbon::now()->subDay($this->days))){
          Storage::disk('log')->delete($file);
        }
      }catch(\Exception $e){

      }
    }
  }
}
