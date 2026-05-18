<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Arsa & Asociados</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-midnight-950 flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/brand/logo-icon.png') }}" alt="Arsa & Asociados" class="h-20 w-auto object-contain">
        </div>

        <form method="POST" class="bg-midnight-900 p-8 space-y-5">
            @csrf
            <h1 class="text-lg font-serif font-semibold text-white text-center mb-6">Panel de administración</h1>

            @if($error)
                <p class="text-xs text-red-400 text-center">{{ $error }}</p>
            @endif

            <div>
                <label class="block text-xs uppercase tracking-wider text-midnight-400 mb-2">Contraseña</label>
                <input type="password" name="password" required autofocus
                       class="w-full px-4 py-3 bg-midnight-800 border border-midnight-700 text-white text-sm focus:outline-none focus:border-gold-500 transition-colors">
            </div>

            <button type="submit"
                    class="w-full px-6 py-3 bg-gold-500 text-midnight-950 font-semibold text-sm hover:bg-gold-400 transition-colors">
                Ingresar
            </button>
        </form>
    </div>
</body>
</html>
