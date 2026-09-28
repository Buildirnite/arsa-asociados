<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceAreaTest extends TestCase
{
    // El sitemap consulta Post::published(), así que la tabla posts debe existir.
    use RefreshDatabase;

    public function test_service_area_page_renders(): void
    {
        $this->get(route('service-areas.show', 'estacion-central'))
            ->assertOk()
            ->assertSee('Abogados en Estación Central')
            ->assertSee('Preguntas frecuentes')
            ->assertSee('FAQPage', false); // schema JSON-LD presente
    }

    public function test_unknown_service_area_returns_404(): void
    {
        $this->get(route('service-areas.show', 'comuna-inexistente'))->assertNotFound();
    }

    public function test_index_lists_featured_and_other_communes(): void
    {
        $this->get(route('service-areas.index'))
            ->assertOk()
            ->assertSee(route('service-areas.show', 'maipu'), false)
            ->assertSee('Recoleta'); // comuna sin página propia, listada solo en el hub
    }

    public function test_home_links_to_service_areas_index(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('service-areas.index'), false);
    }

    public function test_sitemap_includes_service_areas(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee(route('service-areas.index'), false)
            ->assertSee(route('service-areas.show', 'san-bernardo'), false);
    }
}
