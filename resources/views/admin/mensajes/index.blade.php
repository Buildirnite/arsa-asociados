<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mensajes de contacto — Admin Arsa & Asociados</title>
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
            <a href="{{ route('admin.posts.index') }}"
               class="text-sm font-medium text-midnight-500 hover:text-midnight-900 transition-colors pb-4 -mb-4">
                Artículos
            </a>
            <span class="text-sm font-medium text-midnight-900 border-b-2 border-gold-500 pb-4 -mb-4 flex items-center gap-2">
                Mensajes
                @if($unread > 0)
                    <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold bg-gold-500 text-white rounded-full">{{ $unread }}</span>
                @endif
            </span>
        </div>

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-serif font-semibold text-midnight-900">
                Mensajes de contacto
            </h1>
            @if($unread > 0)
                <span class="text-sm text-midnight-500">{{ $unread }} sin leer</span>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @forelse($messages as $msg)
            <div class="mb-4 bg-white border {{ $msg->isRead() ? 'border-midnight-100' : 'border-gold-300' }} p-6">
                <div class="flex items-start justify-between gap-4 mb-3">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-midnight-900">{{ $msg->name }}</span>
                            @if(! $msg->isRead())
                                <span class="text-xs font-medium bg-gold-100 text-gold-700 px-2 py-0.5">Nuevo</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-4 mt-1 text-xs text-midnight-400">
                            <a href="mailto:{{ $msg->email }}" class="hover:text-gold-600 transition-colors">{{ $msg->email }}</a>
                            @if($msg->phone)
                                <span>·</span>
                                <span>{{ $msg->phone }}</span>
                            @endif
                            <span>·</span>
                            <span>{{ $msg->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    @if(! $msg->isRead())
                        <form method="POST" action="{{ route('admin.mensajes.markRead', $msg) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="text-xs font-medium text-midnight-500 hover:text-midnight-900 border border-midnight-200 hover:border-midnight-400 px-3 py-1.5 transition-colors shrink-0">
                                Marcar como leído
                            </button>
                        </form>
                    @endif
                </div>
                <p class="text-sm text-midnight-600 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
            </div>
        @empty
            <div class="bg-white border border-midnight-100 px-6 py-16 text-center">
                <p class="text-sm text-midnight-400">Aún no hay mensajes de contacto.</p>
            </div>
        @endforelse

        @if($messages->hasPages())
            <div class="mt-6">{{ $messages->links() }}</div>
        @endif

    </main>
</body>
</html>
