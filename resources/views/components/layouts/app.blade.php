<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="themeManager"  
      x-init="init"
      :class="{ 'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">

    <title>{{ config('app.name', 'B2CStore') }}</title>

    <!-- Vite CSS + JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-opacity duration-300 opacity-0"
      x-cloak
      x-init="
          requestAnimationFrame(() => {
              document.body.classList.remove('opacity-0');
          });
      ">

    <!-- Conteúdo -->
    {{ $slot }}

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Scripts adicionais -->
    @stack('scripts')
</body>
</html>
