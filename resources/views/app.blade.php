<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

      <link href="/src/style.css" rel="stylesheet">

      @routes
    @vite('resources/js/app.js')
    @inertiaHead <!-- Load Vue app -->
</head>
<body class="bg-white">
    
    @inertia
</body>
</html>
