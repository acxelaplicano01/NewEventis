<?php
namespace App\Livewire\Muro;

use App\Models\Comentario;
use App\Models\Diploma;
use Livewire\Attributes\Lazy;
use Livewire\WithFileUploads;
use App\Models\Evento;
use App\Models\User;
use App\Models\Modalidad;
use App\Models\Localidad;
use App\Models\Publicacion;
use App\Models\Like;
use Livewire\Component;

//#[Lazy] 
class Muros extends Component
{
    use WithFileUploads;
    public $logo, $nombreevento, $estado,$precio, $descripcion, $organizador, $fechainicio, $fechafinal, $horainicio, $horafin, $idmodalidad, $idlocalidad, $IdDiploma, $evento_id;

    public $search = '';
    public $userperfil;
    public $modalidades, $localidades;
    public $likes = [];
    public $comentario, $fotoComentario,  $diplomas;

    public $activeTab = 'styled-publicaciones';
    public $activeModal = null;
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openModal($modalId)
    {
        $this->activeModal = $modalId;
    }

    public function closeModal()
    {
        $this->activeModal = null;
        $this->resetInputFields();
        $this->resetInputFieldsEvento();
    }

    public function mount(User $userperfil)
    {
        $this->userperfil = $userperfil;
        $this->cargarLikes();
        $this->diplomas = Diploma::all();
        $this->modalidades = Modalidad::all();
        $this->localidades = Localidad::all();
    }

    public function cargarLikes()
    {
        $this->likes = Like::where('idUsuario', auth()->id()) // Obtiene los likes solo del usuario autenticado
            ->where('meGusta', true)
            ->pluck('idPublicacion')
            ->toArray();
    }

    public $publicacion_id, $foto, $IdUsuario;
   
    public $confirmingDelete = 0;
    public $IdAEliminar;

    private function resetInputFields()
    {
        $this->descripcion = '';
        $this->publicacion_id = null;
        $this->foto = null;
    }

    private function resetInputFieldsEvento()
    {
        $this->logo = '';
        $this->nombreevento = '';
        $this->descripcion = '';
        $this->organizador = '';
        $this->fechainicio = '';
        $this->fechafinal = '';
        $this->horainicio = '';
        $this->horafin = '';
        $this->idmodalidad = '';
        $this->idlocalidad = '';
        $this->IdDiploma = '';
    }

    public function storEvento()
    {
        $this->validate([
            'logo' => 'nullable|image',
            'nombreevento' => 'required',
            'descripcion' => 'required',
            'organizador' => 'required',
            'fechainicio' => 'required',
            'fechafinal' => 'required',
            'horainicio' => 'required',
            'horafin' => 'required',
            'idmodalidad' => 'required',
            'idlocalidad' => 'required',
            'IdDiploma' => 'required',
            'estado' => 'required|string|max:255',
            'precio' => 'nullable',
        ]);

        // Manejo de archivo logo
        if ($this->logo) {
            // Guardamos el archivo en la carpeta eventos dentro de storage/app/public
            $this->logo = $this->logo->store('eventos', 'public');
        } elseif ($this->evento_id) {
            $evento = Evento::findOrFail($this->evento_id);
            $this->logo = $evento->logo;
        }

        Evento::updateOrCreate(['id' => $this->evento_id], [
            'logo' => $this->logo ? str_replace('public/', 'storage/', $this->logo) : null,
            'nombreevento' => $this->nombreevento,
            'descripcion' => $this->descripcion,
            'organizador' => $this->organizador,
            'fechainicio' => $this->fechainicio,
            'fechafinal' => $this->fechafinal,
            'horainicio' => $this->horainicio,
            'horafin' => $this->horafin,
            'idmodalidad' => $this->idmodalidad,
            'idlocalidad' => $this->idlocalidad,
            'IdDiploma' => $this->IdDiploma,
            'estado' => $this->estado,
            'precio' => $this->precio ?: null,
        ]);

        session()->flash('message', 
            $this->evento_id ? 'Evento creado correctamente!' : 'Evento actualizado correctamente!');


        $this->resetInputFieldsEvento();
        $this->closeModal();
    }

    public function viewDetails($id)
    {
        $this->selectedEvento = Evento::find($id);
        $this->showDetails = true;
    }

    public function closeDetails()
    {
        $this->showDetails = false;
    }


