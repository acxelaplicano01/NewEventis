<?php

namespace App\Livewire\HistorialEvento;

use App\Models\DiplomaEvento;
use App\Models\Evento;
use Livewire\Component;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Auth;
use App\Models\DiplomaGenerado;
use Illuminate\Support\Str;
use App\Services\QRCodeService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class HistorialEventos extends Component
{
    use WithFileUploads;

    public $inscripcion;
    public $uuidDiploma;
    public $eventos = [];
    public $search = '';

    public $confirmingDelete = false;
    

    public function mount()
    {
        $this->loadEventos();
    }

    // validar que la persona este inscrita en la conferencia
    // y ademas que la persona haya asistido a la conferencia
    public function validacionesPersonaConferencia()
    {
        return true;
    }
    public function loadEventos()
    {
        $userId = Auth::user()->id;
    
        $inscripciones = Inscripcion::whereHas('evento', function ($query) use ($userId) {
                $query->where('IdUser', $userId);
            })
            ->with('evento')
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'inscripcion_id' => $inscripcion->id,
                    'evento' => $inscripcion->evento,
                ];
            })
            ->unique('evento.id');
    
        $this->eventos = $inscripciones;
    }

    public function descargarDiploma($inscripcionId)
    {
        Carbon::setLocale('es');
        // Buscar la inscripcion correspondiente al Idinscripcion
        $inscripcion = Inscripcion::find($inscripcionId);

        if (!$inscripcion) {
            // Manejar el caso en que no se encuentre la inscripcion
            session()->flash('error', 'No se encontró la inscripcion correspondiente al evento');
            $this->confirmingDelete = true;
            return;
        }

        // Buscar la entrada en la tabla DiplomaGenerado
        $diplomaEvento = DiplomaEvento::where('inscripcionId', $inscripcionId)->first();

        if (!$diplomaEvento) {
            // Manejar el caso en que no se encuentre el diploma generado
            session()->flash('error', 'No se encontró el diploma generado correspondiente a la inscripcion');
            $this->confirmingDelete = true;
            return;
        }

        $uuidDiploma = $diplomaEvento->uuid;

        // Generar el código QR
        $qrcode = QRCodeService::generateTextQRCode(
            config('app.url') . '/validarDiplomaEvento/' . $uuidDiploma
        );

        // Generar el PDF del diploma
        $pdf = PDF::loadView('livewire.diploma-evento', [
            'Nombre' => $inscripcion->user->nombre,
            'Apellido' => $inscripcion->user->apellido,
            'Plantilla' => $inscripcion->evento->diploma->Plantilla,
            'uuid' => $uuidDiploma,
            'qrcode' => $qrcode,
        ])->setPaper('a4', 'landscape');

        // Configurar opciones adicionales para evitar distorsiones y asegurar color
        $dompdf = $pdf->getDomPDF();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->set_option('isFontSubsettingEnabled', true);
        $dompdf->set_option('isCssFloatEnabled', true);

        // Guardar el PDF temporalmente
        $pdfPath = sprintf(
            'diplomas/Diploma_%s%s_%s.pdf',
            $inscripcion->user->nombre,
            $inscripcion->user->apellido,
            $uuidDiploma
        );
        Storage::put($pdfPath, $pdf->output());

        // Descargar el PDF
        return response()->download(storage_path('app/' . $pdfPath))->deleteFileAfterSend(true);
    }

    public function render()
{
    $eventos = collect($this->eventos)->filter(function ($item) {
        return str_contains(strtolower($item['evento']->nombreevento), strtolower($this->search)) ||
            str_contains(strtolower($item['evento']->id), strtolower($this->search)) ||
            str_contains(strtolower($item['evento']->organizador), strtolower($this->search)) ||
            str_contains(strtolower($item['evento']->modalidad->modalidad), strtolower($this->search)) ||
            str_contains(strtolower($item['evento']->fechainicio), strtolower($this->search)) ||
            str_contains(strtolower($item['evento']->estado), strtolower($this->search));
    });

    return view('livewire.HistorialEvento.historial-eventos', [
        'eventos' => $eventos,
    ]);
}
}