<x-layout
    title="Abogados en Santiago — Zonas de atención | Arsa & Asociados"
    description="Asesoría jurídica en toda la Región Metropolitana: Santiago Centro, Estación Central, Maipú, Puente Alto y más. Primera consulta sin costo, atención por videollamada."
    :canonical="route('service-areas.index')"
>
    {{-- Hero --}}
    <section class="bg-midnight-950 py-20 lg:py-28 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 relative">
            <nav class="flex items-center gap-2 text-xs text-midnight-400 mb-8" aria-label="Migas de pan">
                <a href="/" class="hover:text-gold-400 transition-colors">Inicio</a>
                <span>/</span>
                <span class="text-midnight-300">Zonas de atención</span>
            </nav>
            <h1 class="text-3xl lg:text-5xl font-serif font-semibold text-white leading-tight mb-4">Abogados en toda la Región Metropolitana</h1>
            <p class="text-lg text-midnight-300 max-w-2xl leading-relaxed">
                No tenemos una oficina física única: atendemos por videollamada a personas y empresas de toda
                Santiago, y coordinamos encuentros presenciales cuando el caso lo requiere. Esto es lo que
                permite atender igual de bien a alguien de Puente Alto que a alguien de Providencia.
            </p>
        </div>
    </section>

    {{-- Comunas destacadas --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <h2 class="text-xl font-serif font-semibold text-midnight-900 mb-2">Comunas donde más nos consultan</h2>
            <p class="text-sm text-midnight-500 mb-10">Cada una con su propia página: perfil de consultas típico, y notas sobre los tribunales que corresponden.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($featured as $area)
                    <a href="{{ route('service-areas.show', $area['slug']) }}"
                       class="group flex flex-col gap-3 p-6 border border-midnight-100 hover:border-gold-300 hover:shadow-sm transition-all">
                        <svg class="w-6 h-6 text-gold-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-base font-semibold text-midnight-900 group-hover:text-gold-700 transition-colors">{{ $area['name'] }}</h3>
                            <p class="text-sm text-midnight-500 mt-1 leading-relaxed">{{ $area['tagline'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Resto de comunas --}}
    <section class="py-16 lg:py-20 bg-midnight-50">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <h2 class="text-xl font-serif font-semibold text-midnight-900 mb-2">También atendemos en</h2>
            <p class="text-sm text-midnight-500 mb-8">Toda la Región Metropolitana, aunque estas comunas todavía no tienen una página propia en el sitio.</p>
            <div class="flex flex-wrap gap-x-3 gap-y-2">
                @foreach($others as $comuna)
                    <span class="text-sm text-midnight-700 bg-white border border-midnight-100 px-3.5 py-1.5">{{ $comuna }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-midnight-950">
        <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-2xl lg:text-3xl font-serif font-semibold text-white mb-4">¿Su comuna no aparece con página propia?</h2>
            <p class="text-midnight-300 mb-8">Igual le atendemos. La primera consulta es sin costo, por videollamada.</p>
            <a href="{{ route('agendar.create') }}" class="inline-flex items-center px-8 py-3.5 bg-gold-500 text-midnight-950 font-semibold text-sm hover:bg-gold-400 transition-colors">
                Agendar consulta
            </a>
        </div>
    </section>

</x-layout>