    function edit($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        $this->publicacion_id = $id;
        $this->descripcion = $publicacion->descripcion;
        $this->foto = asset('storage/' . $publicacion->foto);
        $this->openModal("modal1");
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $publicacion = Publicacion::find($this->IdAEliminar);

            if (!$publicacion) {
                session()->flash('error', 'Publicación no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            $publicacion->forceDelete();
            session()->flash('message', 'Publicación eliminada correctamente!');
            $this->confirmingDelete = false;
            $this->IdAEliminar = null;
            $this->closeModal();
        }
    }

    public function store()
{
    $rules = [
        'descripcion' => 'nullable|string|max:525',
    ];

    // Validar solo si se subió una nueva imagen
    if ($this->foto instanceof \Livewire\TemporaryUploadedFile) {
        $rules['foto'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
    }

    $this->validate($rules);

    // Verificar si el usuario está definido
    if (!$this->userperfil) {
        session()->flash('error', 'Error: Usuario no encontrado.');
        return;
    }

    // Si se sube una nueva imagen, guardarla; si no, mantener la existente
    if ($this->foto instanceof \Livewire\TemporaryUploadedFile) {
        $this->foto = $this->foto->store('fotos', 'public');
    } elseif ($this->publicacion_id) {
        $publicacion = Publicacion::findOrFail($this->publicacion_id);
        $this->foto = $publicacion->foto;
    }

    // Guardar o actualizar la publicación
    Publicacion::updateOrCreate(['id' => $this->publicacion_id], [
        'descripcion' => $this->descripcion,
        'foto' => $this->foto,
        'IdUsuario' => $this->userperfil->id,
        'fecha' => now()->toDateString(),
        'hora' => now()->toTimeString(),
        'lugar' => 'Lugar de ejemplo',
        'created_by' => $this->userperfil->id,
    ]);

    // Mensaje de éxito
    session()->flash(
        'message',
        $this->publicacion_id ? 'Publicación actualizada correctamente!' : 'Has publicado!'
    );

    // limpiar los campos
    $this->resetInputFields();
    $this->closeModal();
}


    public function confirmDelete($id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion) {
            session()->flash('error', 'Publicación no encontrada.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->confirmingDelete = true;
    }

    public function like($publicacionId)
    {
        $usuarioId = auth()->id(); // Obtener ID del usuario autenticado

        $like = Like::where('idPublicacion', $publicacionId)
            ->where('idUsuario', $usuarioId)
            ->first();

        if ($like) {
            $like->meGusta = !$like->meGusta;
            $like->save();

            if ($like->meGusta) {
                $this->likes[] = $publicacionId; // Agregar a la lista de likes del usuario
            } else {
                $this->likes = array_values(array_diff($this->likes, [$publicacionId])); // Quitar y reindexar
            }
        } else {
            Like::create([
                'meGusta' => true,
                'noMegusta' => false,
                'idPublicacion' => $publicacionId,
                'idUsuario' => $usuarioId, // Se usa el usuario autenticado
            ]);

            $this->likes[] = $publicacionId;
        }
    }


    public function addComentario($publicacionId)
    {
        $this->validate([
            'comentario' => 'required|string|max:255',
            'fotoComentario' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Comentario::create([
            'contenido' => $this->comentario,
            'fotoComentario' => $this->fotoComentario ? $this->fotoComentario->store('comentarios', 'public') : null,
            'idPublicacion' => $publicacionId,
            'idUsuario' => $this->userperfil->id,
        ]);

        $this->comentario = '';
    }

    public function getSeguidores($userId)
    {
        $user = User::find($userId);
        if ($user) {
            return $user->seguidores;
        }
        return collect(); // Retorna una colección vacía si el usuario no existe
    }

    public function seguir($userId)
    {
        $user = User::find($userId);
        if ($user) {
            auth()->user()->seguir($user->id);
            session()->flash('message', 'Has seguido a ' . $user->name);
        }
    }

    public function dejarDeSeguir($userId)
    {
        $user = User::find($userId);
        if ($user) {
            auth()->user()->dejarDeSeguir($user->id);
            session()->flash('message', 'Has dejado de seguir a ' . $user->name);
        }
    }
    public function getSeguidos($userId)
    {
        $user = User::find($userId);
        if ($user) {
            return $user->siguiendo;
        }
        return collect(); // Retorna una colección vacía si el usuario no existe
    }

    //crear funcion para placeholder
   /* public function placeholder()
    {
        return view('livewire.placeholder.loaders');
    }*/
    public $perPage = 7;
    public function loadMore()
    {
        $this->perPage += 7;
    }  
    public function render()
    {
        $Eventos = Evento::with('modalidad', 'localidad', 'diploma')
            ->where('created_by', $this->userperfil->id)
            ->where(function ($query) {
                $query->where('nombreevento', 'like', '%' . $this->search . '%')
                    ->orWhereHas('modalidad', function ($query) {
                        $query->where('modalidad', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('localidad', function ($query) {
                        $query->where('localidad', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('id', 'DESC')
            ->paginate(6);

        $eventosCount = $this->userperfil->countEventos();

        $publicaciones = Publicacion::with('user')
            ->where('created_by', $this->userperfil->id)
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);

        $publicacionesCount = $this->userperfil->countPublicaciones();
        
        // Obtener seguidores y seguidos para un usuario específico (por ejemplo, el usuario con ID 1)
        $seguidores = $this->getSeguidores($this->userperfil->id);
        $seguidos = $this->getSeguidos($this->userperfil->id);

        return view('livewire.muro.muros', [
            'Eventos' => $Eventos,
            'eventosCount' => $eventosCount,
            'publicacionesCount' => $publicacionesCount,
            'publicaciones' => $publicaciones,
            'seguidores' => $seguidores,
            'seguidos' => $seguidos,
        ]);
    }
}