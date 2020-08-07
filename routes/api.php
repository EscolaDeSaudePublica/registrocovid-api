<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvidprojetosPorCategoriaer within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'Api\JWTAuthController@register');
    Route::post('login', 'Api\JWTAuthController@login');
});

Route::group(['middleware' => ['apiJwt']], function ($router) {
    Route::post('logout', 'Api\JWTAuthController@logout');
    Route::post('refresh', 'Api\JWTAuthController@refresh');
    Route::get('profile', 'Api\JWTAuthController@profile');
});

Route::group(['middleware' => ['apiJwt']], function ($router) {
    Route::namespace('Api')->group(function () {
        Route::namespace('Paciente')->group(function () {
            Route::get('/pacientes', 'PacienteController@index');
            Route::post('/pacientes', 'PacienteController@store');

            Route::group(['middleware' => ['paciente']], function ($router) {
                Route::get('/pacientes/{pacienteId}/historico', 'Historico\HistoricoController@show');
                Route::post('/pacientes/{pacienteId}/historico', 'Historico\HistoricoController@store');

                Route::get('/pacientes/{pacienteId}/comorbidades', 'Comorbidade\ComorbidadeController@show');
                Route::post('/pacientes/{pacienteId}/comorbidades', 'Comorbidade\ComorbidadeController@store');

                Route::post('/pacientes/{pacienteId}/identificacao', 'IdentificacaoPacienteController@store');
                Route::get('/pacientes/{pacienteId}/identificacao', 'IdentificacaoPacienteController@index');

                Route::post('/pacientes/{pacienteId}/exames-laboratoriais', 'ExamesLaboratoriais\ExamesLaboratoriaisController@store');
                Route::get('/pacientes/{pacienteId}/exames-laboratoriais', 'ExamesLaboratoriais\ExamesLaboratoriaisController@index');
            });
        });

        Route::get('/estados', 'EstadoController@index');
        Route::get('/municipios', 'MunicipioController@index');
        Route::get('/instituicoes', 'InstituicaoController@index');
        Route::get('/suportes-respiratorios', 'SuporteRespiratorioController@index');
        Route::get('/drogas', 'DrogaController@index');
        Route::post('/drogas', 'DrogaController@store');
        Route::get('/situacao-uso-drogas', 'SituacaoUsoDrogasController@index');
        Route::get('/doencas', 'DoencaController@index');
        Route::get('/orgaos', 'OrgaoController@index');
        Route::get('/corticosteroides', 'CorticosteroideController@index');
        Route::get('/sitios-rt-pcr', 'TipoSitiosController@index');
        Route::get('/pcr-resultado', 'ResultadoPcrController@index');
    });
});
