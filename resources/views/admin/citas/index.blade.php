<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citas — Admin Arsa & Asociados</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-midnight-50 font-sans antialiased">

    <header class="bg-midnight-950 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('images/brand/logo-icon.png') }}" alt="Arsa & Asociados" class="h-10 w-auto object-contain">
        </div>
        <a href="{{ url('/') }}" class="text-xs text-midnight-400 hover:text-white transition-colors">← Ver sitio</a>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-10">

        {{-- Navegación admin --}}
        <div class="flex gap-6 mb-8 border-b border-midnight-200 pb-4">
            <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-midnight-500 hover:text-midnight-900 transition-colors pb-4 -mb-4">Artículos</a>
            <a href="{{ route('admin.mensajes.index') }}" class="text-sm font-medium text-midnight-500 hover:text-midnight-900 transition-colors pb-4 -mb-4">Mensajes</a>
            <span class="text-sm font-medium text-midnight-900 border-b-2 border-gold-500 pb-4 -mb-4 flex items-center gap-2">
                Citas
                @if($pending > 0)
                    <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold bg-gold-500 text-white rounded-full">{{ $pending }}</span>
                @endif
            </span>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="text-2xl font-serif font-semibold text-midnight-900">Citas agendadas</h1>
            <div class="flex gap-2 text-sm">
                @php($estados = ['' => 'Todas', 'pendiente' => 'Pendientes', 'confirmada' => 'Confirmadas', 'cancelada' => 'Canceladas'])
                @foreach($estados as $val => $label)
                    <a href="{{ route('admin.citas.index', $val ? ['estado' => $val] : []) }}"
                       class="px-3 py-1.5 border transition-colors {{ request('estado') === $val || (!request('estado') && $val === '') ? 'bg-midnight-900 text-white border-midnight-900' : 'border-midnight-200 text-midnight-600 hover:border-midnight-400' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        @forelse($appointments as $cita)
            @php
                $badge = match($cita->status) {
                    'confirmada' => 'bg-green-100 text-green-700',
                    'cancelada'  => 'bg-midnight-100 text-midnight-500 line-through',
                    default      => 'bg-amber-100 text-amber-700',
                };
            @endphp
            <div class="mb-4 bg-white border border-midnight-100 p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-base font-serif font-semibold text-midnight-900">
                                {{ $cita->scheduled_at->locale('es')->isoFormat('ddd D MMM, HH:mm') }} hrs
                            </span>
                            <span class="text-xs font-medium px-2 py-0.5 {{ $badge }}">{{ ucfirst($cita->status) }}</span>
                        </div>
                        <p class="text-sm font-medium text-midnight-800 mt-2">{{ $cita->name }}</p>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-xs text-midnight-400">
                            <a href="mailto:{{ $cita->email }}" class="hover:text-gold-600 transition-colors">{{ $cita->email }}</a>
                            @if($cita->phone)<span>{{ $cita->phone }}</span>@endif
                            @if($cita->area)<span class="text-gold-600">{{ $cita->area }}</span>@endif
                        </div>
                        @if($cita->message)
                            <p class="mt-3 text-sm text-midnight-600 leading-relaxed bg-midnight-50 border-l-2 border-gold-300 px-3 py-2 whitespace-pre-wrap">{{ $cita->message }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if($cita->status !== 'confirmada')
                            <form method="POST" action="{{ route('admin.citas.updateStatus', $cita) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmada">
                                <button type="submit" class="text-xs font-medium text-green-600 hover:text-green-800 border border-green-200 hover:border-green-400 px-3 py-1.5 transition-colors">Confirmar</button>
                            </form>
                        @endif
                        @if($cita->status !== 'cancelada')
                            <form method="POST" action="{{ route('admin.citas.updateStatus', $cita) }}" onsubmit="return confirm('¿Cancelar esta cita? El horario quedará disponible nuevamente.')">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelada">
                                <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-600 border border-midnight-200 hover:border-red-300 px-3 py-1.5 transition-colors">Cancelar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-midnight-100 px-6 py-16 text-center">
                <p class="text-sm text-midnight-400">No hay citas {{ request('estado') ? 'con ese estado' : 'agendadas' }}.</p>
            </div>
        @endforelse

        @if($appointments->hasPages())
            <div class="mt-6">{{ $appointments->links() }}</div>
        @endif

    </main>
</body>
</html>
