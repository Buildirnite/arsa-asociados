@php use Illuminate\Support\Facades\Storage; @endphp
<x-layout
    :title="($post->meta_title ?: $post->title . ' — Arsa & Asociados')"
    :description="($post->meta_description ?: $post->excerpt)"
    :canonical="route('blog.show', $post->slug)"
    :ogImage="$post->image ? Storage::url($post->image) : asset('images/logo-icon.png')"
    ogType="article"
>
    <x-slot:headExtra>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BlogPosting",
        "headline": {{ json_encode($post->meta_title ?: $post->title) }},
        "description": {{ json_encode($post->meta_description ?: $post->excerpt) }},
        "url": "{{ route('blog.show', $post->slug) }}",
        "datePublished": "{{ $post->published_at->toIso8601String() }}",
        "dateModified": "{{ $post->updated_at->toIso8601String() }}",
        "author": {
            "@@type": "Person",
            "name": "Nicool Armas",
            "jobTitle": "Abogada",
            "worksFor": {
                "@@type": "Organization",
                "name": "Arsa & Asociados"
            }
        },
        "publisher": {
            "@@type": "Organization",
            "name": "Arsa & Asociados",
            "url": "{{ config('app.url') }}"
        }@if($post->image),
        "image": "{{ Storage::url($post->image) }}"@endif
    }
    </script>
    </x-slot:headExtra>

    <article>
        {{-- Header --}}
        <header class="bg-midnight-950 py-20 lg:py-28">
            <div class="max-w-3xl mx-auto px-6 lg:px-8">
                <a href="{{ route('blog.index') }}"
                   class="inline-flex items-center gap-2 text-xs uppercase tracking-wider text-midnight-400 hover:text-gold-400 transition-colors mb-8">
                    ← Volver al blog
                </a>
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-12 bg-gold-500"></div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-medium">{{ $post->category }}</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-serif font-semibold text-white leading-tight mb-6">
                    {{ $post->title }}
                </h1>
                <div class="flex items-center gap-4 text-xs text-midnight-400">
                    <span>Nicool Armas — Abogada</span>
                    <span>·</span>
                    <span>{{ $post->published_at->format('d \d\e F \d\e Y') }}</span>
                    <span>·</span>
                    <span>Lectura: ~{{ $post->readingTime() }} min</span>
                </div>
            </div>
        </header>

        {{-- Imagen destacada --}}
        @if($post->image)
            <div class="bg-midnight-900">
                <div class="max-w-3xl mx-auto">
                    <img src="{{ Storage::url($post->image) }}"
                         alt="{{ $post->title }}"
                         class="w-full max-h-[480px] object-cover">
                </div>
            </div>
        @endif

        {{-- Contenido --}}
        <div class="py-16 bg-white">
            <div class="max-w-3xl mx-auto px-6 lg:px-8">
                <div class="prose prose-slate prose-lg max-w-none
                            prose-headings:font-serif prose-headings:text-midnight-900
                            prose-p:text-midnight-600 prose-p:leading-relaxed
                            prose-a:text-gold-600 prose-a:no-underline hover:prose-a:underline
                            prose-strong:text-midnight-800">
                    {!! $post->content !!}
                </div>

                {{-- CTA --}}
                <div class="mt-16 bg-midnight-50 p-8 border-l-4 border-gold-500">
                    <p class="text-sm font-semibold text-midnight-900 mb-2">¿Tiene dudas sobre su caso?</p>
                    <p class="text-sm text-midnight-500 mb-4">La primera consulta es sin costo. Contáctenos y le orientamos.</p>
                    <a href="{{ url('/#contacto') }}"
                       class="inline-flex items-center px-6 py-2.5 bg-midnight-900 text-white text-sm font-medium hover:bg-midnight-800 transition-colors">
                        Agendar consulta
                    </a>
                </div>
            </div>
        </div>
    </article>

    {{-- Artículos relacionados --}}
    @if($related->isNotEmpty())
        <section class="py-16 bg-midnight-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <h2 class="text-xl font-serif font-semibold text-midnight-900 mb-8">Artículos relacionados</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($related as $item)
                        <a href="{{ route('blog.show', $item->slug) }}"
                           class="group p-6 bg-white border border-midnight-100 hover:border-gold-300 transition-colors">
                            <span class="text-xs uppercase tracking-wider text-gold-600 font-semibold">{{ $item->category }}</span>
                            <h3 class="mt-2 text-base font-serif font-semibold text-midnight-900 group-hover:text-gold-700 transition-colors leading-snug">
                                {{ $item->title }}
                            </h3>
                            <p class="mt-2 text-sm text-midnight-500 line-clamp-2">{{ $item->excerpt }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layout>
