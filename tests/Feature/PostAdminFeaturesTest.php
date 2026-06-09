<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAdminFeaturesTest extends TestCase
{
    use RefreshDatabase;

    private function asAdmin(): self
    {
        return $this->withSession(['admin_authenticated' => true]);
    }

    // ---------- Tabla de contenidos ----------

    public function test_table_of_contents_extracts_headings(): void
    {
        $post = new Post([
            'content' => '<h2>Primera</h2><p>x</p><h3>Sub</h3><h2>Segunda</h2>',
        ]);

        $toc = $post->tableOfContents();

        $this->assertCount(3, $toc);
        $this->assertSame(['id' => 'primera', 'text' => 'Primera', 'level' => 2], $toc[0]);
        $this->assertSame(3, $toc[1]['level']);
    }

    public function test_content_with_anchors_injects_ids(): void
    {
        $post = new Post(['content' => '<h2>Mi Sección</h2>']);

        $this->assertStringContainsString('<h2 id="mi-seccion">Mi Sección</h2>', $post->contentWithAnchors());
    }

    // ---------- Filtros del índice ----------

    public function test_index_filters_by_status_draft(): void
    {
        Post::create(['title' => 'Publicado', 'slug' => 'pub', 'excerpt' => 'e', 'content' => 'c', 'published_at' => now()->subDay()]);
        Post::create(['title' => 'Sin publicar', 'slug' => 'draft', 'excerpt' => 'e', 'content' => 'c', 'published_at' => null]);

        $this->asAdmin()
            ->get(route('admin.posts.index', ['status' => 'draft']))
            ->assertOk()
            ->assertSee('Sin publicar')
            ->assertDontSee('>Publicado<', false);
    }

    public function test_index_searches_by_title(): void
    {
        Post::create(['title' => 'Pensión de alimentos', 'slug' => 'a', 'excerpt' => 'e', 'content' => 'c', 'published_at' => now()->subDay()]);
        Post::create(['title' => 'Contrato de arriendo', 'slug' => 'b', 'excerpt' => 'e', 'content' => 'c', 'published_at' => now()->subDay()]);

        $this->asAdmin()
            ->get(route('admin.posts.index', ['q' => 'arriendo']))
            ->assertOk()
            ->assertSee('Contrato de arriendo')
            ->assertDontSee('Pensión de alimentos');
    }

    public function test_index_filters_by_category(): void
    {
        Post::create(['title' => 'Civil A', 'slug' => 'c1', 'excerpt' => 'e', 'content' => 'c', 'category' => 'Derecho Civil', 'published_at' => now()->subDay()]);
        Post::create(['title' => 'Penal B', 'slug' => 'p1', 'excerpt' => 'e', 'content' => 'c', 'category' => 'Derecho Penal', 'published_at' => now()->subDay()]);

        $this->asAdmin()
            ->get(route('admin.posts.index', ['category' => 'Derecho Penal']))
            ->assertOk()
            ->assertSee('Penal B')
            ->assertDontSee('Civil A');
    }
}
