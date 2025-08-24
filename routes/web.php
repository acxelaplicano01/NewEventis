<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\ModuleRedirectController;
use App\Http\Middleware\CheckModuleAccess;
use App\Livewire\Admin\SessionManager;
use App\Livewire\Rol\Roles;
use App\Livewire\Rol\RoleForm;
use App\Livewire\Usuario\Usuarios;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/error/404', 'errors.404')->name('error.404');
Route::view('/error/500', 'errors.500')->name('error.500');
Route::view('/error/403', 'errors.403')->name('error.403');


Route::get('/modulo/{module}', [ModuleRedirectController::class, 'redirectToModule'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('module.redirect');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Ruta para el dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); })
        ->name('dashboard');

    // Rutas del módulo de configuración
    Route::middleware(['auth', CheckModuleAccess::class . ':configuracion'])->group(function () {

        Route::get('/configuracion/roles', Roles::class)
            ->name('roles')
            ->middleware('can:configuracion.roles.ver');

        Route::get('/configuracion/roles/crear', RoleForm::class)
            ->name('roles.create')
            ->middleware('can:configuracion.roles.crear');

        Route::get('/configuracion/roles/{roleId}/editar', RoleForm::class)
            ->name('roles.edit')
            ->middleware('can:configuracion.roles.editar');

        Route::get('/configuracion/usuarios', Usuarios::class)
            ->name('usuarios')
            ->middleware('can:configuracion.usuarios.ver');
    });

    // Rutas para el visor de logs
    Route::middleware(['auth', CheckModuleAccess::class . ':logs'])->group(function () {
        Route::get('/logs', [LogViewerController::class, 'index'])
            ->name('logs')
            ->middleware('can:logs.visor.ver');

        Route::get('/logs/dashboard', [LogViewerController::class, 'dashboard'])
            ->name('logsdashboard')
            ->middleware('can:logs.dashboard.ver');

        Route::get('/logs/sessions', SessionManager::class)
            ->name('sessions')
            ->middleware('can:logs.sessions.ver');

        Route::get('/logs/{log}', [LogViewerController::class, 'show'])
            ->name('logs.show')
            ->middleware('can:logs.visor.ver');

        Route::post('/logs/cleanup', [LogViewerController::class, 'cleanup'])
            ->name('cleanup')
            ->middleware('can:logs.mantenimiento.limpiar');
    });

});
