<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="themeManager"  
      x-init="init"          
      :class="{ 'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta tag para tema do sistema -->
    <meta name="color-scheme" content="light dark">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Importação do Vite CSS e JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])  <!-- Aqui o app.js vai importar o theme.js -->
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
      x-init="
          // Mostrar conteúdo após carregamento
          setTimeout(() => {
              document.documentElement.style.visibility = 'visible';
              document.documentElement.style.opacity = '1';
              document.documentElement.style.transition = 'opacity 0.3s ease';
          }, 50);
      ">

    <!-- Conteúdo -->
    {{ $slot }}

    <!-- Scripts stack -->
    @stack('scripts')
</body>
</html>
