<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Menu;
use Carbon\Carbon;
use App\Config;

class AppServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap any application services.
  *
  * @return void
  */
  public function boot()
  {
    //creo il menu prima che tutto venga inizializzato
    //così ogni modulo, nel boot, pò aggiungere la sua voce.

    Schema::defaultStringLength(191);
    Carbon::setLocale('it');
    setlocale(LC_TIME, 'it_IT');

    foreach(Config::all() as $c){
      config()->set($c->config, $c->value);
    }

    // config([
    //   'global' => Config::all(['key','value'])
    //   ->keyBy('key') // key every setting by its name
    //   ->transform(function ($setting) {
    //     return $setting->value; // return only the value
    //   })
    //   ->toArray() // make it an array
    // ]);

    Menu::make('SegrestaNavBar', function($menu){});

    }

    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
      //
    }
  }
