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
      $order = 0;
      foreach(Config::getConfig() as $c){
        $config = Config::find($c['key']);
        if($config == null){
          $config = new Config;
          $c['order'] = $order;
          $config->fill($c);
          $config->save();
          $order++;
        }
      }
    }
}
