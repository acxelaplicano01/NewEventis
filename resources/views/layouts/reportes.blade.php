@extends('layouts.base')
@section('content')
    <x-banner />

    <div class="min-h-screen font-sans bg-stone-50 dark:bg-stone-900 antialiased">
        <!-- Page Content -->
        <main class="dark:bg-gray-900">
            <div class="">
                <div class=" mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </main>

    </div>
@endsection
