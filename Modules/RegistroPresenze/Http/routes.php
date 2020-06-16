<?php

Route::group(['middleware' => ['web', 'verified'], 'prefix' => 'admin', 'namespace' => 'Modules\RegistroPresenze\Http\Controllers'], function()
{
	Route::resource('registro_presenze', 'RegistroPresenzeController', ['only' => ['index', 'store']]);
	Route::resource('registro_presenze_utente', 'RegistroPresenzeUtenteController', ['only' => ['index', 'store']]);


	// Route::resource('certificazione_utente', 'CertificazioneUtenteController', ['only' => ['index', 'store']]);
	// Route::get('certificazione_utente/compila', ['as' => 'certificazione_utente.compila', 'uses' => 'CertificazioneUtenteController@show_compila']);
	// Route::get('certificazione_utente/{id}/download', ['as' => 'certificazione_utente.download', 'uses' => 'CertificazioneUtenteController@download']);
	// Route::post('certificazione_utente/salva', ['as' => 'certificazione_utente.salva', 'uses' => 'CertificazioneUtenteController@salva']);
});


?>
