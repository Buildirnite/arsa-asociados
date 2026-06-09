<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $metaTitle       = $title ?? 'Arsa & Asociados — Asesoría Jurídica en Santiago de Chile';
        $metaDescription = $description ?? 'Asesoría jurídica integral en derecho civil, laboral y de familia. Atención personalizada y primera consulta sin costo en Santiago de Chile.';
        $metaUrl         = $canonical ?? url()->current();
        $ogImage         = $ogImage ?? asset('images/brand/logo-icon.png');
        $ogType          = $ogType ?? 'website';
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/brand/logo-icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/brand/logo-icon.png') }}">

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
        "description": "Asesoría jurídica especializada en derecho civil, laboral y de familia en Santiago de Chile.",
        "url": "{{ config('app.url') }}",
        "telephone": "+56930676693",
        "email": "catalynaarmas@gmail.com",
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
                    <img src="{{ asset('images/brand/logo.png') }}"
                         alt="Arsa & Asociados — Asesoría Jurídica"
                         class="h-23 w-auto object-contain transition-opacity group-hover:opacity-80">
                </a>

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" data-section="inicio"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors">
                        Inicio
                    </a>
                    <a href="/#servicios" data-section="servicios"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors">
                        Servicios
                    </a>
                    <a href="/#nosotros" data-section="nosotros"
                       class="text-sm font-medium text-midnight-600 hover:text-midnight-900 transition-colors">
                        Nosotros
                    </a>
                    <a href="/#testimonios" data-section="testimonios"
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
                        <img src="{{ asset('images/brand/logo-icon.png') }}"
                             alt="Arsa & Asociados — Asesoría Jurídica"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            <img src="{{ asset('images/ui/telefono.webp') }}" alt="Teléfono" class="h-10 -mt-3 -ml-1 brightness-0 invert opacity-75">
                        </li>
                    </ul>

                    {{-- Redes sociales --}}
                    <div class="flex items-center gap-4 mt-5">
                        <a href="https://www.instagram.com/arsa_asesorias/" target="_blank" rel="noopener noreferrer"
                           class="text-midnight-400 hover:text-white transition-colors" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/56930676693?text=Hola%2C%20me%20gustar%C3%ADa%20consultar%20sobre%20mis%20opciones%20legales."
                           target="_blank" rel="noopener noreferrer"
                           class="text-midnight-400 hover:text-white transition-colors" aria-label="WhatsApp">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
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

        // Indicador de sección activa en el nav
        (function () {
            const sections = [...document.querySelectorAll('section[id]')];
            const links    = [...document.querySelectorAll('[data-section]')];
            if (!sections.length || !links.length) return;

            const header = document.querySelector('header');

            function setActive() {
                const offset  = (header?.offsetHeight ?? 96) + 24;
                const scrollY = window.scrollY;
                let current   = sections[0].id;
                for (const s of sections) {
                    if (s.offsetTop - offset <= scrollY) current = s.id;
                }
                links.forEach(l => l.classList.toggle('nav-active', l.dataset.section === current));
            }

            window.addEventListener('scroll', setActive, { passive: true });
            setActive();
        })();
    </script>
</body>
</html>
