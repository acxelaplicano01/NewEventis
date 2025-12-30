@props(['comentario', 'publicacion', 'comentarioLikes', 'replyToComentarioId', 'depth' => 0])

@php
    $maxDepth = 3; // Limitar la profundidad para evitar bucles infinitos
    $isReply = $depth > 0;
    $indentClass = $isReply ? 'ml-12' : '';
    $avatarSize = $isReply ? '6' : '8';
    $textSize = $isReply ? 'sm' : 'base';
    $nameSize = $isReply ? 'sm' : 'base';
@endphp

<div class="relative {{ $indentClass }}">
    @if($isReply)
        <!-- Línea vertical azul para conectar respuestas -->
        <div class="absolute left-0 top-0 bottom-0 w-[1px] bg-stone-300 -ml-6"></div>
    @endif

    <div class="flex space-x-3 {{ $isReply ? 'py-2' : 'py-3' }}">
        <!-- Avatar -->
        <div class="flex-shrink-0 relative">
            @if($comentario->user->profile_photo_path)
                <img class="w-{{ $avatarSize }} h-{{ $avatarSize }} rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700"
                    src="/storage/{{ $comentario->user->profile_photo_path }}" alt="Avatar">
            @else
                <div class="w-{{ $avatarSize }} h-{{ $avatarSize }} rounded-full bg-gradient-to-br from-yellow-500 to-purple-600 flex items-center justify-center ring-2 ring-gray-100 dark:ring-gray-700">
                    <span class="text-white font-semibold text-{{ $isReply ? 'xs' : 'sm' }}">
                        {{ substr($comentario->user->name, 0, 1) }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Contenido del comentario -->
        <div class="flex-1 min-w-0">
            <!-- Nombre y fecha -->
            <div class="flex items-center space-x-2 mb-1">
                <h4 class="text-{{ $nameSize }} font-semibold text-gray-900 dark:text-white hover:underline cursor-pointer">
                    {{ $comentario->user->nombre }} {{ $comentario->user->apellido }}
                </h4>
                <span class="text-{{ $isReply ? 'xs' : 'sm' }} text-gray-500 dark:text-gray-400">
                    {{ $comentario->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Contenido del comentario -->
            <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl px-4 py-2 mb-2">
                <p class="text-{{ $textSize }} text-gray-900 dark:text-gray-100 leading-relaxed break-words">
                    {{ $comentario->contenido }}
                </p>
            </div>

            <!-- Acciones -->
            <div class="flex items-center space-x-4">
                <button wire:click="likeComentario({{ $comentario->id }})"
                    class="flex items-center space-x-1 text-{{ $isReply ? 'xs' : 'sm' }} font-medium transition-colors {{ in_array($comentario->id, $comentarioLikes) ? 'text-red-500 hover:text-red-600' : 'text-gray-500 hover:text-red-500' }}">
                    <svg class="w-4 h-4 {{ in_array($comentario->id, $comentarioLikes) ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span>{{ $comentario->likes_count > 0 ? $comentario->likes_count : '' }}</span>
                </button>

                @if($depth < $maxDepth)
                    <button wire:click="replyToComentario({{ $comentario->id }})"
                        class="text-{{ $isReply ? 'xs' : 'sm' }} text-gray-500 hover:text-yellow-500 dark:hover:text-yellow-400 font-medium transition-colors">
                        Responder
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Formulario de respuesta -->
    @if($replyToComentarioId == $comentario->id)
        <div class="ml-9 mb-3">
            <form wire:submit.prevent="addReply({{ $publicacion->id }})" class="space-y-2">
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        @if(auth()->user()->profile_photo_path)
                            <img class="w-6 h-6 rounded-full object-cover"
                                src="/storage/{{ auth()->user()->profile_photo_path }}" alt="Avatar">
                        @else
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-yellow-500 to-purple-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-xs">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input wire:model="replyContent"
                            type="text"
                            class="w-full px-4 py-2 text-sm border-0 rounded-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-0"
                            placeholder="Escribe una respuesta..."
                            wire:keydown.enter.prevent="addReply({{ $publicacion->id }})">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-full transition-colors duration-200">
                            Responder
                        </button>
                        <button type="button"
                            wire:click="cancelReply"
                            class="px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-sm font-medium transition-colors duration-200">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- Placeholder de respuesta visible (como en Facebook) -->
    @if($replyToComentarioId != $comentario->id && $depth < $maxDepth)
        <div class="ml-9 mt-2">
            <div wire:click="replyToComentario({{ $comentario->id }})" role="button" tabindex="0"
                class="flex items-center gap-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-full px-3 py-2 cursor-text hover:bg-gray-50 dark:hover:bg-gray-600">
                <div class="flex-shrink-0">
                    @if(auth()->user()->profile_photo_path)
                        <img class="w-6 h-6 rounded-full object-cover" src="/storage/{{ auth()->user()->profile_photo_path }}" alt="Avatar">
                    @else
                         <div class="w-6 h-6 rounded-full bg-gradient-to-br from-yellow-500 to-purple-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-xs">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                    @endif
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-300">Responde a {{ $comentario->user->nombre }}</div>
            </div>
        </div>
    @endif

    <!-- Respuestas recursivas -->
    @if($comentario->replies->count() > 0 && $depth < $maxDepth)
        <div class="space-y-1">
            @foreach($comentario->replies as $reply)
                @include('livewire.muro.partials.comment-item', [
                    'comentario' => $reply,
                    'publicacion' => $publicacion,
                    'comentarioLikes' => $comentarioLikes,
                    'replyToComentarioId' => $replyToComentarioId,
                    'depth' => $depth + 1
                ])
            @endforeach
        </div>
    @endif
</div>