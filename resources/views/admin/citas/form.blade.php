<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appointment->exists ? 'Editar cita' : 'Nueva cita' }} — Admin Arsa & Asociados</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-midnight-50 font-sans antialiased">

    <header class="bg-midnight-950 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('images/brand/logo-icon.png') }}" alt="Arsa & Asociados" class="h-10 w-auto object-contain">
        </div>
        <a href="{{ url('/') }}" class="text-xs text-midnight-400 hover:text-white transition-colors">← Ver sitio</a>
    </header>

    <main class="max-w-2xl mx-auto px-6 py-10">

        <div class="mb-8">
            <a href="{{ route('admin.citas.index') }}" class="text-sm text-midnight-500 hover:text-midnight-900 transition-colors">← Volver a citas</a>
            <h1 class="text-2xl font-serif font-semibold text-midnight-900 mt-2">
                {{ $appointment->exists ? 'Editar cita' : 'Nueva cita' }}
            </h1>
        </div>

        @if($errors->any())
            <div class="mb-6 px-5 py-4 bg-red-50 border border-red-200 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ $appointment->exists ? route('admin.citas.update', $appointment) : route('admin.citas.store') }}"
              class="bg-white border border-midnight-100 p-8 space-y-5">
            @csrf
            @if($appointment->exists)
                @method('PUT')
            @endif

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-medium text-midnight-600 mb-1.5">Nombre completo *</label>
                    <input type="text" name="name" required value="{{ old('name', $appointment->name) }}"
                           class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-midnight-600 mb-1.5">Correo electrónico *</label>
                    <input type="email" name="email" required value="{{ old('email', $appointment->email) }}"
                           class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-midnight-600 mb-1.5">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone', $appointment->phone) }}"
                           class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-midnight-600 mb-1.5">Tema de la consulta</label>
                    <select name="area"
                            class="w-full px-4 py-3 border border-midnight-200 text-sm bg-white focus:outline-none focus:border-gold-500 transition-colors">
                        <option value="">— Sin especificar —</option>
                        @foreach($areas as $area)
                            <option value="{{ $area['name'] }}" {{ old('area', $appointment->area) === $area['name'] ? 'selected' : '' }}>{{ $area['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-midnight-600 mb-1.5">Fecha y hora *</label>
                    <input type="datetime-local" name="scheduled_at" required step="3600"
                           @unless($appointment->exists) min="{{ now()->startOfDay()->format('Y-m-d\TH:i') }}" @endunless
                           value="{{ old('scheduled_at', optional($appointment->scheduled_at)->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                    <p class="text-xs text-midnight-400 mt-1.5">Las citas se agendan por hora en punto (bloques de 60 min).</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-midnight-600 mb-1.5">Estado *</label>
                    @php $estado = old('status', $appointment->status); @endphp
                    <select name="status"
                            class="w-full px-4 py-3 border border-midnight-200 text-sm bg-white focus:outline-none focus:border-gold-500 transition-colors">
                        <option value="pendiente"  {{ $estado === 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                        <option value="confirmada" {{ $estado === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                        <option value="cancelada"  {{ $estado === 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-midnight-600 mb-1.5">Notas / motivo (opcional)</label>
                <textarea name="message" rows="3"
                          class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors resize-none">{{ old('message', $appointment->message) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-8 py-3 bg-midnight-900 text-white font-semibold text-sm hover:bg-midnight-800 transition-colors">
                    {{ $appointment->exists ? 'Guardar cambios' : 'Crear cita' }}
                </button>
                <a href="{{ route('admin.citas.index') }}" class="px-6 py-3 text-sm text-midnight-500 hover:text-midnight-900 transition-colors">Cancelar</a>
            </div>
        </form>

    </main>
</body>
</html>
