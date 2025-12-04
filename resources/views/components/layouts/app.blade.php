{{-- components/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          theme: $persist('system').as('theme').using(sessionStorage)
      }"
      x-init="
          // Detectar tema do sistema
          const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
          if (theme === 'system') {
              $root.classList.toggle('dark', systemDark);
          } else {
              $root.classList.toggle('dark', theme === 'dark');
          }

          // Observar mudanças no sistema
          window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
              if (theme === 'system') {
                  $root.classList.toggle('dark', e.matches);
                  document.dispatchEvent(new CustomEvent('theme-changed', {
                      detail: { theme: e.matches ? 'dark' : 'light' }
                  }));
              }
          });
      "
      :class="{ 'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta tag para tema do sistema -->
    <meta name="color-scheme" content="light dark">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script para evitar flash de tema incorreto -->
    <script>
        (function() {
            // Aplicar tema imediatamente antes do CSS carregar
            const storedTheme = sessionStorage.getItem('theme') || localStorage.getItem('theme') || 'system';
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (storedTheme === 'dark' || (storedTheme === 'system' && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            // Forçar renderização
            document.documentElement.style.visibility = 'hidden';
            document.documentElement.style.opacity = '0';
        })();
    </script>
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
      x-data
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
