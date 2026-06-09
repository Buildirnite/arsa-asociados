@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->exists ? 'Editar' : 'Nuevo' }} artículo — Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/editor.js'])
</head>
<body class="min-h-screen bg-midnight-50 font-sans antialiased">

    <header class="bg-midnight-950 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('images/brand/logo-icon.png') }}" alt="Arsa & Asociados" class="h-10 w-auto object-contain">
        </div>
        <a href="{{ route('admin.posts.index') }}" class="text-xs text-midnight-400 hover:text-white transition-colors">← Volver</a>
    </header>

    <main class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-serif font-semibold text-midnight-900 mb-8">
            {{ $post->exists ? 'Editar artículo' : 'Nuevo artículo' }}
        </h1>

        @if($errors->any())
            <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
              enctype="multipart/form-data"
              class="space-y-6 bg-white border border-midnight-100 p-8">
            @csrf
            @if($post->exists) @method('PUT') @endif

            {{-- Banner de borrador autoguardado --}}
            <div id="draft-banner" class="hidden items-center justify-between gap-3 bg-amber-50 border border-amber-200 px-4 py-3 text-sm">
                <span class="text-amber-800">Hay un borrador sin guardar de este artículo.</span>
                <span class="flex gap-3 shrink-0">
                    <button type="button" id="draft-restore" class="font-semibold text-amber-800 hover:underline">Restaurar</button>
                    <button type="button" id="draft-discard" class="text-amber-600 hover:underline">Descartar</button>
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-midnight-700 mb-2">Título</label>
                <input type="text" name="title" required value="{{ old('title', $post->title) }}"
                       class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-midnight-700 mb-2">Categoría</label>
                <select name="category"
                        class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 bg-white focus:outline-none focus:border-gold-500 transition-colors">
                    @foreach(\App\Models\Post::CATEGORIES as $cat)
                        <option value="{{ $cat }}" {{ old('category', $post->category) === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="flex items-center justify-between text-sm font-medium text-midnight-700 mb-2">
                    <span>Resumen <span class="text-midnight-400 font-normal" id="excerpt-counter">(máx. 300 — aparece en la lista)</span></span>
                    <button type="button" id="gen-excerpt" class="text-xs text-gold-600 hover:text-gold-700 font-medium">↳ Generar desde el contenido</button>
                </label>
                <textarea name="excerpt" id="excerpt-input" rows="3" required maxlength="300"
                          class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors resize-none">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-midnight-700 mb-2">Contenido del artículo</label>

                {{-- Toolbar --}}
                <div class="flex flex-wrap items-center gap-1 px-3 py-2 border border-b-0 border-midnight-200 bg-midnight-50">

                    <button data-editor-action="bold"        class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors font-bold text-sm w-8 h-8 leading-none" title="Negrita">B</button>
                    <button data-editor-action="italic"      class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors italic text-sm w-8 h-8 leading-none" title="Cursiva">I</button>
                    <button data-editor-action="underline"   class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors underline text-sm w-8 h-8 leading-none" title="Subrayado">U</button>

                    <div class="w-px h-5 bg-midnight-300 mx-1"></div>

                    <button data-editor-action="h2" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors text-xs font-bold px-2 h-8" title="Encabezado H2">H2</button>
                    <button data-editor-action="h3" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors text-xs font-bold px-2 h-8" title="Encabezado H3">H3</button>

                    <div class="w-px h-5 bg-midnight-300 mx-1"></div>

                    <button data-editor-action="bulletList" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Lista con viñetas">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </button>
                    <button data-editor-action="orderedList" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Lista numerada">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h11M9 12h11M9 19h11M4 5v.01M4 12v.01M4 19v.01"/></svg>
                    </button>

                    <div class="w-px h-5 bg-midnight-300 mx-1"></div>

                    <button data-editor-action="blockquote" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Cita">
                        <svg class="w-4 h-4 mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M11.192 15.757c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.077-1.928.713-2.942.635-1.014 1.537-1.74 2.708-2.18l-1.17-1.703c-1.404.616-2.56 1.572-3.467 2.866-.908 1.294-1.363 2.7-1.363 4.217 0 1.21.36 2.182 1.08 2.918.72.736 1.644 1.104 2.772 1.104 1.015 0 1.864-.328 2.548-.983.683-.655 1.025-1.468 1.025-2.44l-.29.2zm9 0c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.077-1.928.713-2.942.635-1.014 1.537-1.74 2.708-2.18l-1.17-1.703c-1.404.616-2.56 1.572-3.467 2.866-.908 1.294-1.363 2.7-1.363 4.217 0 1.21.36 2.182 1.08 2.918.72.736 1.644 1.104 2.772 1.104 1.015 0 1.864-.328 2.548-.983.683-.655 1.025-1.468 1.025-2.44l-.29.2z"/></svg>
                    </button>
                    <button data-editor-action="hr" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Línea separadora">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"/></svg>
                    </button>

                    <div class="w-px h-5 bg-midnight-300 mx-1"></div>

                    <button data-editor-action="link" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Insertar enlace">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </button>
                    <button data-editor-action="image" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Insertar imagen">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </button>

                    <div class="w-px h-5 bg-midnight-300 mx-1"></div>

                    <button data-editor-action="undo" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Deshacer">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    </button>
                    <button data-editor-action="redo" class="p-1.5 rounded text-midnight-600 hover:bg-midnight-100 transition-colors w-8 h-8" title="Rehacer">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"/></svg>
                    </button>
                </div>

                {{-- Área de edición --}}
                <div id="editor" class="border border-midnight-200 bg-white cursor-text"></div>
                <input type="hidden" name="content" id="content-input" value="{{ old('content', $post->content) }}">
                <div class="flex items-center justify-between mt-1.5">
                    <p class="text-xs text-midnight-400" id="content-stats">0 palabras · 1 min de lectura</p>
                    <p class="text-xs text-midnight-300">Puedes arrastrar o pegar imágenes aquí</p>
                </div>
                @error('content')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-midnight-700 mb-2">
                    Imagen destacada <span class="text-midnight-400 font-normal">(jpeg, png o webp — máx. 2 MB)</span>
                </label>
                @if($post->image)
                    <div class="mb-3">
                        <img src="{{ Storage::url($post->image) }}" alt="Imagen actual"
                             class="h-40 w-full object-cover border border-midnight-200">
                        <div class="flex items-center gap-4 mt-2">
                            <p class="text-xs text-midnight-400">Imagen actual. Sube una nueva para reemplazarla.</p>
                            <form method="POST" action="{{ route('admin.posts.destroyImage', $post) }}"
                                  onsubmit="return confirm('¿Quitar la imagen destacada?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-400 hover:text-red-600 transition-colors">
                                    Quitar imagen
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                       class="w-full text-sm text-midnight-600 file:mr-4 file:py-2 file:px-4 file:border file:border-midnight-200 file:text-sm file:font-medium file:text-midnight-700 file:bg-white hover:file:bg-midnight-50 file:cursor-pointer">
                @error('image')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- SEO --}}
            <div class="border-t border-midnight-100 pt-6 space-y-4">
                <p class="text-xs uppercase tracking-[0.2em] text-gold-600 font-semibold">SEO</p>

                {{-- Vista previa de cómo se verá en Google --}}
                <div class="border border-midnight-200 rounded p-4 bg-white">
                    <p class="text-[11px] uppercase tracking-wider text-midnight-400 mb-2">Vista previa en Google</p>
                    <p id="seo-preview-url" class="text-xs text-green-700 truncate">arsajuridico.cl › blog › mi-articulo</p>
                    <p id="seo-preview-title" class="text-[#1a0dab] text-lg leading-snug truncate">Título del artículo</p>
                    <p id="seo-preview-desc" class="text-sm text-midnight-500 leading-snug">Descripción del artículo…</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-midnight-700 mb-1">
                        Slug (URL)
                        <span class="text-midnight-400 font-normal">— se genera solo, edítalo si lo necesitas</span>
                    </label>
                    <div class="flex items-center border border-midnight-200 focus-within:border-gold-500 focus-within:ring-1 focus-within:ring-gold-500 transition-colors">
                        <span class="px-3 py-3 text-xs text-midnight-400 bg-midnight-50 border-r border-midnight-200 shrink-0">/blog/</span>
                        <input type="text" name="slug" id="slug-input"
                               value="{{ old('slug', $post->slug) }}"
                               class="flex-1 px-3 py-3 text-sm text-midnight-900 focus:outline-none bg-white">
                    </div>
                    @error('slug')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-midnight-700 mb-1">
                        Meta título
                        <span class="text-midnight-400 font-normal" id="meta-title-counter">(máx. 70 caracteres)</span>
                    </label>
                    <input type="text" name="meta_title" id="meta-title-input" maxlength="70"
                           value="{{ old('meta_title', $post->meta_title) }}"
                           placeholder="Si está vacío se usará el título del artículo"
                           class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                    @error('meta_title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center justify-between text-sm font-medium text-midnight-700 mb-1">
                        <span>Meta descripción <span class="text-midnight-400 font-normal" id="meta-desc-counter">(máx. 160)</span></span>
                        <button type="button" id="gen-meta-desc" class="text-xs text-gold-600 hover:text-gold-700 font-medium">↳ Generar desde el resumen</button>
                    </label>
                    <textarea name="meta_description" id="meta-desc-input" rows="3" maxlength="160"
                              placeholder="Si está vacía se usará el resumen del artículo"
                              class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors resize-none">{{ old('meta_description', $post->meta_description) }}</textarea>
                    @error('meta_description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            @php
                $pubInitial = old('publish_at', $post->published_at?->format('Y-m-d\TH:i'));
                $pubState   = ! $pubInitial ? 'draft' : (\Carbon\Carbon::parse($pubInitial)->isFuture() ? 'schedule' : 'now');
            @endphp
            <div class="pt-2">
                <label class="block text-sm font-medium text-midnight-700 mb-2">Publicación</label>
                <div class="flex flex-wrap gap-2" id="pub-options" data-initial="{{ $pubState }}">
                    <button type="button" data-pub="draft"    class="pub-btn px-4 py-2.5 text-sm border border-midnight-200 rounded transition-colors">Borrador</button>
                    <button type="button" data-pub="now"      class="pub-btn px-4 py-2.5 text-sm border border-midnight-200 rounded transition-colors">Publicar ahora</button>
                    <button type="button" data-pub="schedule" class="pub-btn px-4 py-2.5 text-sm border border-midnight-200 rounded transition-colors">Programar</button>
                </div>
                <div id="pub-schedule" class="mt-3 hidden">
                    <input type="datetime-local" id="publish-at-picker" value="{{ $pubState === 'schedule' ? $pubInitial : '' }}"
                           class="px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
                    <p class="mt-1 text-xs text-midnight-400">El artículo se publicará automáticamente en esta fecha y hora.</p>
                </div>
                <input type="hidden" name="publish_at" id="publish-at" value="{{ $pubInitial }}">
            </div>

            <div class="flex items-center gap-4 pt-2 border-t border-midnight-100">
                <button type="submit"
                        class="px-8 py-3 bg-midnight-900 text-white text-sm font-semibold hover:bg-midnight-800 transition-colors">
                    {{ $post->exists ? 'Guardar cambios' : 'Crear artículo' }}
                </button>
                @if($post->exists)
                    <a href="{{ route('admin.posts.preview', $post) }}" target="_blank"
                       class="text-sm text-midnight-400 hover:text-midnight-700 transition-colors">
                        Vista previa
                    </a>
                @endif
                <a href="{{ route('admin.posts.index') }}" class="text-sm text-midnight-400 hover:text-midnight-700 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </main>

<script>
(function () {
    const form     = document.querySelector('form');
    const isNew    = {{ $post->exists ? 'false' : 'true' }};
    const draftKey = 'arsa_post_draft_{{ $post->exists ? $post->id : "new" }}';
    let formDirty  = false;

    const titleInput     = document.querySelector('input[name="title"]');
    const slugInput      = document.getElementById('slug-input');
    const contentInput   = document.getElementById('content-input');
    const excerptInput   = document.getElementById('excerpt-input');
    const metaTitleInput = document.getElementById('meta-title-input');
    const metaDescInput  = document.getElementById('meta-desc-input');
    const host           = '{{ parse_url(config('app.url'), PHP_URL_HOST) ?: 'arsajuridico.cl' }}';

    // ---------- Slug ----------
    let slugEdited = slugInput.value.length > 0 && !isNew;
    function toSlug(str) {
        return str.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '').trim()
            .replace(/[\s_]+/g, '-').replace(/-+/g, '-');
    }
    if (isNew) {
        titleInput.addEventListener('input', () => { if (!slugEdited) slugInput.value = toSlug(titleInput.value); });
        slugInput.addEventListener('input', () => { slugEdited = slugInput.value.length > 0; });
    }
    slugInput.addEventListener('blur', () => { slugInput.value = toSlug(slugInput.value); updatePreview(); });

    // ---------- Texto plano del editor ----------
    function plainText() {
        const tmp = document.createElement('div');
        tmp.innerHTML = contentInput.value || '';
        return (tmp.textContent || '').replace(/\s+/g, ' ').trim();
    }

    // ---------- Palabras + tiempo de lectura ----------
    const stats = document.getElementById('content-stats');
    function updateStats() {
        const text  = plainText();
        const words = text ? text.split(' ').length : 0;
        const mins  = Math.max(1, Math.ceil(words / 200));
        stats.textContent = `${words} palabra${words === 1 ? '' : 's'} \u00b7 ${mins} min de lectura`;
    }

    // ---------- Vista previa de Google ----------
    const pvTitle = document.getElementById('seo-preview-title');
    const pvUrl   = document.getElementById('seo-preview-url');
    const pvDesc  = document.getElementById('seo-preview-desc');
    function updatePreview() {
        pvTitle.textContent = (metaTitleInput.value || titleInput.value || 'T\u00edtulo del art\u00edculo').trim();
        pvDesc.textContent  = (metaDescInput.value || excerptInput.value || 'Descripci\u00f3n del art\u00edculo\u2026').trim();
        pvUrl.textContent   = `${host} \u203a blog \u203a ${slugInput.value || 'mi-articulo'}`;
    }

    // ---------- Sem\u00e1foro de longitud (verde = \u00f3ptimo, \u00e1mbar = mejorable) ----------
    function gauge(input, label, okMin, okMax, hardMax) {
        if (!input || !label) return;
        function update() {
            const len = input.value.length;
            label.textContent = `${len}/${hardMax}`;
            label.classList.remove('text-green-600', 'text-amber-500');
            if (len >= okMin && len <= okMax) label.classList.add('text-green-600');
            else if (len > 0)                 label.classList.add('text-amber-500');
        }
        input.addEventListener('input', update);
        update();
    }
    gauge(metaTitleInput, document.getElementById('meta-title-counter'), 50, 60, 70);
    gauge(metaDescInput,  document.getElementById('meta-desc-counter'), 120, 160, 160);
    gauge(excerptInput,   document.getElementById('excerpt-counter'),   80, 300, 300);

    [titleInput, metaTitleInput, metaDescInput, excerptInput].forEach(el => el && el.addEventListener('input', updatePreview));
    contentInput.addEventListener('input', updateStats);

    // ---------- Generar resumen / meta descripci\u00f3n ----------
    function summarize(text, max) {
        if (text.length <= max) return text;
        const cut = text.slice(0, max);
        return cut.slice(0, cut.lastIndexOf(' ')).trim() + '\u2026';
    }
    document.getElementById('gen-excerpt')?.addEventListener('click', () => {
        const text = plainText();
        if (!text) return alert('Escribe primero el contenido del art\u00edculo.');
        excerptInput.value = summarize(text, 300);
        excerptInput.dispatchEvent(new Event('input', { bubbles: true }));
    });
    document.getElementById('gen-meta-desc')?.addEventListener('click', () => {
        const base = excerptInput.value.trim() || plainText();
        if (!base) return alert('Escribe primero el resumen o el contenido.');
        metaDescInput.value = summarize(base, 160);
        metaDescInput.dispatchEvent(new Event('input', { bubbles: true }));
    });

    // ---------- Autoguardado en localStorage ----------
    const fields = ['title', 'category', 'excerpt', 'content', 'meta_title', 'meta_description', 'slug', 'publish_at'];
    let saveTimer;
    form.addEventListener('input', () => {
        formDirty = true;
        clearTimeout(saveTimer);
        saveTimer = setTimeout(() => {
            const data = { _ts: Date.now() };
            fields.forEach(name => {
                const el = form.querySelector(`[name="${name}"]`);
                if (el) data[name] = el.value;
            });
            try { localStorage.setItem(draftKey, JSON.stringify(data)); } catch {}
        }, 1000);
    });

    // ---------- Restaurar borrador ----------
    const banner = document.getElementById('draft-banner');
    let saved = null;
    try { saved = JSON.parse(localStorage.getItem(draftKey)); } catch {}
    if (saved && saved.title !== undefined) {
        banner.classList.remove('hidden');
        banner.classList.add('flex');
        document.getElementById('draft-restore').addEventListener('click', () => {
            fields.forEach(name => {
                if (saved[name] === undefined) return;
                const el = form.querySelector(`[name="${name}"]`);
                if (el) el.value = saved[name];
            });
            window.dispatchEvent(new CustomEvent('restore-editor', { detail: saved.content || '' }));
            updateStats(); updatePreview();
            banner.classList.add('hidden');
        });
        document.getElementById('draft-discard').addEventListener('click', () => {
            localStorage.removeItem(draftKey);
            banner.classList.add('hidden');
        });
    }

    // ---------- Aviso de cambios sin guardar ----------
    window.addEventListener('beforeunload', (e) => {
        if (formDirty) { e.preventDefault(); e.returnValue = ''; }
    });
    form.addEventListener('submit', () => {
        formDirty = false;
        localStorage.removeItem(draftKey);
    });

    // ---------- Estado de publicación (Borrador / Publicar ahora / Programar) ----------
    const pubWrap   = document.getElementById('pub-options');
    const pubBtns   = pubWrap.querySelectorAll('.pub-btn');
    const pubSched  = document.getElementById('pub-schedule');
    const pubPicker = document.getElementById('publish-at-picker');
    const pubHidden = document.getElementById('publish-at');

    function dtLocal(d) {
        const p = n => String(n).padStart(2, '0');
        return `${d.getFullYear()}-${p(d.getMonth() + 1)}-${p(d.getDate())}T${p(d.getHours())}:${p(d.getMinutes())}`;
    }
    function paintPub(state) {
        pubBtns.forEach(b => {
            const active = b.dataset.pub === state;
            b.classList.toggle('bg-midnight-900', active);
            b.classList.toggle('text-white', active);
            b.classList.toggle('text-midnight-600', !active);
            b.classList.toggle('hover:bg-midnight-100', !active);
        });
    }
    function setPubState(state) {
        paintPub(state);
        if (state === 'draft') {
            pubSched.classList.add('hidden');
            pubHidden.value = '';
        } else if (state === 'now') {
            pubSched.classList.add('hidden');
            pubHidden.value = dtLocal(new Date());
        } else {
            pubSched.classList.remove('hidden');
            if (!pubPicker.value) { const d = new Date(); d.setDate(d.getDate() + 1); pubPicker.value = dtLocal(d); }
            pubHidden.value = pubPicker.value;
        }
        formDirty = true;
    }
    pubBtns.forEach(b => b.addEventListener('click', () => setPubState(b.dataset.pub)));
    pubPicker.addEventListener('input', () => { pubHidden.value = pubPicker.value; });
    // Pintar el estado inicial sin alterar valores ni marcar cambios.
    paintPub(pubWrap.dataset.initial);
    if (pubWrap.dataset.initial === 'schedule') pubSched.classList.remove('hidden');

    // init
    updateStats();
    updatePreview();
})();
</script>
</body>
</html>
