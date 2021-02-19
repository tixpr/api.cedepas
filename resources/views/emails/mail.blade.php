<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>CEDEPAS</title>
</head>
<body>
    <div id="app" class="grow flex-row bg-white">
        <main class="container-lg flex-column align-center justify-start">
            @yield('content')
        </main>
    </div>
</body>
</html>
