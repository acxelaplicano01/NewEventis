<?php

use App\Livewire\Conferencia\Conferencias;
use App\Livewire\Conferencista\Conferencistas;
use App\Livewire\Conferencista\Perfilconferencista;
use App\Livewire\Evento\Eventos;
use App\Livewire\Gafete\Gafetes;
use App\Livewire\Inicio\InicioAdmin;
use App\Livewire\Localidad\Localidades;
use App\Livewire\Modalidad\Modalidades;
use App\Livewire\Nacionalidad\Nacionalidades;
use App\Livewire\ReciboPago\ComprobacionPago;
use App\Livewire\ReciboPago\ReciboPagos;
use App\Livewire\ReporteEvento\ReporteEventos;
use App\Livewire\VistaConferencia\VistasConferencias;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\ModuleRedirectController;
use App\Http\Middleware\CheckModuleAccess;
use App\Livewire\Admin\SessionManager;
use App\Livewire\Rol\Roles;
use App\Livewire\Rol\RoleForm;
use App\Livewire\Usuario\Usuarios;
use App\Livewire\Muro\Muros;
use App\Livewire\EventoVista\EventosVistas;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/muro/{userperfil}', Muros::class)->name('muro');
Route::get('/eventoVista', EventosVistas::class)->name('eventoVista');

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
    Route::get('/dashboard', InicioAdmin::class)->name('dashboard');

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

    // Rutas del módulo de eventos
    Route::middleware(['auth', CheckModuleAccess::class . ':eventos'])->group(function () {

        Route::get('/eventos/create', Eventos::class)
            ->name('eventos')
            ->middleware('can:eventos.create.crear');
        
        Route::get('/evento/{evento?}/reporteEvento', ReporteEventos::class)
            ->name('reporteEvento')
            ->middleware('can:eventos.reporte.ver');

        Route::get('/conferencia/{evento?}', Conferencias::class)
            ->name('conferencias')
            ->middleware('can:eventos.conferencias.ver');

        Route::get('/evento/{evento?}/reporteEvento', ReporteEventos::class)
            ->name('reporteEvento')
            ->middleware('can:eventos.reporte.ver');

        Route::get('/inscripcion-evento/{evento?}', ComprobacionPago::class)
            ->name('inscripcion-evento')
            ->middleware('can:eventos.inscripcion.ver');
        
        Route::get('/recibo/{evento?}', ReciboPagos::class)
            ->name('recibo')
            ->middleware('can:eventos.recibo.ver');
        
        Route::get('/gafete/{evento?}', Gafetes::class)
            ->name('gafete')
            ->middleware('can:eventos.gafete.ver');

        Route::get('/eventos/{evento?}/conferencias', VistasConferencias::class)
            ->name('subir-comprobante')
            ->middleware('can:eventos.conferencias.ver');

        Route::get('/eventoVista', EventosVistas::class)
            ->name('eventoVista')
            ->middleware('can:eventos.eventovista.ver');
        
        Route::get('/conferencista', Conferencistas::class)
            ->name('conferencista')
            ->middleware('can:eventos.conferencista.ver');
        
        Route::get('/perfilconferencista', Perfilconferencista::class)
            ->name('perfilconferencista')
            ->middleware('can:eventos.perfilconferencista.ver');

        Route::get('/evento/{evento?}/conferencias', VistasConferencias::class)
            ->name('vistaconferencia')
            ->middleware('can:eventos.vistaconferencia.ver');
    });

    // Rutas del módulo mantenimiento
    Route::middleware(['auth', CheckModuleAccess::class . ':mantenimiento'])->group(function () {

        Route::get('/modalidades/ver', Modalidades::class)
            ->name('modalidades')
            ->middleware('can:mantenimiento.modalidades.ver');

        Route::get('/nacionalidades/ver', Nacionalidades::class )
            ->name('nacionalidades')
            ->middleware('can:mantenimiento.nacionalidades.ver');

        Route::get('/localidades/ver', Localidades::class )
            ->name('localidades')
            ->middleware('can:mantenimiento.localidades.ver');

    });

});
