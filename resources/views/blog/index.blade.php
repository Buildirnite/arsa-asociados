@php use Illuminate\Support\Facades\Storage; @endphp
<x-layout
    title="Blog jurídico — Arsa & Asociados"
    description="Artículos legales sobre derecho civil, laboral y de familia en Chile. Información clara para entender sus derechos."
>

    {{-- Hero --}}
    <section class="bg-midnight-950 py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-px w-12 bg-gold-500"></div>
                <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-medium">Artículos legales</span>
            </div>
            <h1 class="text-4xl lg:text-5xl font-serif font-semibold text-white">
                Blog jurídico
            </h1>
            <p class="mt-4 text-midnight-300 max-w-xl leading-relaxed">
                Información legal clara y útil para que pueda entender sus derechos y tomar mejores decisiones.
            </p>
        </div>
    </section>

    {{-- Posts --}}
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Búsqueda y filtros --}}
            <div class="mb-12 space-y-5">

                {{-- Barra de búsqueda --}}
                <form method="GET" action="{{ route('blog.index') }}" class="flex gap-3 max-w-xl">
                    @if($categoria)
                        <input type="hidden" name="categoria" value="{{ $categoria }}">
                    @endif
                    <input type="text" name="buscar" value="{{ $buscar }}"
                           placeholder="Buscar en el blog..."
                           class="flex-1 px-4 py-2.5 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                    <button type="submit"
                            class="px-5 py-2.5 bg-midnight-900 text-white text-sm font-medium hover:bg-midnight-800 transition-colors">
                        Buscar
                    </button>
                    @if($buscar || $categoria)
                        <a href="{{ route('blog.index') }}"
                           class="px-4 py-2.5 border border-midnight-200 text-sm text-midnight-600 hover:border-midnight-400 transition-colors">
                            Limpiar
                        </a>
                    @endif
                </form>

                {{-- Pills de categoría --}}
                @if($categorias->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('blog.index', array_filter(['buscar' => $buscar])) }}"
                           class="px-3 py-1.5 text-xs font-medium border transition-colors
                                  {{ ! $categoria ? 'bg-midnight-900 text-white border-midnight-900' : 'border-midnight-200 text-midnight-600 hover:border-midnight-500 hover:text-midnight-900' }}">
                            Todos
                        </a>
                        @foreach($categorias as $cat)
                            <a href="{{ route('blog.index', array_filter(['buscar' => $buscar, 'categoria' => $cat])) }}"
                               class="px-3 py-1.5 text-xs font-medium border transition-colors
                                      {{ $categoria === $cat ? 'bg-midnight-900 text-white border-midnight-900' : 'border-midnight-200 text-midnight-600 hover:border-midnight-500 hover:text-midnight-900' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>

            @if($posts->isEmpty())
                <div class="text-center py-24">
                    @if($buscar || $categoria)
                        <p class="text-midnight-400 text-sm">No se encontraron artículos con esos criterios.</p>
                        <a href="{{ route('blog.index') }}" class="mt-4 inline-block text-sm text-gold-600 hover:underline">Ver todos los artículos</a>
                    @else
                        <p class="text-midnight-400 text-sm">Próximamente publicaremos artículos de interés legal.</p>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article class="group flex flex-col border border-midnight-100 hover:border-gold-300 transition-colors">
                            @if($post->image)
                                <div class="overflow-hidden">
                                    <img src="{{ Storage::url($post->image) }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif
                            <div class="p-8 flex flex-col flex-1">
                                <div class="mb-4">
                                    <span class="text-xs uppercase tracking-wider text-gold-600 font-semibold">{{ $post->category }}</span>
                                </div>
                                <h2 class="text-lg font-serif font-semibold text-midnight-900 mb-3 leading-snug group-hover:text-gold-700 transition-colors">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-sm text-midnight-500 leading-relaxed flex-1">{{ $post->excerpt }}</p>
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-xs text-midnight-400">
                                        <span>{{ $post->published_at->format('d M Y') }}</span>
                                        <span>·</span>
                                        <span>~{{ $post->readingTime() }} min</span>
                                    </div>
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                       class="text-xs font-semibold text-gold-600 hover:text-gold-700 uppercase tracking-wider transition-colors">
                                        Leer más →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($posts->hasPages())
                    <div class="mt-16 flex justify-center gap-2">
                        {{ $posts->links() }}
                    </div>
                @endif
            @endif

        </div>
    </section>

</x-layout>
