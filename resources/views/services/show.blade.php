<x-layout
    :title="$area['name'] . ' — Arsa & Asociados'"
    :description="$area['meta_description']"
    :canonical="route('services.show', $area['slug'])"
>
    <x-slot:headExtra>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Service",
        "serviceType": {{ json_encode($area['name']) }},
        "provider": {
            "@@type": "LegalService",
            "name": "Arsa & Asociados",
            "url": "{{ config('app.url') }}"
        },
        "areaServed": "Santiago de Chile",
        "description": {{ json_encode($area['meta_description']) }}
    }
    </script>
    @if(!empty($area['faqs']))
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "FAQPage",
        "mainEntity": [
            @foreach($area['faqs'] as $faq)
            {
                "@@type": "Question",
                "name": {{ json_encode($faq[0]) }},
                "acceptedAnswer": { "@@type": "Answer", "text": {{ json_encode($faq[1]) }} }
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>
    @endif
    </x-slot:headExtra>

    {{-- Hero --}}
    <section class="bg-midnight-950 py-20 lg:py-28 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 relative">
            <nav class="flex items-center gap-2 text-xs text-midnight-400 mb-8" aria-label="Migas de pan">
                <a href="/" class="hover:text-gold-400 transition-colors">Inicio</a>
                <span>/</span>
                <a href="/#servicios" class="hover:text-gold-400 transition-colors">Servicios</a>
                <span>/</span>
                <span class="text-midnight-300">{{ $area['name'] }}</span>
            </nav>
            <div class="w-14 h-14 bg-gold-500/10 border border-gold-500/30 flex items-center justify-center mb-6">
                <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $area['icon'] }}"/>
                </svg>
            </div>
            <h1 class="text-3xl lg:text-5xl font-serif font-semibold text-white leading-tight mb-4">{{ $area['name'] }}</h1>
            <p class="text-lg text-midnight-300 max-w-2xl leading-relaxed">{{ $area['tagline'] }}</p>
        </div>
    </section>

    {{-- Intro + servicios --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 grid lg:grid-cols-[1.2fr_1fr] gap-12 lg:gap-16">
            <div>
                <p class="text-midnight-600 leading-relaxed text-lg">{{ $area['intro'] }}</p>
            </div>
            <div class="bg-midnight-50 p-8 border-t-2 border-gold-500">
                <h2 class="text-sm uppercase tracking-[0.2em] text-gold-600 font-semibold mb-5">Cómo le ayudamos</h2>
                <ul class="space-y-3">
                    @foreach($area['services'] as $service)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gold-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            <span class="text-sm text-midnight-700">{{ $service }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    @if(!empty($area['faqs']))
        <section class="py-16 lg:py-20 bg-midnight-50">
            <div class="max-w-3xl mx-auto px-6 lg:px-8">
                <h2 class="text-2xl lg:text-3xl font-serif font-semibold text-midnight-900 mb-10">Preguntas frecuentes</h2>
                <div class="space-y-4">
                    @foreach($area['faqs'] as $faq)
                        <details class="group bg-white border border-midnight-100 px-6 py-5">
                            <summary class="flex items-center justify-between cursor-pointer list-none">
                                <span class="text-sm font-semibold text-midnight-900 pr-4">{{ $faq[0] }}</span>
                                <svg class="w-5 h-5 text-gold-500 shrink-0 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <p class="mt-4 text-sm text-midnight-600 leading-relaxed">{{ $faq[1] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="py-16 bg-midnight-950">
        <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-2xl lg:text-3xl font-serif font-semibold text-white mb-4">¿Necesita asesoría en {{ $area['name'] }}?</h2>
            <p class="text-midnight-300 mb-8">La primera consulta es sin costo. Cuéntenos su caso y le orientamos.</p>
            <a href="{{ route('agendar.create') }}" class="inline-flex items-center px-8 py-3.5 bg-gold-500 text-midnight-950 font-semibold text-sm hover:bg-gold-400 transition-colors">
                Agendar consulta
            </a>
        </div>
    </section>

    {{-- Otras áreas --}}
    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <h2 class="text-xl font-serif font-semibold text-midnight-900 mb-8">Otras áreas de práctica</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($areas as $other)
                    @continue($other['slug'] === $area['slug'])
                    <a href="{{ route('services.show', $other['slug']) }}"
                       class="group flex items-center gap-3 p-5 border border-midnight-100 hover:border-gold-300 hover:shadow-sm transition-all">
                        <svg class="w-6 h-6 text-gold-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $other['icon'] }}"/>
                        </svg>
                        <span class="text-sm font-medium text-midnight-800 group-hover:text-gold-700 transition-colors">{{ $other['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

</x-layout>
