<?php

namespace App\Livewire\Diploma;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Diploma;
use App\Models\Conferencia;
use App\Models\Firma;
use App\Models\Evento;
use Illuminate\Support\Str;

class Diplomas extends Component
{
    use WithPagination, WithFileUploads;

    public// $Codigo,
    $Plantilla,
    $diploma_id,
    $Nombre,
    $search;

    public $isOpen = false;
    public $confirmingDelete = false;
    public $inputSearchConferencia = '';
    public $searchConferencias = [];
    public $IdAEliminar;
    public $inputSearchFirma = '';
    public $searchFirmas = [];


    // public $searchPersonas = [];

    public $inputSearchEvento = '';
    public $searchEventos = [];

    protected $rules = [
        // 'Codigo' => 'required',
        'Plantilla' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'Nombre' => 'required',
    ];

    public function mount()
    {
        //   $this->conferencias = Conferencia::all();
    }

    public function render()
    {
        $diplomas = Diploma::where('Nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        // dd($diplomas);
        return view('livewire.Diploma.diplomas', [
            'diplomas' => $diplomas,
            //  'conferencias' => $this->conferencias,
        ]);
    }

    public function updatedInputSearchEvento()
    {
        $query = Evento::query();

        // Busca por nombre del evento si se proporciona
        if (!empty($this->inputSearchEvento)) {
            $query->where('nombreevento', 'like', '%' . $this->inputSearchEvento . '%');
        }

        // Busca por IdEvento si se proporciona
        if (!empty($this->IdEvento)) {
            $query->where('id', $this->IdEvento);
        }

        $this->searchEventos = $query->get();
    }

    public function selectEvento($eventoId)
    {
        $this->IdEvento = $eventoId;
        $evento = Evento::find($eventoId);
        $this->inputSearchEvento = $evento->nombreevento;
        $this->searchEventos = [];
    }


    /* public function updatedInputSearchConferencia()
     {
         $this->searchConferencias = Conferencia::where('nombre', 'like', '%' . $this->inputSearchConferencia . '%')
             ->get();
     }
 */


    /*  public function selectConferencia($conferenciaId)
      {
          $this->IdConferencia = $conferenciaId;
          $conferencia = Conferencia::find($conferenciaId);
          $this->inputSearchConferencia = $conferencia->nombre;
          $this->searchConferencias = [];
      }*/

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->Plantilla = '';
        $this->Nombre = '';
        $this->diploma_id = null;
        //  $this->inputSearchConferencia = '';
        //   $this->searchConferencias = [];

    }

    public function store()
    {
        $this->validate();

        // Guardar la plantilla en el storage
        if ($this->Plantilla) {
            $this->Plantilla = $this->Plantilla->store('plantillas', 'public');
        } elseif ($this->diploma_id) {
            $diploma = Diploma::findOrFail($this->diploma_id);
            $this->Plantilla = $diploma->Plantilla;
        } else {
            $this->Plantilla = null;
        }

       
        // Actualizar o crear el diploma
        Diploma::updateOrCreate(['id' => $this->diploma_id], [
            'Codigo' => $this->generateUniqueCode(),
            'Plantilla' => $this->Plantilla ? str_replace('public/', 'storage/', $this->Plantilla) : null,
            'Nombre' => $this->Nombre,
        ]);

        session()->flash('message', $this->diploma_id ? 'Diploma actualizado correctamente!' : 'Diploma creado correctamente!');

        $this->closeModal();
        $this->resetInputFields();
    }


    protected function generateUniqueCode()
    {
        do {
            $code = Str::uuid();
        } while (Diploma::where('codigo', $code)->exists());

        return $code;
    }

    public function edit($id)
    {
        $diploma = Diploma::findOrFail($id);
        $this->diploma_id = $id;
        $this->Nombre = $diploma->Nombre;
        $this->Plantilla = $diploma->Plantilla;
        $this->openModal();
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $diploma = Diploma::find($this->IdAEliminar);

            if (!$diploma) {
                session()->flash('error', 'Diploma no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $diploma->forceDelete();
            session()->flash('message', 'Diploma eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $diploma = Diploma::find($id);

        if (!$diploma) {
            session()->flash('error', 'Plantilla no encontrado.');
            return;
        }
        if ($diploma->evento()->exists()) {
            session()->flash('error', 'No se puede eliminar esta plantilla porque está enlazada a uno o más eventos.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->confirmingDelete = true;
    }
}