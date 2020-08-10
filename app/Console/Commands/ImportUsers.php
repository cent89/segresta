<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Schema;
use Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

use App\User;
use Carbon\Carbon;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'import:users';

     /**
     * The console command description.
     *
     * @var string
     */
     protected $description = 'Importa gli utenti da file xlsx';

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
      $this->output->title('Starting import');
      $starting = Carbon::now();
      set_time_limit(0);
      Excel::import(new UsersImport, "users.xlsx", 'public');

      $tempo_importazione = Carbon::now()->diffInMinutes($starting);
      $this->info("Tempo totale per l'importazione: ".$tempo_importazione." minuti");

      $this->output->success('Import successful');
    }
}
