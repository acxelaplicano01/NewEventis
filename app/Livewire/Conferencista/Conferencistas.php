<?php

namespace App\Livewire\Conferencista;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Conferencista;
use App\Models\Nacionalidad;
use App\Models\Tipoperfil;
use App\Models\User;

class Conferencistas extends Component
{
    use WithPagination, WithFileUploads;

    public  $descripcion, $foto, $user_id, $conferencista_id, $search;
    public $nombre, $apellido, $correo, $IdNacionalidad, $IdTipoPerfil;
    public $nacionalidades, $tipoperfiles, $titulo;

    public $isOpen = 0;
    public $currentFoto, $currentFirma, $currentSello; // Para mantener las fotos actuales

    protected $rules = [
        'titulo' => 'required',
        'descripcion' => 'required',
        'foto' => 'nullable|image|max:1024',
        'user_id' => 'required|exists:users,id',
    ];

    public function mount()
    {
        $this->nacionalidades = Nacionalidad::all();
        $this->tipoperfiles = Tipoperfil::all();
    }

    public function render()
    {
        $conferencistas = Conferencista::with('user')
            ->where('titulo', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'ASC')
            ->paginate(5);

        return view('livewire.Conferencista.conferencistas', ['conferencistas' => $conferencistas]);
    }

    public function selectUser($userId)
    {
        $this->user_id = $userId;
        $user = User::find($userId);
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
    }

    private function resetInputFields()
    {
        $this->conferencista_id = '';
        $this->titulo = '';
        $this->descripcion = '';
        $this->foto = null;
        $this->user_id = null;
        $this->nombre = '';
        $this->apellido = '';
        $this->correo = '';
        $this->IdNacionalidad = '';
        $this->IdTipoPerfil = '';
        $this->currentFoto = null;
    }

    public function store()
    {
        try {
            $this->validate([
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
                'correo' => 'nullable|email|max:255',
                'IdNacionalidad' => 'required|exists:nacionalidads,id',
                'descripcion' => 'nullable|string',
                'IdTipoPerfil' => 'required|exists:tipoperfils,id',
            ]);

            // Manejo de archivos
            $this->foto = $this->foto ? $this->foto->store('conferencistas', 'public') : ($this->conferencista_id ? $this->currentFoto : 'http://www.puertopixel.com/wp-content/uploads/2011/03/Fondos-web-Texturas-web-abtacto-17.jpg');
            
            // Datos del usuario autenticado
            $createdBy = auth()->id();
            if (!$createdBy) {
                throw new \Exception('No user is authenticated.');
            }

            // Actualizar o crear la persona
            $user = User::updateOrCreate(
                ['dni' => $this->dni], // Condición para actualizar
                [
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'correo' => $this->correo,
                    'IdNacionalidad' => $this->IdNacionalidad,
                    'IdTipoPerfil' => $this->IdTipoPerfil,
                    'created_by' => $createdBy,
                ]
            );

            // Datos del conferencista
            $dataConferencista = [
                'IdUser' => $user->id,
                'foto' => $this->foto ? str_replace('public/', 'storage/', $this->foto) : $this->currentFoto,
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
            ];

            // Crear o actualizar el conferencista
            if ($this->conferencista_id) {
                $conferencista = Conferencista::findOrFail($this->conferencista_id);
                $conferencista->update($dataConferencista);
            } else {
                Conferencista::create($dataConferencista);
            }

            session()->flash('message', $this->conferencista_id ? 'Conferencista actualizado correctamente!' : 'Conferencista creado correctamente!');

            $this->closeModal();
            $this->resetInputFields();
            $this->render();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $conferencista = Conferencista::findOrFail($id);

        $this->conferencista_id = $id;
        $this->nombre = $conferencista->user->nombre;
        $this->apellido = $conferencista->user->apellido;
        $this->correo = $conferencista->user->correo;
        $this->IdNacionalidad = $conferencista->user->IdNacionalidad;
        $this->IdTipoPerfil = $conferencista->user->IdTipoPerfil;

        // Almacenar las URLs actuales de las fotos
        $this->currentFoto = $conferencista->foto;
        $this->openModal();
    }

    public $confirmingDelete = false;
    public $IdAEliminar;
    public $nombreAEliminar;

    public function delete()
    {
        if ($this->confirmingDelete) {
            $conferencista = Conferencista::find($this->IdAEliminar);

            if (!$conferencista) {
                session()->flash('error', 'Conferencista no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $conferencista->forceDelete();
            session()->flash('message', 'Conferencista eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $conferencista = Conferencista::find($id);

        if (!$conferencista) {
            session()->flash('error', 'Conferencista no encontrado.');
            return;
        }

        if ($conferencista->conferencias()->exists()) {
            session()->flash('error', 'No se puede eliminar el conferencista: '.$conferencista->user->nombre .' '.$conferencista->user->apellido .', porque está enlazado a una o más conferencias.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $conferencista->user->nombre . ' ' . $conferencista->user->apellido;
        $this->confirmingDelete = true;
    }
}
