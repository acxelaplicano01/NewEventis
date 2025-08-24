<?php

namespace App\Livewire\HistorialConferencia;

use Livewire\Component;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Auth;
use App\Models\DiplomaGenerado;
use Illuminate\Support\Str;
use App\Services\QRCodeService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class HistorialConferencias extends Component
{
    use WithFileUploads;

    public $asistencia;
    public $uuidDiploma;
    public $conferencias = [];
    public $search = '';
    public $diploma;
    public $qrcode;
    public $user;
    public $conferencia;
    public $evento;

    public function mount()
    {
        $this->loadConferencias();
    }

    // validar que la persona este inscrita en la conferencia
    // y ademas que la persona haya asistido a la conferencia
    public function validacionesPersonaConferencia()
    {
        return true;
    }

    public function loadConferencias()
    {
        $userId = Auth::user()->id;

        $suscripciones = Asistencia::where('asistencia', 1)
            ->whereHas('suscripcion', function ($query) use ($userId) {
                $query->where('IdUser', $userId);
            })
            ->with('suscripcion.conferencia.evento', 'suscripcion.conferencia.conferencista.user')
            ->get()
            ->map(function ($asistencia) {
                return [
                    'asistencia_id' => $asistencia->id,
                    'conferencia' => $asistencia->suscripcion->conferencia
                ];
            })
            ->unique('conferencia.id');

        $this->conferencias = $suscripciones;
    }

    public function descargarDiploma($IdAsistencia)
    {
        // Buscar la asistencia correspondiente al IdAsistencia
        $asistencia = Asistencia::find($IdAsistencia);

        if (!$asistencia) {
            // Manejar el caso en que no se encuentre la asistencia
            session()->flash('error', 'No se encontró la asistencia correspondiente al IdAsistencia');
            return;
        }

        // Buscar la entrada en la tabla DiplomaGenerado
        $diplomaGenerado = DiplomaGenerado::where('IdAsistencia', $IdAsistencia)->first();

        if (!$diplomaGenerado) {
            // Manejar el caso en que no se encuentre el diploma generado
            session()->flash('error', 'No se encontró el diploma generado correspondiente al IdAsistencia');
            return;
        }

        $uuidDiploma = $diplomaGenerado->uuid;

        // Generar el código QR
        $qrcode = QRCodeService::generateTextQRCode(
            config('app.url') . '/validarDiploma/' . $uuidDiploma
        );

        // Generar el PDF del diploma
        $pdf = PDF::loadView('livewire.descargarDiploma', [
            'Nombre' => $asistencia->suscripcion->user->nombre,
            'Apellido' => $asistencia->suscripcion->user->apellido,
            'Conferencia' => $asistencia->suscripcion->conferencia->nombre,
            'Conferencista' => $asistencia->suscripcion->conferencia->conferencista->user->nombre . ' ' . $asistencia->suscripcion->conferencia->conferencista->user->apellido,
            'TituloConferencista' => $asistencia->suscripcion->conferencia->conferencista->titulo,
            'FirmaConferencista' =>  $asistencia->suscripcion->conferencia->conferencista->firma,
            'SelloConferencista' =>  $asistencia->suscripcion->conferencia->conferencista->sello,
            'FechaConferencia' => $asistencia->suscripcion->conferencia->fecha,
            'Evento' => $asistencia->suscripcion->conferencia->evento->nombreevento,
            'NombreFirma1' => $asistencia->suscripcion->conferencia->evento->diploma->NombreFirma1,
            'NombreFirma2' => $asistencia->suscripcion->conferencia->evento->diploma->NombreFirma2,
            'Titulo1' => $asistencia->suscripcion->conferencia->evento->diploma->Titulo1,
            'Titulo2' => $asistencia->suscripcion->conferencia->evento->diploma->Titulo2,
            'Plantilla' => $asistencia->suscripcion->conferencia->evento->diploma->Plantilla,
            'Firma1' => $asistencia->suscripcion->conferencia->evento->diploma->Firma1,
            'Firma2' => $asistencia->suscripcion->conferencia->evento->diploma->Firma2,
            'Sello1' => $asistencia->suscripcion->conferencia->evento->diploma->Sello1,
            'Sello2' => $asistencia->suscripcion->conferencia->evento->diploma->Sello2,
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
            $asistencia->suscripcion->user->nombre,
            $asistencia->suscripcion->user->apellido,
            $uuidDiploma
        );
        Storage::put($pdfPath, $pdf->output());

        // Descargar el PDF
        return response()->download(storage_path('app/' . $pdfPath))->deleteFileAfterSend(true);
    }

    public function render()
    {

        $conferencias = collect($this->conferencias)->filter(function ($item) {
            return str_contains(strtolower($item['conferencia']->nombre), strtolower($this->search)) ||
                str_contains(strtolower($item['conferencia']->evento->nombreevento), strtolower($this->search)) ||
                str_contains(strtolower($item['conferencia']->conferencista->user->nombre), strtolower($this->search)) ||
                str_contains(strtolower($item['conferencia']->conferencista->user->apellido), strtolower($this->search));
        });
        return view('livewire.HistorialConferencia.historial-conferencias', [
            'conferencias' => $this->conferencias,
        ]);
    }
}