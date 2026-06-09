<x-layout
    title="Cita agendada — Arsa & Asociados"
    description="Su cita fue agendada con éxito."
    :canonical="route('agendar.confirmacion')"
>
    <section class="py-16 lg:py-24 bg-midnight-50 min-h-[70vh] flex items-center">
        <div class="max-w-xl mx-auto px-6 lg:px-8 w-full">

            <div class="bg-white border border-midnight-100 p-8 lg:p-10 text-center">

                {{-- Ícono de éxito --}}
                <div class="mx-auto w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-6">
                    <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <h1 class="text-2xl lg:text-3xl font-serif font-semibold text-midnight-900 mb-2">¡Cita agendada!</h1>
                <p class="text-midnight-500 text-sm mb-8">
                    Gracias, {{ $appointment->name }}. Tu solicitud quedó registrada y enviamos la confirmación a
                    <span class="font-medium text-midnight-700">{{ $appointment->email }}</span>.
                </p>

                {{-- Detalle de la cita --}}
                <div class="text-left bg-midnight-50 border border-midnight-100 divide-y divide-midnight-100">
                    <div class="flex items-center gap-3 px-5 py-4">
                        <svg class="w-5 h-5 text-gold-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-midnight-400">Día y hora</p>
                            <p class="text-sm font-semibold text-midnight-900 capitalize">
                                {{ $appointment->scheduled_at->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }} · {{ $appointment->scheduled_at->format('H:i') }} hrs
                            </p>
                        </div>
                    </div>
                    @if($appointment->area)
                        <div class="flex items-center gap-3 px-5 py-4">
                            <svg class="w-5 h-5 text-gold-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M3 12h18M3 17h12"/></svg>
                            <div>
                                <p class="text-xs uppercase tracking-wide text-midnight-400">Tema</p>
                                <p class="text-sm font-semibold text-midnight-900">{{ $appointment->area }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center gap-3 px-5 py-4">
                        <svg class="w-5 h-5 text-gold-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-midnight-400">Estado</p>
                            <p class="text-sm font-semibold text-amber-700">Pendiente de confirmación</p>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-midnight-400 mt-5">
                    Nos pondremos en contacto contigo para confirmar la cita. Si necesitas reagendar o cancelar, responde el correo o escríbenos por WhatsApp.
                </p>

                {{-- Acciones --}}
                <div class="flex flex-col sm:flex-row gap-3 mt-8">
                    <a href="{{ url('/') }}"
                       class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-midnight-900 text-white text-sm font-semibold hover:bg-midnight-800 transition-colors">
                        Volver al inicio
                    </a>
                    <a href="{{ route('blog.index') }}"
                       class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-midnight-300 text-midnight-800 text-sm font-medium hover:border-midnight-900 transition-colors">
                        Leer el blog
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
