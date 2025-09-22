<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
      <link href="/src/style.css" rel="stylesheet">

    @vite('resources/js/app.js') <!-- Load Vue app -->
</head>
<body class="bg-white">
    <div id="app"></div>
</body>
</html>
