<?php

use Illuminate\Database\Seeder;
use App\Config;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach(Config::getConfig() as $c){
        $config = Config::find($c['key']);
        if($config == null){
          $config = new Config;
          $config->fill($c);
          $config->save();
        }
      }
    }
}
