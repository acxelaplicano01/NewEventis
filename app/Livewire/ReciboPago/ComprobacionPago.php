<?php

namespace App\Livewire\ReciboPago;

use App\Models\Inscripcion;
use Illuminate\Support\Facades\Storage;
use App\Services\QRCodeService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use Carbon\Carbon;
use App\Models\DiplomaEvento;
use Livewire\Component;
use Livewire\WithPagination;
use App\Notifications\ComprobanteRechazado;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Notification;

class ComprobacionPago extends Component
{
    use WithPagination;

    public $search = '';
    public $evento_id;
    public $modalOpen = false;
    public $modalMessage = '';

    public $confirmingDelete = false;
    public $IdAEliminar;
    public $nombreAEliminar;

    protected $paginationTheme = 'tailwind';

    public function mount($evento = null)
    {
        if ($evento) {
            $this->evento_id = $evento;
        } else {
            session()->flash('error', 'Evento no encontrado.');
            return redirect()->route('eventos.index');
        }
    }

    public function marcarComprobado($inscripcionId)
    {
        // Actualizar el estado de la inscripción
        Inscripcion::where('id', $inscripcionId)->update(['Status' => 'Inscrito']);

        DiplomaEvento::updateOrCreate(
            ['inscripcionId' => $inscripcionId],
            ['uuid' => Str::uuid()]
        );
        // Mensaje de éxito
        session()->flash('message', 'Comprobante Validado.');
        $this->modalOpen = true;
    }

    public function rechazarComprobacion($inscripcionId)
    {
        Inscripcion::where('id', $inscripcionId)->update(['Status' => 'Rechazado']);
        session()->flash('message', 'Comprobación rechazada correctamente.');
        $this->modalOpen = true;
        $this->confirmingDelete = false;
    }

    public function marcarTodos($status)
    {
        $inscripciones = Inscripcion::where('IdEvento', $this->evento_id)->get();

        if ($inscripciones->isEmpty()) {
            $this->modalMessage = 'No hay inscripciones para comprobar.';
            $this->modalOpen = true;
            return;
        }

        foreach ($inscripciones as $inscripcion) {
            // Actualizar el estado de la inscripción
            Inscripcion::where('id', $inscripcion->id)->update(['Status' => $status]);

            // Crear o actualizar el diploma para cada inscripción
            DiplomaEvento::updateOrCreate(
                ['inscripcionId' => $inscripcion->id],
                ['uuid' => Str::uuid()]
            );
        }

        $this->modalMessage = 'Todas las comprobaciones fueron marcadas como ' . $status . ' y los diplomas fueron creados.';
        $this->modalOpen = true;
    }

    //funcion para descargar los diplomas por personas inscritas al evento
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
            'FechaInicio' => $inscripcion->evento->fechainicio,
            'Organizador' => $inscripcion->evento->organizador,
            'Evento' => $inscripcion->evento->nombreevento,
            'NombreFirma1' => $inscripcion->evento->diploma->NombreFirma1,
            'NombreFirma2' => $inscripcion->evento->diploma->NombreFirma2,
            'Titulo1' => $inscripcion->evento->diploma->Titulo1,
            'Titulo2' => $inscripcion->evento->diploma->Titulo2,
            'Plantilla' => $inscripcion->evento->diploma->Plantilla,
            'Firma1' => $inscripcion->evento->diploma->Firma1,
            'Firma2' => $inscripcion->evento->diploma->Firma2,
            'Sello1' => $inscripcion->evento->diploma->Sello1,
            'Sello2' => $inscripcion->evento->diploma->Sello2,
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



