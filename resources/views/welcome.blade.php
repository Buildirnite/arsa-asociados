<x-layout title="Arsa & Asociados — Asesoría Jurídica en Santiago de Chile">

    @php
        $faqs = [
            ['¿La primera consulta tiene costo?', 'No. La primera consulta es sin costo y sin compromiso. Escuchamos su caso y le orientamos sobre las opciones disponibles.'],
            ['¿Atienden de forma presencial u online?', 'Ambas. Puede coordinar una reunión presencial en Santiago o una videollamada, según lo que le resulte más cómodo.'],
            ['¿Cuánto demoran en responder?', 'Respondemos los mensajes del formulario y de WhatsApp normalmente dentro del mismo día hábil.'],
            ['¿Cómo funcionan los honorarios?', 'Definimos los honorarios de forma transparente según la complejidad de cada caso y se los informamos con claridad antes de iniciar cualquier gestión.'],
            ['¿En qué áreas del derecho se especializan?', 'Atendemos Derecho Civil, Laboral, de Familia, Inmobiliario, Penal y Cobranza Judicial. Puede ver el detalle de cada área en la sección de servicios.'],
            ['¿Qué necesito para mi primera consulta?', 'Solo describirnos su situación. Si tiene documentos relacionados (contratos, notificaciones, etc.), tenerlos a mano nos ayuda a orientarle mejor.'],
        ];
    @endphp

    <x-slot:headExtra>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "FAQPage",
        "mainEntity": [
            @foreach($faqs as $faq)
            {
                "@@type": "Question",
                "name": {{ json_encode($faq[0]) }},
                "acceptedAnswer": { "@@type": "Answer", "text": {{ json_encode($faq[1]) }} }
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>
    </x-slot:headExtra>

    {{-- Hero --}}
    <section id="inicio" class="relative overflow-hidden">
        <div class="geo-wrap" aria-hidden="true">
            <div style="position:absolute;width:72px;height:72px;top:10%;right:14%;border:1px solid rgba(185,146,63,0.14);animation:geo-f2 22s ease-in-out infinite;"></div>
            <div style="position:absolute;width:44px;height:44px;bottom:18%;left:8%;border:1px solid rgba(185,146,63,0.10);animation:geo-f1 19s ease-in-out infinite 3s;"></div>
            <div style="position:absolute;width:28px;height:28px;top:45%;left:22%;background:rgba(185,146,63,0.06);animation:geo-f2 25s ease-in-out infinite 6s;"></div>
            <div style="position:absolute;width:60px;height:60px;bottom:12%;right:22%;border:1px solid rgba(185,146,63,0.08);animation:geo-f4 28s ease-in-out infinite 2s;"></div>
            <div style="position:absolute;width:20px;height:20px;top:65%;right:12%;border:1px solid rgba(185,146,63,0.12);animation:geo-f3 16s ease-in-out infinite 5s;"></div>
            <div style="position:absolute;width:100px;height:100px;top:20%;left:44%;border:1px solid rgba(185,146,63,0.07);animation:geo-f1 34s ease-in-out infinite 8s;"></div>
            <div style="position:absolute;width:18px;height:18px;top:30%;right:32%;background:rgba(185,146,63,0.09);animation:geo-f3 14s ease-in-out infinite 2s;"></div>
            <div style="position:absolute;width:52px;height:52px;bottom:30%;left:36%;border:1px solid rgba(185,146,63,0.06);animation:geo-f2 27s ease-in-out infinite 11s;"></div>
        </div>

        {{-- Split de dos columnas --}}
        <div class="grid grid-cols-1 lg:grid-cols-2">

            {{-- Columna izquierda: fondo crema --}}
            <div class="relative bg-[#F5F0E8] flex flex-col justify-center px-6 sm:px-8 lg:pl-28 lg:pr-8 xl:pl-40 xl:pr-10 py-24 lg:py-32">
                <div class="flex items-center gap-3 mb-8 reveal">
                    <div class="h-px w-12 bg-gold-500"></div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gold-700 font-medium">Asesoría Jurídica</span>
                </div>

                <h1 class="text-4xl sm:text-5xl xl:text-6xl font-serif font-semibold text-midnight-900 leading-[1.1] mb-6 reveal delay-1">
                    Formación vigente.
                    <span class="text-gold-600">Experiencia real.</span>
                </h1>

                <p class="text-lg text-midnight-700 leading-relaxed max-w-xl mb-10 reveal delay-2">
                    Conocimiento jurídico actualizado y directamente aplicado a la práctica.
                    En Arsa & Asociados recibirá asesoría estratégica con rigor técnico de primer nivel
                    y la solidez que solo otorga la experiencia real en Santiago de Chile.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 reveal delay-3">
                    <a href="{{ route('agendar.create') }}"
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-midnight-900 text-white font-semibold text-sm hover:bg-midnight-800 hover:scale-[1.03] transition-all duration-200">
                        Agendar consulta
                    </a>
                    <a href="/#servicios"
                       class="inline-flex items-center justify-center px-8 py-3.5 border border-midnight-400 text-midnight-800 text-sm font-medium hover:border-gold-500 hover:text-gold-700 transition-colors">
                        Conocer servicios
                    </a>
                </div>
            </div>

            {{-- Columna derecha: fondo midnight con foto --}}
            <div class="relative bg-midnight-950 flex items-center justify-center py-20 lg:py-16 min-h-[520px] overflow-hidden">
                {{-- Patrón de líneas diagonales sutiles --}}
                <div class="absolute inset-0 pointer-events-none" style="background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(201,168,76,0.04) 30px,rgba(201,168,76,0.04) 31px);"></div>

                {{-- Figuras geométricas animadas en columna derecha --}}
                <div class="geo-wrap" aria-hidden="true">
                    <div style="position:absolute;width:45px;height:45px;top:10%;right:8%;border:1px solid rgba(201,168,76,0.10);animation:geo-f2 28s ease-in-out infinite;"></div>
                    <div style="position:absolute;width:27px;height:27px;bottom:24%;left:7%;border:1px solid rgba(201,168,76,0.09);animation:geo-f1 25s ease-in-out infinite 3s;"></div>
                    <div style="position:absolute;width:15px;height:15px;top:52%;right:16%;background:rgba(201,168,76,0.07);animation:geo-f3 30s ease-in-out infinite 5s;"></div>
                    <div style="position:absolute;width:55px;height:55px;bottom:12%;right:22%;border:1px solid rgba(201,168,76,0.08);animation:geo-f4 35s ease-in-out infinite 2s;"></div>
                    <div style="position:absolute;width:11px;height:11px;top:28%;left:12%;border:1px solid rgba(201,168,76,0.10);animation:geo-f2 25s ease-in-out infinite 7s;"></div>
                </div>

                {{-- Foto con badge --}}
                <div class="relative z-10 w-60 sm:w-72 lg:w-72 xl:w-80 reveal delay-2">
                    {{-- Foto: el border es el marco, mismo border-radius --}}
                    <div class="aspect-[4/5] overflow-hidden"
                         style="border-radius:120px 120px 0 0;border:2px solid rgba(201,168,76,0.55);">
                        <img src="{{ asset('images/team/abogada.webp') }}" alt="Nicool Armas — Asesora Jurídica"
                             class="w-full h-full object-cover object-top">
                    </div>
                    {{-- Badge nombre --}}
                    <div class="px-5 py-3" style="background-color:#C9A84C;">
                        <p class="font-serif font-semibold text-sm leading-tight" style="color:#1a1a2e;">Nicool Armas</p>
                        <p class="text-xs tracking-wide mt-0.5" style="color:#1a1a2e;opacity:0.72;">Asesora Jurídica — Santiago de Chile</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barra de estadísticas: abarca ambas columnas, pegada al hero --}}
        <div class="grid grid-cols-2 md:grid-cols-4 bg-midnight-950">
            <div class="px-8 py-6 border-r border-midnight-800 text-center">
                <div class="text-2xl font-serif font-bold text-white">3</div>
                <div class="text-xs uppercase tracking-wider text-midnight-400 mt-1">Áreas especializadas</div>
            </div>
            <div class="px-8 py-6 md:border-r border-midnight-800 text-center">
                <div class="text-2xl font-serif font-bold text-white">+500</div>
                <div class="text-xs uppercase tracking-wider text-midnight-400 mt-1">Casos resueltos</div>
            </div>
            <div class="px-8 py-6 border-r border-t border-midnight-800 md:border-t-0 text-center" style="background-color:#F5F0E8;">
                <div class="text-2xl font-serif font-bold" style="color:#1c2233;">98%</div>
                <div class="text-xs uppercase tracking-wider mt-1" style="color:#3b4968;">Clientes satisfechos</div>
            </div>
            <div class="px-8 py-6 border-t border-midnight-800 md:border-t-0 text-center" style="background-color:#F5F0E8;">
                <div class="text-2xl font-serif font-bold" style="color:#1c2233;">24h</div>
                <div class="text-xs uppercase tracking-wider mt-1" style="color:#3b4968;">Tiempo de respuesta</div>
            </div>
        </div>
    </section>

    {{-- Servicios --}}
    <section id="servicios" class="py-24 lg:py-32 bg-white relative overflow-hidden">
        <div class="geo-wrap" aria-hidden="true">
            <div style="position:absolute;width:88px;height:88px;top:5%;right:4%;border:1.5px solid rgba(185,146,63,0.30);animation:geo-f2 26s ease-in-out infinite;"></div>
            <div style="position:absolute;width:56px;height:56px;bottom:8%;left:4%;border:1.5px solid rgba(28,34,51,0.22);animation:geo-f1 21s ease-in-out infinite 4s;"></div>
            <div style="position:absolute;width:36px;height:36px;top:12%;left:7%;background:rgba(185,146,63,0.14);animation:geo-f2 18s ease-in-out infinite 2s;"></div>
            <div style="position:absolute;width:72px;height:72px;bottom:14%;right:7%;border:1.5px solid rgba(28,34,51,0.20);animation:geo-f4 30s ease-in-out infinite 7s;"></div>
            <div style="position:absolute;width:24px;height:24px;top:55%;left:48%;border:1.5px solid rgba(185,146,63,0.28);animation:geo-f3 15s ease-in-out infinite 1s;"></div>
            <div style="position:absolute;width:48px;height:48px;top:35%;right:22%;border:1.5px solid rgba(185,146,63,0.22);animation:geo-f1 20s ease-in-out infinite 9s;"></div>
            <div style="position:absolute;width:20px;height:20px;bottom:35%;left:24%;background:rgba(28,34,51,0.12);animation:geo-f3 13s ease-in-out infinite 5s;"></div>
            <div style="position:absolute;width:110px;height:110px;top:60%;right:30%;border:1px solid rgba(185,146,63,0.14);animation:geo-f4 38s ease-in-out infinite 6s;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
            <div class="max-w-2xl mb-16 reveal">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-12 bg-gold-500"></div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gold-600 font-semibold">Áreas de práctica</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-serif font-semibold text-midnight-900 mb-4">
                    Servicios legales especializados
                </h2>
                <p class="text-midnight-500 leading-relaxed">
                    Ofrecemos soluciones jurídicas integrales adaptadas a las necesidades de cada cliente,
                    con un enfoque estratégico y personalizado.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach(\App\Support\PracticeAreas::all() as $area)
                    <a href="{{ route('services.show', $area['slug']) }}"
                       class="group p-8 border border-midnight-100 hover:border-gold-300 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 reveal{{ $loop->index ? ' delay-' . $loop->index : '' }}">
                        <div class="w-12 h-12 bg-gold-50 flex items-center justify-center mb-6 group-hover:bg-gold-100 transition-colors">
                            <svg class="w-6 h-6 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $area['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-serif font-semibold text-midnight-900 mb-3">{{ $area['name'] }}</h3>
                        <p class="text-sm text-midnight-500 leading-relaxed">{{ $area['tagline'] }}</p>
                        <span class="inline-flex items-center gap-1 mt-4 text-sm font-medium text-gold-600 group-hover:gap-2 transition-all">
                            Ver más
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Nosotros --}}
    <section id="nosotros" class="py-24 lg:py-32 bg-midnight-950 relative overflow-hidden">
        <div class="geo-wrap" aria-hidden="true">
            <div style="position:absolute;width:80px;height:80px;top:8%;right:6%;border:1px solid rgba(185,146,63,0.14);animation:geo-f1 24s ease-in-out infinite;"></div>
            <div style="position:absolute;width:48px;height:48px;bottom:10%;left:5%;border:1px solid rgba(185,146,63,0.09);animation:geo-f2 20s ease-in-out infinite 5s;"></div>
            <div style="position:absolute;width:32px;height:32px;top:38%;right:14%;background:rgba(185,146,63,0.06);animation:geo-f3 22s ease-in-out infinite 3s;"></div>
            <div style="position:absolute;width:64px;height:64px;top:18%;left:4%;border:1px solid rgba(185,146,63,0.08);animation:geo-f4 27s ease-in-out infinite 1s;"></div>
            <div style="position:absolute;width:22px;height:22px;top:65%;left:40%;border:1px solid rgba(185,146,63,0.12);animation:geo-f2 16s ease-in-out infinite 7s;"></div>
            <div style="position:absolute;width:96px;height:96px;bottom:20%;right:10%;border:1px solid rgba(185,146,63,0.07);animation:geo-f1 32s ease-in-out infinite 4s;"></div>
            <div style="position:absolute;width:40px;height:40px;top:50%;right:38%;background:rgba(185,146,63,0.05);animation:geo-f3 19s ease-in-out infinite 10s;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- Columna izquierda: texto + cita + valores --}}
                <div class="reveal reveal-left">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-px w-12 bg-gold-500"></div>
                        <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-semibold">Sobre nosotros</span>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-serif font-semibold text-white mb-6">
                        Compromiso con la excelencia jurídica
                    </h2>
                    <p class="text-midnight-300 leading-relaxed mb-6">
                        En <strong class="text-white">Arsa & Asociados</strong> creemos que cada caso merece una atención dedicada y personalizada.
                        Nuestro trabajo integra rigor técnico actualizado con un profundo sentido ético,
                        para entregar soluciones jurídicas concretas y efectivas.
                    </p>

                    {{-- Cita con borde dorado izquierdo --}}
                    <blockquote class="border-l-2 border-gold-500 pl-6 py-1 mb-8">
                        <p class="text-midnight-300 italic font-serif text-base leading-relaxed">
                            "Formación jurídica de primer nivel — reciente, vigente y profundamente arraigada en la práctica real."
                        </p>
                        <cite class="block mt-2 text-xs text-gold-400 not-italic font-semibold tracking-wider uppercase">— Nicool Armas, Asesora Jurídica</cite>
                    </blockquote>

                    {{-- Grid 2×2 de valores --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-start gap-3 p-4 border border-midnight-800 hover:border-gold-500/40 transition-colors">
                            <svg class="w-5 h-5 text-gold-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-midnight-200 font-medium">Atención personalizada</span>
                        </div>
                        <div class="flex items-start gap-3 p-4 border border-midnight-800 hover:border-gold-500/40 transition-colors">
                            <svg class="w-5 h-5 text-gold-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-midnight-200 font-medium">Transparencia total</span>
                        </div>
                        <div class="flex items-start gap-3 p-4 border border-midnight-800 hover:border-gold-500/40 transition-colors">
                            <svg class="w-5 h-5 text-gold-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-midnight-200 font-medium">Visión estratégica</span>
                        </div>
                        <div class="flex items-start gap-3 p-4 border border-midnight-800 hover:border-gold-500/40 transition-colors">
                            <svg class="w-5 h-5 text-gold-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-midnight-200 font-medium">Resultados concretos</span>
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: foto con marco y badge --}}
                <div class="relative reveal reveal-right">
                    <div class="relative max-w-sm mx-auto lg:mx-0 lg:ml-auto">
                        {{-- Foto: border dorado directo, marco recto --}}
                        <div class="aspect-[4/5] overflow-hidden"
                             style="border:2px solid rgba(201,168,76,0.55);">
                            <img src="{{ asset('images/team/abgd2.webp') }}" alt="Nicool Armas — Asesora Jurídica" class="w-full h-full object-cover object-top">
                        </div>
                        {{-- Badge con nombre --}}
                        <div class="bg-midnight-900 border-t border-gold-500/40 px-6 py-4">
                            <p class="text-white font-serif font-semibold">Nicool Armas</p>
                            <p class="text-gold-400 text-xs tracking-widest uppercase mt-0.5">Asesora Jurídica</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Cómo trabajamos --}}
    <section class="py-24 lg:py-32 bg-midnight-950 relative overflow-hidden">
        <div class="geo-wrap" aria-hidden="true">
            <div style="position:absolute;width:76px;height:76px;top:10%;left:4%;border:1px solid rgba(185,146,63,0.13);animation:geo-f2 23s ease-in-out infinite;"></div>
            <div style="position:absolute;width:52px;height:52px;bottom:14%;right:6%;border:1px solid rgba(185,146,63,0.09);animation:geo-f1 19s ease-in-out infinite 4s;"></div>
            <div style="position:absolute;width:40px;height:40px;top:50%;right:18%;background:rgba(185,146,63,0.05);animation:geo-f2 28s ease-in-out infinite 2s;"></div>
            <div style="position:absolute;width:28px;height:28px;bottom:28%;left:14%;border:1px solid rgba(185,146,63,0.11);animation:geo-f3 17s ease-in-out infinite 6s;"></div>
            <div style="position:absolute;width:64px;height:64px;top:6%;right:28%;border:1px solid rgba(185,146,63,0.07);animation:geo-f4 32s ease-in-out infinite 3s;"></div>
            <div style="position:absolute;width:36px;height:36px;top:40%;left:30%;border:1px solid rgba(185,146,63,0.10);animation:geo-f1 21s ease-in-out infinite 9s;"></div>
            <div style="position:absolute;width:18px;height:18px;bottom:40%;right:36%;background:rgba(185,146,63,0.07);animation:geo-f3 15s ease-in-out infinite 3s;"></div>
            <div style="position:absolute;width:90px;height:90px;bottom:8%;left:32%;border:1px solid rgba(185,146,63,0.06);animation:geo-f2 36s ease-in-out infinite 5s;"></div>
        </div>
        <div class="max-w-4xl mx-auto px-6 lg:px-8 relative">

            <div class="max-w-2xl mb-20 reveal">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-12 bg-gold-500"></div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-semibold">Nuestro proceso</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-serif font-semibold text-white">
                    Tres pasos hacia la resolución de su caso
                </h2>
            </div>

            {{-- Timeline alternado --}}
            <div class="relative">
                {{-- Línea vertical central dorada --}}
                <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-gold-500/10 via-gold-500/50 to-gold-500/10 -translate-x-1/2 pointer-events-none"></div>

                {{-- Paso 1: contenido izquierda, círculo centro --}}
                <div class="md:grid md:grid-cols-[1fr_5rem_1fr] md:items-center mb-14 md:mb-20">
                    <div class="border-l-2 border-gold-500/30 pl-5 md:border-0 md:pl-0 md:pr-14 md:text-right reveal reveal-right">
                        <div class="text-xs font-semibold text-gold-500 uppercase tracking-widest mb-2">01</div>
                        <h3 class="text-xl font-serif font-semibold text-white mb-3">Consulta inicial</h3>
                        <p class="text-sm text-midnight-400 leading-relaxed">
                            Sin costo y sin compromisos. Escuchamos su situación, evaluamos su caso
                            y le entregamos una orientación jurídica clara desde el primer contacto.
                        </p>
                    </div>
                    <div class="hidden md:flex justify-center items-center z-10">
                        <div class="w-16 h-16 rounded-full border-2 border-gold-500 bg-midnight-900 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="hidden md:block"></div>
                </div>

                {{-- Paso 2: círculo centro, contenido derecha --}}
                <div class="md:grid md:grid-cols-[1fr_5rem_1fr] md:items-center mb-14 md:mb-20">
                    <div class="hidden md:block"></div>
                    <div class="hidden md:flex justify-center items-center z-10">
                        <div class="w-16 h-16 rounded-full border-2 border-gold-500 bg-midnight-900 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="border-l-2 border-gold-500/30 pl-5 md:border-0 md:pl-14 reveal reveal-left">
                        <div class="text-xs font-semibold text-gold-500 uppercase tracking-widest mb-2">02</div>
                        <h3 class="text-xl font-serif font-semibold text-white mb-3">Análisis estratégico</h3>
                        <p class="text-sm text-midnight-400 leading-relaxed">
                            Estudiamos en profundidad los antecedentes legales de su caso y diseñamos
                            una estrategia jurídica personalizada y fundamentada.
                        </p>
                    </div>
                </div>

                {{-- Paso 3: contenido izquierda, círculo centro --}}
                <div class="md:grid md:grid-cols-[1fr_5rem_1fr] md:items-center">
                    <div class="border-l-2 border-gold-500/30 pl-5 md:border-0 md:pl-0 md:pr-14 md:text-right reveal reveal-right">
                        <div class="text-xs font-semibold text-gold-500 uppercase tracking-widest mb-2">03</div>
                        <h3 class="text-xl font-serif font-semibold text-white mb-3">Resolución efectiva</h3>
                        <p class="text-sm text-midnight-400 leading-relaxed">
                            Ejecutamos la estrategia con precisión, manteniéndole informado en cada
                            etapa hasta alcanzar el resultado que su caso merece.
                        </p>
                    </div>
                    <div class="hidden md:flex justify-center items-center z-10">
                        <div class="w-16 h-16 rounded-full border-2 border-gold-500 bg-midnight-900 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.745 3.745 0 013.296-1.043A3.745 3.745 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="hidden md:block"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonios --}}
    <section id="testimonios" class="py-24 lg:py-32 bg-midnight-50 relative overflow-hidden">
        <div class="geo-wrap" aria-hidden="true">
            <div style="position:absolute;width:84px;height:84px;top:5%;right:4%;border:1.5px solid rgba(185,146,63,0.30);animation:geo-f1 25s ease-in-out infinite;"></div>
            <div style="position:absolute;width:44px;height:44px;bottom:10%;left:6%;border:1.5px solid rgba(28,34,51,0.22);animation:geo-f2 20s ease-in-out infinite 3s;"></div>
            <div style="position:absolute;width:28px;height:28px;top:30%;left:10%;background:rgba(185,146,63,0.14);animation:geo-f3 18s ease-in-out infinite 7s;"></div>
            <div style="position:absolute;width:60px;height:60px;top:58%;right:8%;border:1.5px solid rgba(28,34,51,0.20);animation:geo-f4 22s ease-in-out infinite 1s;"></div>
            <div style="position:absolute;width:50px;height:50px;top:15%;left:36%;border:1.5px solid rgba(185,146,63,0.24);animation:geo-f2 17s ease-in-out infinite 6s;"></div>
            <div style="position:absolute;width:20px;height:20px;bottom:28%;right:26%;background:rgba(28,34,51,0.10);animation:geo-f1 12s ease-in-out infinite 4s;"></div>
            <div style="position:absolute;width:78px;height:78px;bottom:18%;left:42%;border:1px solid rgba(185,146,63,0.16);animation:geo-f4 29s ease-in-out infinite 10s;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">

            <div class="max-w-2xl mb-16 reveal">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-12 bg-gold-500"></div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gold-600 font-semibold">Testimonios</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-serif font-semibold text-midnight-900">
                    Lo que dicen nuestros clientes
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Testimonio 1 --}}
                <figure class="bg-white p-8 flex flex-col gap-6 border border-midnight-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 reveal">
                    <svg class="w-8 h-8 text-gold-300" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                        <path d="M10 8C6.686 8 4 10.686 4 14v10h10V14H7.5C7.5 11.515 9.015 10 10 10V8zm16 0c-3.314 0-6 2.686-6 6v10h10V14h-6.5C23.5 11.515 25.015 10 26 10V8z"/>
                    </svg>
                    <blockquote class="text-midnight-700 font-serif leading-relaxed text-[15px] flex-1">
                        "Desde el primer momento sentí que mi caso estaba en manos de alguien que realmente conoce el derecho. La orientación fue clara, oportuna y completamente adaptada a mi situación."
                    </blockquote>
                    <figcaption class="border-t border-midnight-100 pt-5">
                        <span class="block text-sm font-semibold text-gold-600">M. González</span>
                        <span class="block text-xs text-midnight-400 mt-0.5">Cliente — Derecho de Familia</span>
                    </figcaption>
                </figure>

                {{-- Testimonio 2 --}}
                <figure class="bg-white p-8 flex flex-col gap-6 border border-midnight-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 reveal delay-2">
                    <svg class="w-8 h-8 text-gold-300" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                        <path d="M10 8C6.686 8 4 10.686 4 14v10h10V14H7.5C7.5 11.515 9.015 10 10 10V8zm16 0c-3.314 0-6 2.686-6 6v10h10V14h-6.5C23.5 11.515 25.015 10 26 10V8z"/>
                    </svg>
                    <blockquote class="text-midnight-700 font-serif leading-relaxed text-[15px] flex-1">
                        "Excelente profesionalismo y trato cercano. Me explicaron cada etapa del proceso de manera comprensible y me acompañaron hasta resolver el conflicto laboral con resultados concretos."
                    </blockquote>
                    <figcaption class="border-t border-midnight-100 pt-5">
                        <span class="block text-sm font-semibold text-gold-600">R. Sepúlveda</span>
                        <span class="block text-xs text-midnight-400 mt-0.5">Cliente — Derecho Laboral</span>
                    </figcaption>
                </figure>

                {{-- Testimonio 3 --}}
                <figure class="bg-white p-8 flex flex-col gap-6 border border-midnight-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 reveal delay-4">
                    <svg class="w-8 h-8 text-gold-300" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                        <path d="M10 8C6.686 8 4 10.686 4 14v10h10V14H7.5C7.5 11.515 9.015 10 10 10V8zm16 0c-3.314 0-6 2.686-6 6v10h10V14h-6.5C23.5 11.515 25.015 10 26 10V8z"/>
                    </svg>
                    <blockquote class="text-midnight-700 font-serif leading-relaxed text-[15px] flex-1">
                        "La asesoría en la compraventa de mi propiedad fue impecable. Revisaron cada detalle del contrato con una precisión y un conocimiento actualizado que me dieron total tranquilidad."
                    </blockquote>
                    <figcaption class="border-t border-midnight-100 pt-5">
                        <span class="block text-sm font-semibold text-gold-600">C. Muñoz</span>
                        <span class="block text-xs text-midnight-400 mt-0.5">Cliente — Derecho Inmobiliario</span>
                    </figcaption>
                </figure>

            </div>
        </div>
    </section>

    {{-- Contacto --}}
    {{-- Preguntas frecuentes --}}
    <section id="faq" class="py-24 lg:py-32 bg-white relative overflow-hidden">
        <div class="max-w-3xl mx-auto px-6 lg:px-8 relative">
            <div class="max-w-2xl mb-12 reveal">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-12 bg-gold-500"></div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gold-600 font-semibold">Preguntas frecuentes</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-serif font-semibold text-midnight-900">
                    Resolvemos sus dudas
                </h2>
            </div>
            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <details class="group bg-midnight-50 border border-midnight-100 px-6 py-5 reveal">
                        <summary class="flex items-center justify-between cursor-pointer list-none">
                            <span class="text-base font-semibold text-midnight-900 pr-4">{{ $faq[0] }}</span>
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

    <section id="contacto" class="py-24 lg:py-32 bg-white relative overflow-hidden">
        <div class="geo-wrap" aria-hidden="true">
            <div style="position:absolute;width:80px;height:80px;top:8%;right:5%;border:1.5px solid rgba(185,146,63,0.30);animation:geo-f2 24s ease-in-out infinite;"></div>
            <div style="position:absolute;width:56px;height:56px;bottom:12%;left:4%;border:1.5px solid rgba(28,34,51,0.22);animation:geo-f1 20s ease-in-out infinite 4s;"></div>
            <div style="position:absolute;width:36px;height:36px;top:42%;left:44%;background:rgba(185,146,63,0.14);animation:geo-f2 26s ease-in-out infinite 2s;"></div>
            <div style="position:absolute;width:68px;height:68px;top:15%;left:7%;border:1.5px solid rgba(28,34,51,0.18);animation:geo-f4 29s ease-in-out infinite 6s;"></div>
            <div style="position:absolute;width:24px;height:24px;bottom:24%;right:14%;border:1.5px solid rgba(185,146,63,0.28);animation:geo-f3 16s ease-in-out infinite 3s;"></div>
            <div style="position:absolute;width:44px;height:44px;top:28%;right:28%;border:1.5px solid rgba(185,146,63,0.22);animation:geo-f1 18s ease-in-out infinite 8s;"></div>
            <div style="position:absolute;width:16px;height:16px;top:70%;left:20%;background:rgba(28,34,51,0.12);animation:geo-f2 11s ease-in-out infinite 5s;"></div>
            <div style="position:absolute;width:92px;height:92px;bottom:16%;right:32%;border:1px solid rgba(185,146,63,0.14);animation:geo-f3 33s ease-in-out infinite 7s;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div class="reveal reveal-left">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-px w-12 bg-gold-500"></div>
                        <span class="text-xs uppercase tracking-[0.3em] text-gold-600 font-semibold">Contacto</span>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-serif font-semibold text-midnight-900 mb-4">
                        Conversemos sobre su caso
                    </h2>
                    <p class="text-midnight-500 leading-relaxed mb-10">
                        La primera consulta es sin costo. Escríbanos y responderemos a la brevedad
                        para orientarlo en su situación legal.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-midnight-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-midnight-900">Dirección</h4>
                                <p class="text-sm text-midnight-500 mt-1">Santiago de Chile</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-midnight-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-midnight-900">Teléfono</h4>
                                <img src="{{ asset('images/ui/telefono.webp') }}" alt="Número de teléfono" class="-mt-3 -ml-1 h-10">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Formulario --}}
                <div class="bg-midnight-50 p-8 lg:p-10 reveal reveal-right delay-3">

                    @if(session('success'))
                        <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 px-4 py-4">
                            <svg class="w-5 h-5 text-green-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Anti-bots: campo trampa (honeypot). Invisible para humanos; los bots lo rellenan. --}}
                        <div style="position:absolute;left:-9999px;top:-9999px;" aria-hidden="true">
                            <label for="website">No rellenar este campo</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        {{-- Anti-bots: marca de tiempo de carga (time-trap) --}}
                        <input type="hidden" name="form_loaded_at" value="{{ now()->timestamp }}">

                        <div>
                            <label for="name" class="block text-sm font-medium text-midnight-700 mb-2">Nombre completo</label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                   class="w-full px-4 py-3 bg-white border text-sm text-midnight-900 placeholder-midnight-400 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors {{ $errors->has('name') ? 'border-red-400' : 'border-midnight-200' }}"
                                   placeholder="Su nombre">
                            @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-midnight-700 mb-2">Correo electrónico</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-white border text-sm text-midnight-900 placeholder-midnight-400 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors {{ $errors->has('email') ? 'border-red-400' : 'border-midnight-200' }}"
                                   placeholder="correo@ejemplo.com">
                            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-midnight-700 mb-2">Teléfono</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 bg-white border border-midnight-200 text-sm text-midnight-900 placeholder-midnight-400 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors"
                                   placeholder="+569 12345678">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-midnight-700 mb-2">Describa su consulta</label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full px-4 py-3 bg-white border text-sm text-midnight-900 placeholder-midnight-400 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors resize-none {{ $errors->has('message') ? 'border-red-400' : 'border-midnight-200' }}"
                                      placeholder="Cuéntenos brevemente su situación...">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit"
                                class="w-full px-8 py-3.5 bg-midnight-900 text-white font-semibold text-sm hover:bg-midnight-800 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                            Enviar consulta
                        </button>
                        <p class="text-xs text-midnight-400 text-center">
                            Al enviar acepta nuestra <a href="{{ route('legal.privacy') }}" class="underline hover:text-midnight-600 transition-colors">política de privacidad</a>.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layout>
