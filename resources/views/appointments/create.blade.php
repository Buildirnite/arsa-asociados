<x-layout
    title="Agendar consulta — Arsa & Asociados"
    description="Reserve su primera consulta jurídica sin costo en Arsa & Asociados. Elija el día y la hora que más le acomode."
    :canonical="route('agendar.create')"
>
    {{-- Hero --}}
    <section class="bg-midnight-950 py-16 lg:py-20">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-px w-12 bg-gold-500"></div>
                <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-semibold">Agende su consulta</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-serif font-semibold text-white leading-tight mb-3">Reserve su primera consulta</h1>
            <p class="text-midnight-300">Sin costo y sin compromiso. Elija el día y la hora que más le acomode (atendemos de lunes a sábado).</p>
        </div>
    </section>

    <section class="py-12 lg:py-16 bg-midnight-50">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 flex items-start gap-3 bg-green-50 border border-green-200 px-5 py-4">
                    <svg class="w-6 h-6 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 px-5 py-4 bg-red-50 border border-red-200 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('agendar.store') }}" class="bg-white border border-midnight-100 p-8 space-y-8" id="appointment-form">
                @csrf

                {{-- Paso 1: fecha --}}
                <div>
                    <p class="text-sm font-semibold text-midnight-900 mb-1">1. Elija el día</p>
                    <p class="text-xs text-midnight-400 mb-3">Atendemos de lunes a sábado, de 9:00 a 18:00.</p>
                    <input type="date" name="date" id="date-input" required
                           value="{{ old('date') }}"
                           class="px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                </div>

                {{-- Paso 2: horario --}}
                <div>
                    <p class="text-sm font-semibold text-midnight-900 mb-3">2. Elija el horario</p>
                    <div id="slots" class="grid grid-cols-3 sm:grid-cols-4 gap-2 min-h-[3rem]">
                        <p class="col-span-full text-sm text-midnight-400" id="slots-hint">Seleccione primero una fecha.</p>
                    </div>
                    <input type="hidden" name="slot" id="slot-input" value="{{ old('slot') }}">
                </div>

                {{-- Paso 3: datos --}}
                <div class="space-y-5">
                    <p class="text-sm font-semibold text-midnight-900">3. Sus datos</p>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-midnight-600 mb-1.5">Nombre completo *</label>
                            <input type="text" name="name" required value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-midnight-600 mb-1.5">Correo electrónico *</label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-midnight-600 mb-1.5">Teléfono</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-midnight-600 mb-1.5">Tema de la consulta</label>
                            <select name="area"
                                    class="w-full px-4 py-3 border border-midnight-200 text-sm bg-white focus:outline-none focus:border-gold-500 transition-colors">
                                <option value="">— Seleccione —</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area['name'] }}" {{ old('area') === $area['name'] ? 'selected' : '' }}>{{ $area['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-midnight-600 mb-1.5">Describa brevemente su caso (opcional)</label>
                        <textarea name="message" rows="3"
                                  class="w-full px-4 py-3 border border-midnight-200 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors resize-none">{{ old('message') }}</textarea>
                    </div>
                </div>

                <button type="submit"
                        class="w-full px-8 py-3.5 bg-midnight-900 text-white font-semibold text-sm hover:bg-midnight-800 transition-colors">
                    Confirmar cita
                </button>
            </form>
        </div>
    </section>

    <script>
        (function () {
            const dateInput = document.getElementById('date-input');
            const slotsWrap = document.getElementById('slots');
            const slotInput = document.getElementById('slot-input');
            const hint      = document.getElementById('slots-hint');

            // Rango permitido: desde hoy hasta 60 días.
            const today = new Date();
            const pad = n => String(n).padStart(2, '0');
            const fmt = d => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
            dateInput.min = fmt(today);
            const max = new Date(); max.setDate(max.getDate() + 60);
            dateInput.max = fmt(max);

            function renderSlots(slots) {
                slotsWrap.innerHTML = '';
                slotInput.value = '';
                if (!slots.length) {
                    slotsWrap.innerHTML = '<p class="col-span-full text-sm text-midnight-400">No hay horarios disponibles ese día. Pruebe otra fecha.</p>';
                    return;
                }
                slots.forEach(slot => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.textContent = slot;
                    btn.className = 'slot-btn px-3 py-2.5 text-sm border border-midnight-200 text-midnight-700 hover:border-gold-500 transition-colors';
                    btn.addEventListener('click', () => {
                        slotInput.value = slot;
                        slotsWrap.querySelectorAll('.slot-btn').forEach(b => {
                            const on = b === btn;
                            b.classList.toggle('bg-midnight-900', on);
                            b.classList.toggle('text-white', on);
                            b.classList.toggle('border-midnight-900', on);
                            b.classList.toggle('text-midnight-700', !on);
                        });
                    });
                    slotsWrap.appendChild(btn);
                });
            }

            async function loadSlots() {
                if (!dateInput.value) return;
                slotsWrap.innerHTML = '<p class="col-span-full text-sm text-midnight-400">Cargando horarios…</p>';
                try {
                    const res  = await fetch(`{{ route('agendar.slots') }}?date=${dateInput.value}`);
                    const data = await res.json();
                    renderSlots(data.slots || []);
                } catch {
                    slotsWrap.innerHTML = '<p class="col-span-full text-sm text-red-500">No se pudieron cargar los horarios.</p>';
                }
            }

            dateInput.addEventListener('change', loadSlots);
            if (dateInput.value) loadSlots();

            document.getElementById('appointment-form').addEventListener('submit', (e) => {
                if (!slotInput.value) {
                    e.preventDefault();
                    alert('Por favor seleccione un horario disponible.');
                }
            });
        })();
    </script>
</x-layout>
