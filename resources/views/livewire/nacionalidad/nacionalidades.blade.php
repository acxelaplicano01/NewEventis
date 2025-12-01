<div class="bg-white dark:bg-stone-800 rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-2">
        <h2 class="text-2xl font-semibold text-stone-800 dark:text-stone-100">Nacionalidades</h2>
        <div class="flex gap-2">
            <input type="text" wire:model="search" placeholder="Buscar nacionalidad..." class="px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 dark:bg-stone-900 dark:text-stone-100" />
            <button wire:click="create" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium shadow transition">Nueva Nacionalidad</button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-stone-200 dark:divide-stone-700">
            <thead class="bg-stone-100 dark:bg-stone-900">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-stone-600 dark:text-stone-300">#</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-stone-600 dark:text-stone-300">Nacionalidad</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-stone-600 dark:text-stone-300">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-stone-800 divide-y divide-stone-200 dark:divide-stone-700">
                @forelse($nacionalidades as $nac)
                    <tr>
                        <td class="px-4 py-2 text-stone-700 dark:text-stone-100">{{ $nac->id }}</td>
                        <td class="px-4 py-2 text-stone-700 dark:text-stone-100">{{ $nac->nombreNacionalidad }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="edit({{ $nac->id }})" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded shadow text-xs">Editar</button>
                            <button wire:click="confirmDelete({{ $nac->id }})" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow text-xs ml-2">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-stone-500 dark:text-stone-300">No hay nacionalidades registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $nacionalidades->links() }}
    </div>

    <!-- Incluir el modal de crear/editar -->
    @include('livewire.nacionalidad.create')

    <!-- Modal de confirmación de eliminación -->
    <x-elegant-delete-modal 
        wire:model="confirmingDelete"
        title="Eliminar Nacionalidad"
        message="¿Estás seguro de que deseas eliminar esta nacionalidad?"
        entityName="{{ $nombreAEliminar }}"
        confirmMethod="delete"
        cancelMethod="$set('confirmingDelete', false)"
        confirmText="Eliminar"
        cancelText="Cancelar"
    />
</div>