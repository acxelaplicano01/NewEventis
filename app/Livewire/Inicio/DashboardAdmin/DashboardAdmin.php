<?php

namespace App\Livewire\Inicio\DashboardAdmin;

use Livewire\Component;

class DashboardAdmin extends Component
{
    public function render()
    {
        // Obtener eventos y mapearlos para FullCalendar
        $colores = ['#22d3ee', '#10b981', '#f59e42', '#f43f5e', '#6366f1', '#facc15', '#a3e635', '#eab308', '#f472b6', '#818cf8'];
        $eventos = \App\Models\Evento::all()->values()->map(function($evento, $i) use ($colores) {
            return [
                'title' => $evento->nombreevento,
                'start' => $evento->fechainicio,
                'end' => $evento->fechafinal,
                'color' => $colores[$i % count($colores)],
            ];
        });
        return view('livewire.inicio.dashboard-admin.dashboard-admin', [
            'eventos' => $eventos
        ]);
    }
}
