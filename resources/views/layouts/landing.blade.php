<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KarangTaruna — Sistem Manajemen Desa</title>
    <meta name="description" content="Sistem manajemen Karang Taruna - transparansi keuangan, voting demokratis, dan informasi desa.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak]{display:none!important}html{scroll-behavior:smooth}</style>
</head>
<body class="font-inter bg-white min-h-screen">
    {{ $slot }}
    @livewireScripts
</body>
</html>
