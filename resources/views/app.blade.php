<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page['props']['seo']['title'] ?? $page['props']['meta']['title'] ?? 'ReelQuip Films' }}</title>
      <meta name="description" content="{{ $page['props']['seo']['description'] ?? $page['props']['meta']['description'] ?? 'Lighting & camera crew services.' }}">
      <meta name="keywords" content="{{ $page['props']['seo']['keywords'] ?? $page['props']['meta']['keywords'] ?? 'film equipment rental, camera rental, lighting rental, production gear rental, UAE film production' }}">
      <link rel="canonical" href="{{ $page['props']['seo']['canonical'] ?? $page['props']['meta']['canonical'] ?? url()->current() }}" />
      <meta property="og:title" content="{{ $page['props']['seo']['og']['title'] ?? $page['props']['meta']['og']['title'] ?? $page['props']['seo']['title'] ?? $page['props']['meta']['title'] ?? 'ReelQuip Films' }}">
      <meta property="og:description" content="{{ $page['props']['seo']['og']['description'] ?? $page['props']['meta']['og']['description'] ?? $page['props']['seo']['description'] ?? $page['props']['meta']['description'] ?? '' }}">
      <meta property="og:image" content="{{ $page['props']['seo']['og']['image'] ?? $page['props']['meta']['og']['image'] ?? $page['props']['seo']['image'] ?? $page['props']['meta']['image'] ?? asset('default-project.jpg') }}">
      <meta property="og:url" content="{{ $page['props']['seo']['og']['url'] ?? $page['props']['meta']['og']['url'] ?? $page['props']['seo']['canonical'] ?? $page['props']['meta']['canonical'] ?? url()->current() }}">
      <meta property="og:type" content="{{ $page['props']['seo']['og']['type'] ?? $page['props']['meta']['og']['type'] ?? 'website' }}">
      <meta name="twitter:card" content="{{ $page['props']['seo']['twitter']['card'] ?? $page['props']['meta']['twitter']['card'] ?? 'summary_large_image' }}">
      <meta name="twitter:title" content="{{ $page['props']['seo']['twitter']['title'] ?? $page['props']['meta']['twitter']['title'] ?? $page['props']['seo']['title'] ?? $page['props']['meta']['title'] ?? 'ReelQuip Films' }}">
      <meta name="twitter:description" content="{{ $page['props']['seo']['twitter']['description'] ?? $page['props']['meta']['twitter']['description'] ?? $page['props']['seo']['description'] ?? $page['props']['meta']['description'] ?? '' }}">
      <meta name="twitter:image" content="{{ $page['props']['seo']['twitter']['image'] ?? $page['props']['meta']['twitter']['image'] ?? $page['props']['seo']['og']['image'] ?? $page['props']['meta']['og']['image'] ?? $page['props']['seo']['image'] ?? $page['props']['meta']['image'] ?? asset('default-project.jpg') }}">

    <!-- <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}"> -->

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.png" sizes="32x32" type="image/png">
      <link href="/src/style.css" rel="stylesheet">

      @routes
    @vite('resources/js/app.js')
    @inertiaHead <!-- Load Vue app -->
</head>
<body class="bg-white">
    
    @inertia
</body>
</html>
