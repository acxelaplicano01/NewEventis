<?php

namespace App\Http\Controllers;
use App\Models\Inscripcion;
use App\Models\DiplomaEvento;
use App\Models\Asistencia;
use App\Models\DiplomaGenerado;

class ValidarDiplomaController extends Controller
{
    public $user;
    public $conferencia;
    public $codigoDiploma;
    public $asistencia;
    public $evento;
    public $inscripcion;
    public $uuid;

   
    public function validarDiploma($uuid)
    {
        $this->uuid = $uuid;
        $diploma = DiplomaGenerado::where('uuid', $this->uuid)->first();
        if ($diploma) {
            $asistencia = Asistencia::where('id', $diploma->id)->first(); // Acceder al primer elemento de la colección
            if ($asistencia) {
                $this->user = $asistencia->suscripcion->user;
                $this->conferencia = $asistencia->suscripcion->conferencia;
                $this->codigoDiploma = $asistencia->suscripcion->conferencia->evento->diploma;
                $this->asistencia = $diploma;

                return view('livewire.validar-diploma', [
                    'user' => $this->user,
                    'conferencia' => $this->conferencia,
                    'uuid' => $this->uuid,
                    'asistencia' => $this->asistencia,
                ]);
            }
        }
        return view('livewire.validar-diploma', [
            'user' => null,
            'conferencia' => null,
            'uuid' => null,
            'asistencia' => null,
        ]);
    }



    public function validarDiplomaEvento($uuid)
    {
        $this->uuid = $uuid;
        $diploma = DiplomaEvento::where('uuid', $this->uuid)->first();
        if ($diploma) {
            $inscripcion = Inscripcion::where('id', $diploma->id)->first(); // Acceder al primer elemento de la colección
            if ($inscripcion) {
                $this->user = $inscripcion->user;
                $this->evento = $inscripcion->evento;
                $this->codigoDiploma = $inscripcion->evento->diploma;
                
                return view('livewire.validar-diploma-evento', [
                    'user' => $this->user,
                    'evento' => $this->evento,
                    'uuid' => $this->uuid,
                    'inscripcion' => $this->inscripcion,
                ]);
            }
        }
        }
}