<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Usuarios extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $nombre;
    public $descripcion;
    public $apellido;
    public $password;
    public $user;
    public $search = '';
    public $selectedRoles = [];
    public $roles;
    public $isOpen = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;
    public $IdAEliminar;
    public $nombreAEliminar;
    public $IdNacionalidad;
    public $IdTipoPerfil;
    public $profile_photo_path;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'nombre' => 'required',
        'apellido' => 'required',
        'descripcion' => 'required',
        'password' => 'required|min:8',
        'selectedRoles' => 'required|array',
        'selectedRoles.*' => 'exists:roles,id',
    ];

    protected $listeners = ['userStored' => '$refresh'];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
                     ->orWhere('email', 'like', '%' . $this->search . '%')
                     ->orderBy('id', 'DESC')
                     ->paginate(5);

        return view('livewire.Usuario.usuarios', ['users' => $users]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->roles = Role::all();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($this->user ? ',' . $this->user->id : ''),
            'nombre' => 'nullable',
            'apellido' => 'nullable',
            'descripcion' => 'nullable',
            'IdNacionalidad' => 'nullable',
            'IdTipoPerfil' => 'nullable',
            'profile_photo_path' => 'nullable',
            'password' => 'nullable|min:8',
            'selectedRoles' => 'required|array',
            'selectedRoles.*' => 'exists:roles,id',
        ]);

        if ($this->user) {
            $this->update();
        } else {
            $this->createUser();
        }
    }

    private function createUser()
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'descripcion' => $this->descripcion,
            'IdNacionalidad' => $this->IdNacionalidad,
            'IdTipoPerfil' => $this->IdTipoPerfil,
            'profile_photo_path' => $this->profile_photo_path,
            'password' => Hash::make($this->password),
        ]);

        Log::info('Created User:', $user->toArray());
        Log::info('Selected Roles for Creation:', $this->selectedRoles);

        $roleIds = Role::whereIn('id', $this->selectedRoles)->pluck('id')->toArray();
        Log::info('Existing Roles for Creation:', $roleIds);

        $user->syncRoles($roleIds);

        session()->flash('message', 'Usuario creado exitosamente.');
        $this->roles = Role::all();
        $this->reset();
        $this->isOpen = false;
    }

    public function edit(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nombre = $user->nombre;
        $this->apellido = $user->apellido;
        $this->descripcion =$user->descripcion;
        $this->IdNacionalidad = $user->IdNacionalidad;
        $this->IdTipoPerfil = $user->IdTipoPerfil;
        $this->profile_photo_path = $user->profile_photo_path;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->roles = Role::all();
        $this->isOpen = true;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'nombre' => 'required',
            'apellido' => 'required',
            'descripcion' => 'nullable',
            'IdNacionalidad' => 'nullable',
            'IdTipoPerfil' => 'nullable',
            'profile_photo_path' => 'nullable',
            'password' => 'nullable|min:8',
            'selectedRoles' => 'required|array',
            'selectedRoles.*' => 'exists:roles,id',
        ]);

        try {
            $user = User::findOrFail($this->user->id);

            Log::info('Selected Roles for Update:', $validatedData['selectedRoles']);

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'descripcion' => $this->descripcion,
                'IdNacionalidad' => $this->IdNacionalidad,
                'IdTipoPerfil' => $this->IdTipoPerfil,
                'profile_photo_path' => $this->profile_photo_path,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
            ]);

            $roleIds = Role::whereIn('id', $validatedData['selectedRoles'])->pluck('id')->toArray();
            Log::info('Existing Roles for Update:', $roleIds);

            $user->syncRoles($roleIds);

            session()->flash('message', 'Usuario actualizado.');
            $this->roles = Role::all();
            $this->reset();
            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el usuario: ' . $e->getMessage());
            Log::error('Error updating user: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $user  = User::find($this->IdAEliminar);

            if (!$user ) {
                session()->flash('error', 'Usuario no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $user ->forceDelete();
            session()->flash('message', 'usuario eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $user  = User::find($id);

        if (!$user ) {
            session()->flash('error', 'usuario no encontrado.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $user->name . ' ' . $user ->email;
        $this->confirmingDelete = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->nombre = '';
        $this->apellido = '';
        $this->descripcion = '';
        $this->IdNacionalidad = '';
        $this->IdTipoPerfil = '';
        $this->profile_photo_path = '';
        $this->password = '';
        $this->selectedRoles = [];
    }
}
