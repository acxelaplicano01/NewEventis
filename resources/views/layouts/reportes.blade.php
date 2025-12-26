@extends('layouts.base')
@section('content')
    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
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