    public function descargarDiplomas($eventoId)
    {
        // Obtener las personas con estatus aceptado para el evento específico
        $eventopersona = Inscripcion::where('Status', 'Inscrito')
            ->where('IdEvento', $eventoId)
            ->get();
        // Crear un array para almacenar los PDFs individuales
        $pdfs = [];
        foreach ($eventopersona as $inscripcion) {
            // Obtener el UUID del diploma generado
            $diplomaEvento = DiplomaEvento::where('id', $inscripcion->id)->first();

            if (!$diplomaEvento) {
                continue; // Saltar si no se encuentra el diploma generado
            }

            $uuidDiploma = $diplomaEvento->uuid;

            // Generar el código QR
            $qrcode = QRCodeService::generateTextQRCode(
                config('app.url') . '/validarDiplomaEvento/' . $uuidDiploma
            );

            // Generar el HTML del diploma
            $data = [
                'Nombre' => $inscripcion->user->nombre,
                'Apellido' => $inscripcion->user->apellido,
                'FechaInicio' => $inscripcion->evento->fechainicio,
                'Organizador' => $inscripcion->evento->organizador,
                'Evento' => $inscripcion->evento->nombreevento,
                'NombreFirma1' => $inscripcion->evento->diploma->NombreFirma1,
                'NombreFirma2' => $inscripcion->evento->diploma->NombreFirma2,
                'Titulo1' => $inscripcion->evento->diploma->Titulo1,
                'Titulo2' => $inscripcion->evento->diploma->Titulo2,
                'Plantilla' => $inscripcion->evento->diploma->Plantilla,
                'Firma1' => $inscripcion->evento->diploma->Firma1,
                'Firma2' => $inscripcion->evento->diploma->Firma2,
                'Sello1' => $inscripcion->evento->diploma->Sello1,
                'Sello2' => $inscripcion->evento->diploma->Sello2,
                'uuid' => $uuidDiploma,
                'qrcode' => $qrcode,
            ];

            $pdf = PDF::loadView('livewire.diploma-evento', $data)->setPaper('a4', 'landscape');
            $pdfs[] = $pdf->output();
        }

        // Combinar todos los PDFs en uno solo usando FPDI
        $combinedPdf = new Fpdi();
        foreach ($pdfs as $pdf) {
            $pageCount = $combinedPdf->setSourceFile(StreamReader::createByString($pdf));
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $combinedPdf->importPage($pageNo);
                $size = $combinedPdf->getTemplateSize($templateId);
                $combinedPdf->AddPage('L', [$size['width'], $size['height']]);
                $combinedPdf->useTemplate($templateId);
            }
        }

        // Generar el contenido del PDF combinado como una cadena
        $tempFilePath = tempnam(sys_get_temp_dir(), 'diplomas') . '.pdf';
        $combinedPdf->Output($tempFilePath, 'F');

        // Descargar el PDF combinado
        return response()->download($tempFilePath, 'Diplomas '. $inscripcion->evento->nombreevento .'.pdf')->deleteFileAfterSend(true);
    }

    public function render()
    {
        $inscripciones = Inscripcion::with(['user', 'evento', 'recibo'])
            ->where('IdEvento', $this->evento_id)
            ->whereHas('user', function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('apellido', 'like', '%' . $this->search . '%')
                    ->orWhere('Status', 'like', '%' . $this->search . '%');
            })
            ->paginate(8);

        return view('livewire.ReciboPagos.comprobacionPago', [
            'inscripciones' => $inscripciones,
            'evento_id' => $this->evento_id,

        ]);
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $inscripcion = Inscripcion::find($this->IdAEliminar);

            if (!$inscripcion) {
                session()->flash('error', 'Incripción no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            // Enviar notificación por correo electrónico
            Notification::route('mail', $inscripcion->user->correo)
                ->notify(new ComprobanteRechazado($inscripcion));


            $inscripcion->forceDelete();
            session()->flash('message', 'Inscripción rechazada! Se ha enviado un correo electrónico a ' . $inscripcion->user->nombre . ' ' . $inscripcion->user->apellido . ' (' . $inscripcion->user->correo . ') notificandole.');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $comprobacion = Inscripcion::find($id);

        if (!$comprobacion) {
            session()->flash('error', 'Incripción no encontrada.');
            $this->confirmingDelete = true;
            return;
        }
        if ($comprobacion->recibo()->exists()) {
            session()->flash('error', 'No se puede rechazar ya este comprobante porque ya se aceptó como válido.');
            $this->confirmingDelete = true;
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $comprobacion->user->nombre . ' ' . $comprobacion->user->apellido;
        $this->confirmingDelete = true;
    }
}