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

            <div>
                <label class="block text-sm font-medium text-midnight-700 mb-2">Título</label>
                <input type="text" name="title" required value="{{ old('title', $post->title) }}"
                       class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-midnight-700 mb-2">Categoría</label>
                <select name="category"
                        class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 bg-white focus:outline-none focus:border-gold-500 transition-colors">
                    @foreach(['Derecho Civil', 'Derecho Laboral', 'Derecho de Familia', 'Derecho Inmobiliario', 'Cobranza Judicial', 'Derecho Penal', 'General'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $post->category) === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-midnight-700 mb-2">
                    Resumen <span class="text-midnight-400 font-normal">(máx. 300 caracteres — aparece en la lista)</span>
                </label>
                <textarea name="excerpt" rows="3" required maxlength="300"
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
                    <label class="block text-sm font-medium text-midnight-700 mb-1">
                        Meta descripción
                        <span class="text-midnight-400 font-normal" id="meta-desc-counter">(máx. 160 caracteres)</span>
                    </label>
                    <textarea name="meta_description" id="meta-desc-input" rows="3" maxlength="160"
                              placeholder="Si está vacía se usará el resumen del artículo"
                              class="w-full px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors resize-none">{{ old('meta_description', $post->meta_description) }}</textarea>
                    @error('meta_description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-sm font-medium text-midnight-700 mb-2">
                    Fecha de publicación
                    <span class="text-midnight-400 font-normal">— vacío = borrador · fecha futura = programado · fecha pasada = publicar</span>
                </label>
                <input type="datetime-local" name="publish_at"
                       value="{{ old('publish_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                       class="px-4 py-3 border border-midnight-200 text-sm text-midnight-900 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-colors">
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
    // --- Slug auto-generation (only for new posts) ---
    const titleInput = document.querySelector('input[name="title"]');
    const slugInput  = document.getElementById('slug-input');
    const isNew      = {{ $post->exists ? 'false' : 'true' }};
    let slugEdited   = slugInput.value.length > 0 && !isNew;

    function toSlug(str) {
        return str
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/[\s_]+/g, '-')
            .replace(/-+/g, '-');
    }

    if (isNew) {
        titleInput.addEventListener('input', function () {
            if (!slugEdited) slugInput.value = toSlug(this.value);
        });
        slugInput.addEventListener('input', function () {
            slugEdited = this.value.length > 0;
        });
        slugInput.addEventListener('blur', function () {
            this.value = toSlug(this.value);
        });
    } else {
        slugInput.addEventListener('blur', function () {
            this.value = toSlug(this.value);
        });
    }

    // --- Character counters ---
    function counter(inputId, labelId, max) {
        const input = document.getElementById(inputId);
        const label = document.getElementById(labelId);
        if (!input || !label) return;
        function update() {
            const remaining = max - input.value.length;
            label.textContent = `(${input.value.length}/${max} caracteres)`;
            label.classList.toggle('text-red-500', remaining < 10);
        }
        input.addEventListener('input', update);
        update();
    }

    counter('meta-title-input', 'meta-title-counter', 70);
    counter('meta-desc-input',  'meta-desc-counter',  160);
})();
</script>
</body>
</html>
