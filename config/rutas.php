<?php
// filepath: c:\Users\acxel\Desktop\Desarrollo\Git Repos\POA\config\rutas.php

/*
 * Estructura de Permisos Jerárquica (3 niveles):
 * 
 * 1. Módulo Padre: acceso-{modulo} (ej: acceso-configuracion)
 *    - Permiso principal que controla el acceso general al módulo
 * 
 * 2. Funcionalidad: {modulo}.{funcionalidad} (ej: configuracion.roles)
 *    - Agrupa las acciones relacionadas con una funcionalidad específica
 * 
 * 3. Acciones: {modulo}.{funcionalidad}.{accion} (ej: configuracion.roles.crear)
 *    - Permisos específicos para cada acción (crear, editar, eliminar, ver, etc.)
 * 
 * Propiedades de configuración:
 * - permisos_modulo: Define el permiso padre del módulo completo
 * - permisos: Array de permisos específicos requeridos para acceder a la ruta
 */

return [
    // Módulo de Dashboard/Inicio
    'dashboard' => [
        'titulo' => 'Inicio',
        'icono' => '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />',
        'route' => 'dashboard',
        'items' => [
            [
                'titulo' => 'Panel Principal',
                'route' => 'dashboard',
                'routes' => ['dashboard'],
                'permisos' => [],
                'icono' => '',
                'always_visible' => true,
                'breadcrumb' => true // Indica que este elemento debe aparecer en el breadcrumb
            ]
        ]
    ],

    // Módulo de eventos
    'eventos' => [
        'titulo' => 'Eventos',
        'icono' => '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>',
        'route' => 'eventos',
        'breadcrumb_label' => 'Eventos',
        'permisos_modulo' => 'acceso-eventos', // Permiso padre del módulo
        'items' => [
            [
                'titulo' => 'Crear Eventos',
                'route' => 'eventos',
                'routes' => ['eventos'],
                'permisos' => ['eventos.eventos.ver', 'eventos.eventos.crear'], // Solo permiso de acceso a la página
                'icono' => '',
                'default_route' => true,
                'breadcrumb' => true
            ],
            [
                'titulo' => 'Crear Conferencias',
                'route' => 'conferencias',
                'routes' => ['conferencias'],
                'permisos' => ['eventos.conferencias.ver', 'eventos.conferencias.crear'], // Solo permiso de acceso a la página
                'icono' => '',
                'breadcrumb' => true
            ],
            [
                'titulo' => 'Eventos disponibles',
                'route' => 'eventoVista',
                'routes' => ['eventoVista'],
                'permisos' => ['eventos.eventoVista.ver'], // Solo permiso de acceso a la página
                'icono' => '',
                'breadcrumb' => true
            ],
            [
                'titulo' => 'Comprobantes de pagos',
                'route' => 'inscripcion-evento',
                'routes' => ['inscripcion-evento'],
                'permisos' => ['eventos.inscripcionevento.ver'], // Solo permiso de acceso a la página
                'icono' => '',
                'breadcrumb' => true
            ],


            

        ],
        'footer' => false
    ],

  /*  'conferencistas' => [
        'titulo' => 'Conferencistas',
        'icono' => ' <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z"/>',
        'route' => 'conferencista',
        'items' => [
            [
                'titulo' => 'Conferencistas',
                'route' => 'conferencista',
                'routes' => ['conferencista'],
                'permisos' => ['eventos.conferencista.ver'],
                'icono' => '',
                'default_route' => true,
                'breadcrumb' => true // Indica que este elemento debe aparecer en el breadcrumb
            ]
        ],
        'footer' => false
    ], */


    //modulo de mantenimiento
    'mantenimiento' =>[
        'titulo' => 'Mantenimiento',
        'icono' => '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19V6a1 1 0 0 1 1-1h4.032a1 1 0 0 1 .768.36l1.9 2.28a1 1 0 0 0 .768.36H16a1 1 0 0 1 1 1v1M3 19l3-8h15l-3 8H3Z"/>',
        'route' => 'modalidades',
        'breadcrumb_label' => 'Modalidades',
        'permisos_modulo' => 'acceso-mantenimiento', // Permiso padre del módulo
        'items' => [
            [
                'titulo' => 'Modalidad',
                'route' => 'modalidades',
                'routes' => ['modalidades'],
                'permisos' => ['mantenimiento.modalidades.ver', 'mantenimiento.modalidades.crear'], // Solo permiso de acceso a la página
                'icono' => '',
                'default_route' => true,
                'breadcrumb' => true
            ],
            [
                'titulo' => 'Localidad',
                'route' => 'localidades',
                'routes' => ['localidades'],
                'permisos' => ['mantenimiento.localidades.ver', 'mantenimiento.localidades.crear'], // Solo permiso de acceso a la página
                'icono' => '',
                'breadcrumb' => true
            ],
            [
                'titulo' => 'Nacionalidad',
                'route' => 'nacionalidades',
                'routes' => ['nacionalidades'],
                'permisos' => ['mantenimiento.nacionalidades.ver', 'mantenimiento.nacionalidades.crear'], // Solo permiso de acceso a la página
                'icono' => '',
                'breadcrumb' => true
            ],
        ],
        'footer' => true
    ],

    // Módulo de configuración
    'configuracion' => [
        'titulo' => 'Configuración',
        'icono' => '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" /><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />',
        'route' => 'roles',
        'breadcrumb_label' => 'Configuración',
        'permisos_modulo' => 'acceso-configuracion', // Permiso padre del módulo
        'items' => [
            [
                'titulo' => 'Roles',
                'route' => 'roles',
                'routes' => ['roles'],
                'permisos' => ['configuracion.roles.ver', 'configuracion.roles.crear'], // Solo permiso de acceso a la página
                'icono' => '',
                'default_route' => true,
                'breadcrumb' => true
            ],
            [
                'titulo' => 'Usuarios',
                'route' => 'usuarios',
                'routes' => ['usuarios'],
                'permisos' => ['configuracion.usuarios.ver', 'configuracion.usuarios.crear'], // Solo permiso de acceso a la página
                'icono' => '',
                'breadcrumb' => true
            ],
        ],
        'footer' => true
    ],

    'logs' => [
        'titulo' => 'Registros del Sistema',
        'icono' => '<path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4"/>',
        'route' => 'logs',
        'breadcrumb_label' => 'Registros del Sistema',
        'permisos_modulo' => 'acceso-logs', // Permiso padre del módulo
        'items' => [
            [
                'titulo' => 'Visor de Logs',
                'route' => 'logs',
                'routes' => ['logs'],
                'permisos' => ['logs.visor.ver'],
                'icono' => '',
                'breadcrumb' => true
            ],
            [
                'titulo' => 'Dashboard de Logs',
                'route' => 'logsdashboard',
                'routes' => ['logsdashboard'],
                'permisos' => ['logs.dashboard.ver'],
                'icono' => '',
                'breadcrumb' => true,
            ],
            [
                'titulo' => 'Sesiones',
                'route' => 'sessions',
                'routes' => ['sessions'],
                'permisos' => ['logs.sessions.ver'],
                'icono' => '',
                'breadcrumb' => true,
                //'parent_breadcrumb' => 'logs'
            ]
        ],
        'footer' => true
    ],
];