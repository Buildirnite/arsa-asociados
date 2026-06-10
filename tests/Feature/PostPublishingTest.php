<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Cubre los tres bugs corregidos en el panel de artículos:
 *   1. "Publicar ahora" no publicaba (quedaba como programado por desfase de reloj).
 *   2. La vista previa de un borrador reventaba (published_at null).
 *   3. No se podían guardar cambios al editar un artículo con imagen (form anidado).
 */
class PostPublishingTest extends TestCase
{
    use RefreshDatabase;

    private function asAdmin(): self
    {
        return $this->withSession(['admin_authenticated' => true]);
    }

    /** Datos válidos mínimos para crear/editar un artículo. */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title'    => 'Artículo de prueba',
            'slug'     => 'articulo-de-prueba',
            'category' => 'General',
            'excerpt'  => 'Un resumen de prueba para el artículo.',
            'content'  => '<p>Contenido del artículo de prueba.</p>',
        ], $overrides);
    }

    // ====================================================================
    // 1. PUBLICACIÓN  (publish_at → published_at)
    // ====================================================================

    public function test_publicar_ahora_con_sentinel_now_publica_de_inmediato(): void
    {
        $this->asAdmin()
            ->post(route('admin.posts.store'), $this->validPayload(['publish_at' => 'now']))
            ->assertRedirect(route('admin.posts.index'));

        $post = Post::firstOrFail();

        $this->assertNotNull($post->published_at);
        $this->assertTrue($post->isPublished(), 'El artículo debería estar publicado.');
        $this->assertTrue(
            Post::published()->whereKey($post->id)->exists(),
            'El artículo debería aparecer en el scope published().'
        );
    }

    public function test_sentinel_now_usa_la_hora_del_servidor_no_la_del_navegador(): void
    {
        // El bug original: el navegador mandaba la hora local truncada al minuto,
        // que con desfase de reloj podía quedar en el futuro. 'now' lo evita.
        $this->asAdmin()->post(route('admin.posts.store'), $this->validPayload(['publish_at' => 'now']));

        $post = Post::firstOrFail();

        $this->assertFalse($post->isScheduled(), 'No debe quedar como programado en el futuro.');
        $this->assertTrue($post->published_at->lessThanOrEqualTo(now()));
    }

    public function test_sin_publish_at_queda_como_borrador(): void
    {
        $this->asAdmin()
            ->post(route('admin.posts.store'), $this->validPayload(['publish_at' => '']))
            ->assertRedirect(route('admin.posts.index'));

        $post = Post::firstOrFail();

        $this->assertNull($post->published_at);
        $this->assertFalse($post->isPublished());
        $this->assertFalse(Post::published()->whereKey($post->id)->exists());
    }

    public function test_publish_at_ausente_queda_como_borrador(): void
    {
        // Ni siquiera presente la clave (por si el form no la manda).
        $payload = $this->validPayload();
        unset($payload['publish_at']);

        $this->asAdmin()->post(route('admin.posts.store'), $payload);

        $this->assertNull(Post::firstOrFail()->published_at);
    }

    public function test_publish_at_futuro_queda_programado_no_publicado(): void
    {
        $futuro = now()->addWeek()->format('Y-m-d\TH:i');

        $this->asAdmin()->post(route('admin.posts.store'), $this->validPayload(['publish_at' => $futuro]));

        $post = Post::firstOrFail();

        $this->assertTrue($post->isScheduled(), 'Debe quedar programado.');
        $this->assertFalse($post->isPublished());
        $this->assertFalse(Post::published()->whereKey($post->id)->exists());
    }

    public function test_publish_at_fecha_pasada_concreta_publica(): void
    {
        $pasado = now()->subDays(3)->format('Y-m-d\TH:i');

        $this->asAdmin()->post(route('admin.posts.store'), $this->validPayload(['publish_at' => $pasado]));

        $post = Post::firstOrFail();

        $this->assertTrue($post->isPublished());
        $this->assertSame(
            now()->subDays(3)->format('Y-m-d H:i'),
            $post->published_at->format('Y-m-d H:i')
        );
    }

    // ====================================================================
    // 2. EDICIÓN  (update → guardar cambios)
    // ====================================================================

    public function test_editar_borrador_y_publicarlo(): void
    {
        $post = Post::create($this->validPayload(['slug' => 'borrador', 'published_at' => null]));

        $this->asAdmin()
            ->put(route('admin.posts.update', $post), $this->validPayload([
                'slug'       => 'borrador',
                'title'      => 'Ahora publicado',
                'publish_at' => 'now',
            ]))
            ->assertRedirect(route('admin.posts.index'));

        $post->refresh();
        $this->assertSame('Ahora publicado', $post->title);
        $this->assertTrue($post->isPublished());
    }

    public function test_editar_publicado_y_volver_a_borrador(): void
    {
        $post = Post::create($this->validPayload(['slug' => 'pub', 'published_at' => now()->subDay()]));

        $this->asAdmin()
            ->put(route('admin.posts.update', $post), $this->validPayload([
                'slug'       => 'pub',
                'publish_at' => '', // volver a borrador
            ]))
            ->assertRedirect(route('admin.posts.index'));

        $this->assertNull($post->refresh()->published_at);
    }

    public function test_editar_articulo_con_imagen_guarda_los_cambios(): void
    {
        // Regresión directa del bug del <form> anidado: el artículo TIENE imagen.
        Storage::fake('public');
        Storage::disk('public')->put('posts/foto.webp', 'bytes');

        $post = Post::create($this->validPayload([
            'slug'         => 'con-imagen',
            'image'        => 'posts/foto.webp',
            'published_at' => now()->subDay(),
        ]));

        $this->asAdmin()
            ->put(route('admin.posts.update', $post), $this->validPayload([
                'slug'    => 'con-imagen',
                'title'   => 'Título editado con imagen presente',
                'excerpt' => 'Resumen editado.',
                'publish_at' => 'now',
            ]))
            ->assertRedirect(route('admin.posts.index'));

        $post->refresh();
        $this->assertSame('Título editado con imagen presente', $post->title);
        $this->assertSame('Resumen editado.', $post->excerpt);
        $this->assertSame('posts/foto.webp', $post->image, 'La imagen debe conservarse al editar.');
    }

    public function test_subir_nueva_imagen_al_editar_reemplaza_y_borra_la_anterior(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/vieja.webp', 'bytes-viejos');

        $post = Post::create($this->validPayload([
            'slug'         => 'reemplazo',
            'image'        => 'posts/vieja.webp',
            'published_at' => now()->subDay(),
        ]));

        $this->asAdmin()
            ->put(route('admin.posts.update', $post), $this->validPayload([
                'slug'  => 'reemplazo',
                'image' => UploadedFile::fake()->image('nueva.jpg', 1600, 900),
            ]))
            ->assertRedirect(route('admin.posts.index'))
            ->assertSessionHasNoErrors();

        $post->refresh();
        $this->assertNotSame('posts/vieja.webp', $post->image, 'La imagen debe cambiar.');
        $this->assertStringEndsWith('.webp', $post->image);
        Storage::disk('public')->assertExists($post->image);
        Storage::disk('public')->assertMissing('posts/vieja.webp');
    }

    public function test_imagen_invalida_al_editar_es_rechazada(): void
    {
        Storage::fake('public');

        $post = Post::create($this->validPayload(['slug' => 'img-invalida', 'published_at' => now()->subDay()]));

        $this->asAdmin()
            ->put(route('admin.posts.update', $post), $this->validPayload([
                'slug'  => 'img-invalida',
                'image' => UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf'),
            ]))
            ->assertSessionHasErrors('image');
    }

    public function test_actualizar_sin_cambiar_slug_no_falla_por_unicidad(): void
    {
        $post = Post::create($this->validPayload(['slug' => 'mi-slug', 'published_at' => now()->subDay()]));

        $this->asAdmin()
            ->put(route('admin.posts.update', $post), $this->validPayload([
                'slug'  => 'mi-slug', // mismo slug que ya tiene
                'title' => 'Editado',
            ]))
            ->assertRedirect(route('admin.posts.index'))
            ->assertSessionHasNoErrors();

        $this->assertSame('Editado', $post->refresh()->title);
    }

    // ====================================================================
    // 3. ESTRUCTURA DEL FORMULARIO DE EDICIÓN  (regresión <form> anidado)
    // ====================================================================

    public function test_el_formulario_de_edicion_con_imagen_no_anida_formularios(): void
    {
        $post = Post::create($this->validPayload([
            'slug'         => 'con-imagen-html',
            'image'        => 'posts/foto.webp',
            'published_at' => now()->subDay(),
        ]));

        $html = $this->asAdmin()->get(route('admin.posts.edit', $post))->assertOk()->getContent();

        // El botón "Guardar cambios" DEBE aparecer antes del primer </form>,
        // es decir, dentro del formulario principal.
        $posGuardar = strpos($html, 'Guardar cambios');
        $posCierre  = strpos($html, '</form>');

        $this->assertNotFalse($posGuardar, 'Debe existir el botón Guardar cambios.');
        $this->assertNotFalse($posCierre, 'Debe existir un cierre de formulario.');
        $this->assertLessThan(
            $posCierre,
            $posGuardar,
            'El botón "Guardar cambios" quedó fuera del formulario principal (form anidado).'
        );

        // El botón "Quitar imagen" usa el form auxiliar externo vía atributo form=.
        $this->assertStringContainsString('form="remove-image-form"', $html);
        $this->assertStringContainsString('id="remove-image-form"', $html);
    }

    public function test_el_formulario_sin_imagen_no_renderiza_form_auxiliar(): void
    {
        $post = Post::create($this->validPayload(['slug' => 'sin-imagen', 'image' => null]));

        $html = $this->asAdmin()->get(route('admin.posts.edit', $post))->assertOk()->getContent();

        $this->assertStringNotContainsString('remove-image-form', $html);
        $this->assertStringNotContainsString('Quitar imagen', $html);
    }

    public function test_quitar_imagen_elimina_la_imagen_y_el_archivo(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/quitar.webp', 'bytes');

        $post = Post::create($this->validPayload([
            'slug'  => 'quitar',
            'image' => 'posts/quitar.webp',
        ]));

        $this->asAdmin()
            ->delete(route('admin.posts.destroyImage', $post))
            ->assertRedirect(route('admin.posts.edit', $post));

        $this->assertNull($post->refresh()->image);
        Storage::disk('public')->assertMissing('posts/quitar.webp');
    }

    // ====================================================================
    // 4. VISTA PREVIA  (regresión published_at null)
    // ====================================================================

    public function test_vista_previa_de_un_borrador_no_revienta(): void
    {
        $post = Post::create($this->validPayload([
            'slug'         => 'borrador-preview',
            'title'        => 'Borrador en vista previa',
            'published_at' => null, // <- el caso que reventaba
        ]));

        $this->asAdmin()
            ->get(route('admin.posts.preview', $post))
            ->assertOk()
            ->assertSee('Borrador en vista previa');
    }

    public function test_vista_previa_de_borrador_usa_created_at_como_datePublished(): void
    {
        // La línea corregida en show.blade.php: ($post->published_at ?? $post->created_at).
        // En un borrador published_at es null, así que el JSON-LD debe caer a created_at.
        $post = Post::create($this->validPayload([
            'slug'         => 'borrador-jsonld',
            'published_at' => null,
        ]));

        $this->asAdmin()
            ->get(route('admin.posts.preview', $post))
            ->assertOk()
            ->assertSee('"datePublished": "' . $post->created_at->toIso8601String() . '"', false);
    }

    public function test_vista_previa_de_un_articulo_publicado_funciona(): void
    {
        $post = Post::create($this->validPayload([
            'slug'         => 'pub-preview',
            'title'        => 'Publicado en vista previa',
            'published_at' => now()->subDay(),
        ]));

        $this->asAdmin()
            ->get(route('admin.posts.preview', $post))
            ->assertOk()
            ->assertSee('Publicado en vista previa');
    }

    public function test_vista_previa_requiere_autenticacion(): void
    {
        $post = Post::create($this->validPayload(['slug' => 'priv-preview', 'published_at' => null]));

        // Sin sesión de admin: el middleware muestra el login (200) en vez del artículo.
        $this->get(route('admin.posts.preview', $post))
            ->assertDontSee($post->title);
    }

    // ====================================================================
    // 5. VALIDACIÓN
    // ====================================================================

    public function test_no_se_crea_sin_contenido(): void
    {
        $payload = $this->validPayload(['publish_at' => 'now']);
        unset($payload['content']);

        $this->asAdmin()
            ->post(route('admin.posts.store'), $payload)
            ->assertSessionHasErrors('content');

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_no_se_crea_sin_titulo(): void
    {
        $payload = $this->validPayload();
        unset($payload['title']);

        $this->asAdmin()
            ->post(route('admin.posts.store'), $payload)
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_slug_explicito_duplicado_es_rechazado_por_validacion(): void
    {
        Post::create($this->validPayload(['slug' => 'repetido', 'published_at' => now()->subDay()]));

        $this->asAdmin()->post(route('admin.posts.store'), $this->validPayload([
            'title'      => 'Otro',
            'slug'       => 'repetido', // slug explícito que ya existe
            'publish_at' => 'now',
        ]))->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('posts', 1);
    }

    public function test_slug_autogenerado_desde_titulo_se_deduplica(): void
    {
        Post::create($this->validPayload(['slug' => 'repetido', 'published_at' => now()->subDay()]));

        // Slug vacío: se deriva del título ("Repetido" → "repetido"), que choca,
        // y uniqueSlug() debe convertirlo en "repetido-2".
        $this->asAdmin()->post(route('admin.posts.store'), $this->validPayload([
            'title'      => 'Repetido',
            'slug'       => '',
            'publish_at' => 'now',
        ]))->assertSessionHasNoErrors();

        $slugs = Post::pluck('slug')->all();
        $this->assertContains('repetido', $slugs);
        $this->assertContains('repetido-2', $slugs);
    }

    // ====================================================================
    // 6. FILTROS DEL ÍNDICE POR ESTADO  (programado / publicado)
    // ====================================================================

    public function test_index_filtra_programados(): void
    {
        Post::create($this->validPayload(['title' => 'Es publicado', 'slug' => 'p1', 'published_at' => now()->subDay()]));
        Post::create($this->validPayload(['title' => 'Es programado', 'slug' => 'p2', 'published_at' => now()->addWeek()]));
        Post::create($this->validPayload(['title' => 'Es borrador', 'slug' => 'p3', 'published_at' => null]));

        $this->asAdmin()
            ->get(route('admin.posts.index', ['status' => 'scheduled']))
            ->assertOk()
            ->assertSee('Es programado')
            ->assertDontSee('Es publicado')
            ->assertDontSee('Es borrador');
    }

    public function test_index_filtra_publicados(): void
    {
        Post::create($this->validPayload(['title' => 'Visible ya', 'slug' => 'q1', 'published_at' => now()->subDay()]));
        Post::create($this->validPayload(['title' => 'Aún programado', 'slug' => 'q2', 'published_at' => now()->addWeek()]));
        Post::create($this->validPayload(['title' => 'Aún borrador', 'slug' => 'q3', 'published_at' => null]));

        $this->asAdmin()
            ->get(route('admin.posts.index', ['status' => 'published']))
            ->assertOk()
            ->assertSee('Visible ya')
            ->assertDontSee('Aún programado')
            ->assertDontSee('Aún borrador');
    }
}
