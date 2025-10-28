<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Unna:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js"></script>
        <!-- CDN de Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

        <script src="./assets/vendor/preline/dist/preline.js"></script>
        <title>{{ $title ?? 'Vibra con Miriam' }}</title>
    </head>
    <body class="font-notoSerif">
         @if (!request()->is('login' ) && !request()->is('register') )
        @livewire('partials.navbar')
        @endif
        {{ $slot }}
        @if (!request()->is('login' ) && !request()->is('register') )
        @livewire('partials.footer')
        @endif
    </body>
</html>
