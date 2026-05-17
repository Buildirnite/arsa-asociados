<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $metaTitle       = $title ?? 'Arsa & Asociados — Estudio Jurídico en Santiago de Chile';
        $metaDescription = $description ?? 'Asesoría legal integral en derecho civil, laboral y de familia. Atención personalizada y primera consulta sin costo en Santiago de Chile.';
        $metaUrl         = $canonical ?? url()->current();
        $ogImage         = $ogImage ?? asset('images/logo-icon.png');
        $ogType          = $ogType ?? 'website';
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-icon.png') }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="{{ $ogType }}">
    <meta property="og:url"         content="{{ $metaUrl }}">
    <meta property="og:title"       content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:locale"      content="es_CL">
    <meta property="og:site_name"   content="Arsa & Asociados">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary">
    <meta name="twitter:title"       content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">

    {{-- Structured data: Local Business --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "LegalService",
        "name": "Arsa & Asociados",
        "description": "Estudio jurídico especializado en derecho civil, laboral y de familia en Santiago de Chile.",
        "url": "{{ config('app.url') }}",
        "telephone": "+56930676693",
        "email": "contacto@arsayasociados.cl",
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": "Santiago",
            "addressCountry": "CL"
        },
        "areaServed": {
            "@@type": "City",
            "name": "Santiago de Chile"
        },
        "priceRange": "$$",
        "openingHours": "Mo-Fr 09:00-18:00"
    }
    </script>

    {{-- Fuentes --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {!! $headExtra ?? '' !!}
</head>
<body class="min-h-screen flex flex-col bg-white text-midnight-900 font-sans antialiased">

    {{-- Navbar --}}
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-midnight-100">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">

                {{-- Logo --}}
                <a href="/" class="flex items-center group">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Arsa & Asociados — Estudio Jurídico"
                         class="h-23 w-auto object-contain transition-opacity group-hover:opacity-80">
                </a>

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="/"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors {{ request()->is('/') ? '!text-midnight-900 border-b-2 border-gold-500 pb-0.5' : '' }}">
                        Inicio
                    </a>
                    <a href="/#servicios"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors">
                        Servicios
                    </a>
                    <a href="/#nosotros"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors">
                        Nosotros
                    </a>
                    <a href="/#testimonios"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors">
                        Testimonios
                    </a>
                    <a href="{{ route('blog.index') }}"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors {{ request()->routeIs('blog.*') ? '!text-midnight-900 border-b-2 border-gold-500 pb-0.5' : '' }}">
                        Blog
                    </a>
                    <a href="/#contacto"
                       class="inline-flex items-center px-5 py-2.5 bg-midnight-900 text-white text-sm font-medium hover:bg-midnight-800 transition-colors">
                        Contacto
                    </a>
                </div>

                {{-- Mobile hamburger --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 text-midnight-700 hover:text-midnight-900" aria-label="Abrir menú">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile menu --}}
            <div id="mobile-menu" class="hidden md:hidden pb-6 border-t border-midnight-100">
                <div class="flex flex-col gap-4 pt-4">
                    <a href="/" class="text-sm font-medium text-midnight-700 hover:text-midnight-900 transition-colors">Inicio</a>
                    <a href="/#servicios" class="text-sm font-medium text-midnight-700 hover:text-midnight-900 transition-colors">Servicios</a>
                    <a href="/#nosotros" class="text-sm font-medium text-midnight-700 hover:text-midnight-900 transition-colors">Nosotros</a>
                    <a href="/#testimonios" class="text-sm font-medium text-midnight-700 hover:text-midnight-900 transition-colors">Testimonios</a>
                    <a href="{{ route('blog.index') }}" class="text-sm font-medium text-midnight-700 hover:text-midnight-900 transition-colors">Blog</a>
                    <a href="/#contacto" class="inline-flex items-center justify-center px-5 py-2.5 bg-midnight-900 text-white text-sm font-medium hover:bg-midnight-800 transition-colors">Contacto</a>
                </div>
            </div>
        </nav>
    </header>

    {{-- Main content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-midnight-950 text-midnight-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

                {{-- Brand --}}
                <div>
                    <div class="mb-4 flex justify-center">
                        <img src="{{ asset('images/logo-icon.png') }}"
                             alt="Arsa & Asociados — Estudio Jurídico"
                             class="h-40 w-auto object-contain">
                    </div>
                    <p class="text-sm leading-relaxed text-midnight-400">
                        Asesoría legal integral con excelencia, compromiso y visión estratégica para proteger sus intereses.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="text-xs uppercase tracking-[0.2em] text-gold-500 font-semibold mb-4">Navegación</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-sm text-midnight-400 hover:text-white transition-colors">Inicio</a></li>
                        <li><a href="/#servicios" class="text-sm text-midnight-400 hover:text-white transition-colors">Servicios</a></li>
                        <li><a href="/#nosotros" class="text-sm text-midnight-400 hover:text-white transition-colors">Nosotros</a></li>
                        <li><a href="/#testimonios" class="text-sm text-midnight-400 hover:text-white transition-colors">Testimonios</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-sm text-midnight-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="/#contacto" class="text-sm text-midnight-400 hover:text-white transition-colors">Contacto</a></li>
                    </ul>
                </div>

                {{-- Contact info --}}
                <div>
                    <h4 class="text-xs uppercase tracking-[0.2em] text-gold-500 font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-3 text-sm text-midnight-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-gold-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                            Santiago de Chile
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-gold-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            contacto@arsayasociados.cl
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-gold-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            +56 9 3067 6693
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="mt-12 pt-8 border-t border-midnight-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-midnight-500">
                    &copy; {{ date('Y') }} Arsa & Asociados. Todos los derechos reservados.
                </p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('legal.privacy') }}" class="text-xs text-midnight-500 hover:text-white transition-colors">Política de privacidad</a>
                    <a href="{{ route('legal.terms') }}" class="text-xs text-midnight-500 hover:text-white transition-colors">Términos de uso</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- WhatsApp flotante --}}
    <a href="https://wa.me/56930676693?text=Hola%2C%20me%20gustar%C3%ADa%20consultar%20sobre%20mis%20opciones%20legales."
       target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 right-6 z-50 flex items-center gap-2 group"
       aria-label="Contactar por WhatsApp">
        <span class="hidden group-hover:flex items-center bg-midnight-900 text-white text-xs font-medium px-3 py-2 shadow-lg whitespace-nowrap">
            Escríbenos por WhatsApp
        </span>
        <div class="w-14 h-14 rounded-full bg-[#25D366] flex items-center justify-center shadow-lg hover:bg-[#1da851] transition-colors">
            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </div>
    </a>

    {{-- Mobile menu toggle --}}
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            const hamburger = document.getElementById('hamburger-icon');
            const close = document.getElementById('close-icon');
            menu.classList.toggle('hidden');
            hamburger.classList.toggle('hidden');
            close.classList.toggle('hidden');
        });
    </script>
</body>
</html>
