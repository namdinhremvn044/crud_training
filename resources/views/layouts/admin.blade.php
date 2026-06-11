<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — {{ config('app.name', 'Laravel') }}</title>

    @fonts

    <x-vite-assets />

    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <x-admin.sidebar />

        <div class="flex min-w-0 flex-1 flex-col lg:pl-64">
            <x-admin.header :title="trim($__env->yieldContent('header')) ?: trim($__env->yieldContent('title')) ?: 'Admin'">
                @hasSection('header-actions')
                    <x-slot:actions>
                        @yield('header-actions')
                    </x-slot:actions>
                @endif
            </x-admin.header>

            <main class="flex-1 p-4 pb-20 sm:p-6 lg:p-8 lg:pb-8">
                <x-admin.alert />

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
