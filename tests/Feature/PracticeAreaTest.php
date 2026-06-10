<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PracticeAreaTest extends TestCase
{
    // El sitemap consulta Post::published(), así que la tabla posts debe existir.
    use RefreshDatabase;

    public function test_practice_area_page_renders(): void
    {
        $this->get(route('services.show', 'derecho-de-familia'))
            ->assertOk()
            ->assertSee('Derecho de Familia')
            ->assertSee('Preguntas frecuentes')
            ->assertSee('FAQPage', false); // schema JSON-LD presente
    }

    public function test_unknown_practice_area_returns_404(): void
    {
        $this->get(route('services.show', 'area-inexistente'))->assertNotFound();
    }

    public function test_home_links_to_practice_area_pages(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('services.show', 'derecho-laboral'), false);
    }

    public function test_sitemap_includes_practice_areas(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee(route('services.show', 'cobranza-judicial'), false);
    }
}
