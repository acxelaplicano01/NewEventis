<?php

namespace App\Livewire\Modalidad;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Modalidad;
use App\Models\Evento;

class Modalidades extends Component
{
    use WithPagination;

    public $modalidad, $modalidad_id, $search;
    public $isOpen = false;
    public $confirmingDelete = false;
    public $IdAEliminar;
    public $nombreAEliminar;
    public $perPage = 10;
    
    // Campos para ordenamiento
    public $sortField = 'id';
    public $sortDirection = 'asc';
    
    public function render()
    {
        $query = Modalidad::query()
            ->when($this->search, function ($query) {
                $query->where('modalidad', 'like', '%'.$this->search.'%');
            });
        
        // Aplicar ordenamiento dinámico
        $query->orderBy($this->sortField, $this->sortDirection);
        
        $modalidades = $query->paginate($this->perPage);
        return view('livewire.modalidad.modalidad', ['modalidades' => $modalidades]);
    }

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
        $this->resetInputFields();
    }
    public function cancelarEliminacion()
    {
        $this->confirmingDelete = false;
    }
    private function resetInputFields(){
        $this->modalidad = '';
        $this->modalidad_id = null;
    }

    public function store()
    {
        $this->validate([
            'modalidad' => [
                'required',
                'unique:modalidads,modalidad,' . $this->modalidad_id,
            ],
        ]);

        Modalidad::updateOrCreate(['id' => $this->modalidad_id], [
            'modalidad' => $this->modalidad,
        ]);

        session()->flash('message', 
            $this->modalidad_id ? 'Modalidad actualizada correctamente!' : 'Modalidad creada correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $modalidad = Modalidad::findOrFail($id);
        $this->modalidad_id = $id;
        $this->modalidad = $modalidad->modalidad;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $modalidad = Modalidad::find($this->IdAEliminar);

            if (!$modalidad) {
                session()->flash('error', 'localidad no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            $modalidad->forceDelete();
            session()->flash('message', 'modalidad eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $modalidad = Modalidad::find($id);

        if (!$modalidad) {
            session()->flash('error', 'modalidad no encontrada.');
            return;
        }
        if ($modalidad->eventos()->exists()) {
            session()->flash('error', 'No se puede eliminar la modalidad:  ' .$modalidad->modalidad .', porque está enlazado a uno o más eventos.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $modalidad->modalidad;
        $this->confirmingDelete = true;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }
}
