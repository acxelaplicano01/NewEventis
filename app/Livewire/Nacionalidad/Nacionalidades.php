<?php

namespace App\Livewire\Nacionalidad;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Nacionalidad;
use App\Models\User;
class Nacionalidades extends Component
{
    use WithPagination;
    public $nombreNacionalidad, $nacionalidad_id, $search;
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
        $query = Nacionalidad::query()
            ->when($this->search, function ($query) {
                $query->where('nombreNacionalidad', 'like', '%'.$this->search.'%');
            });
        
        // Aplicar ordenamiento dinámico
        $query->orderBy($this->sortField, $this->sortDirection);
        
        $nacionalidades = $query->paginate($this->perPage);
        return view('livewire.nacionalidad.nacionalidades', ['nacionalidades' => $nacionalidades]);
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
    private function resetInputFields(){
        $this->nombreNacionalidad = '';
    }
    public function cancelarEliminacion()
    {
        $this->confirmingDelete = false;
    }
    public function store()
    {
        $this->validate([
            'nombreNacionalidad' => [
                'required',
                'string',
                'max:255',
                'unique:nacionalidads,nombreNacionalidad,' . $this->nacionalidad_id,
            ],
        ]);

        Nacionalidad::updateOrCreate(['id' => $this->nacionalidad_id], [
            'nombreNacionalidad' => $this->nombreNacionalidad,
            //'created_by' => auth()->id(),
        ]);

        session()->flash('message', 
            $this->nacionalidad_id ? 'Nacionalidad actualizada correctamente!' : 'Nacionalidad creada correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $nacionalidad = Nacionalidad::findOrFail($id);
        $this->nacionalidad_id = $id;
        $this->nombreNacionalidad = $nacionalidad->nombreNacionalidad;
    
        $this->openModal();
    }
     
    public function delete()
    {
        if ($this->confirmingDelete) {
            $nacionalidad = Nacionalidad::find($this->IdAEliminar);

            if (!$nacionalidad) {
                session()->flash('error', 'nacionalidad no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            $nacionalidad->forceDelete();
            session()->flash('message', 'nacionalidad eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $nacionalidad = Nacionalidad::find($id);

        if (!$nacionalidad) {
            session()->flash('error', 'Nacionalidad no encontrada.');
            return;
        }

        if ($nacionalidad->users()->exists()) {
            session()->flash('error', 'No se puede eliminar la nacionalidad: '. $nacionalidad->nombreNacionalidad . ', porque está enlazado a una  o más personas:');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $nacionalidad->nombreNacionalidad;
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
