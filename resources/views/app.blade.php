<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>

  <title>{{ $page['props']['meta']['title'] ?? 'ReelQuip Films' }}</title>
  <meta name="description" content="{{ $page['props']['meta']['description'] ?? 'Lighting & camera crew services.' }}">
  <meta property="og:title" content="{{ $page['props']['meta']['title'] ?? 'ReelQuip Films' }}">
  <meta property="og:description" content="{{ $page['props']['meta']['description'] ?? '' }}">
  <meta property="og:image" content="{{ $page['props']['meta']['image'] ?? asset('default-project.jpg') }}">
  <meta property="og:url" content="{{ $page['props']['meta']['url'] ?? url('/') }}">
  <meta property="og:type" content="article">
 
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
