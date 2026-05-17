<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog — Admin Arsa & Asociados</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-midnight-50 font-sans antialiased">

    <header class="bg-midnight-950 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Arsa & Asociados" class="h-10 w-auto object-contain">
        </div>
        <a href="{{ url('/') }}" class="text-xs text-midnight-400 hover:text-white transition-colors">← Ver sitio</a>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-10">

        {{-- Navegación admin --}}
        <div class="flex gap-6 mb-8 border-b border-midnight-200 pb-4">
            <span class="text-sm font-medium text-midnight-900 border-b-2 border-gold-500 pb-4 -mb-4">
                Artículos
            </span>
            <a href="{{ route('admin.mensajes.index') }}"
               class="text-sm font-medium text-midnight-500 hover:text-midnight-900 transition-colors pb-4 -mb-4">
                Mensajes
            </a>
        </div>

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-serif font-semibold text-midnight-900">Artículos del blog</h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.posts.export') }}"
                   class="px-5 py-2.5 border border-midnight-300 text-midnight-600 text-sm font-medium hover:border-midnight-500 hover:text-midnight-900 transition-colors">
                    Exportar CSV
                </a>
                <a href="{{ route('admin.posts.create') }}"
                   class="px-5 py-2.5 bg-midnight-900 text-white text-sm font-medium hover:bg-midnight-800 transition-colors">
                    + Nuevo artículo
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-midnight-100">
            @forelse($posts as $post)
                <div class="flex items-center justify-between px-6 py-4 border-b border-midnight-50 last:border-0 hover:bg-midnight-50 transition-colors">
                    <div class="flex-1 min-w-0 mr-6">
                        <p class="text-sm font-medium text-midnight-900 truncate">{{ $post->title }}</p>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-xs text-gold-600">{{ $post->category }}</span>
                            <span class="text-xs text-midnight-400">
                                @if($post->isPublished())
                                    Publicado · {{ $post->published_at->format('d M Y') }}
                                @elseif($post->isScheduled())
                                    <span class="text-blue-500">Programado · {{ $post->published_at->format('d M Y H:i') }}</span>
                                @else
                                    Borrador
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        @if($post->isPublished())
                            <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                               class="text-xs text-midnight-400 hover:text-midnight-700 transition-colors">Ver</a>
                        @endif
                        <a href="{{ route('admin.posts.edit', $post) }}"
                           class="text-xs font-medium text-gold-600 hover:text-gold-700 transition-colors">Editar</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                              onsubmit="return confirm('¿Eliminar este artículo?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600 transition-colors">Eliminar</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-sm text-midnight-400">
                    No hay artículos. <a href="{{ route('admin.posts.create') }}" class="text-gold-600 hover:underline">Crear el primero</a>.
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="mt-6">{{ $posts->links() }}</div>
        @endif

    </main>
</body>
</html>
