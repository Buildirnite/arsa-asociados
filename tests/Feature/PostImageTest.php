<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostImageTest extends TestCase
{
    use RefreshDatabase;

    private function asAdmin(): self
    {
        return $this->withSession(['admin_authenticated' => true]);
    }

    public function test_featured_image_is_optimized_to_webp_on_create(): void
    {
        Storage::fake('public');

        $this->asAdmin()->post(route('admin.posts.store'), [
            'title'    => 'Artículo con imagen',
            'excerpt'  => 'Un resumen de prueba para el artículo.',
            'content'  => '<p>Contenido del artículo.</p>',
            'category' => 'General',
            'image'    => UploadedFile::fake()->image('foto.jpg', 2000, 1200),
        ])->assertRedirect(route('admin.posts.index'));

        $post = Post::firstOrFail();

        $this->assertNotNull($post->image);
        $this->assertStringEndsWith('.webp', $post->image);
        Storage::disk('public')->assertExists($post->image);
    }

    public function test_inline_images_are_deleted_with_the_post(): void
    {
        Storage::fake('public');

        // Simula una imagen insertada en el editor (posts/inline/...).
        $inlinePath = 'posts/inline/' . \Illuminate\Support\Str::uuid() . '.webp';
        Storage::disk('public')->put($inlinePath, 'fake-bytes');

        $post = Post::create([
            'title'   => 'Con imagen inline',
            'slug'    => 'con-imagen-inline',
            'excerpt' => 'Resumen.',
            'content' => '<p>Texto</p><img src="/storage/' . $inlinePath . '" alt="x">',
        ]);

        Storage::disk('public')->assertExists($inlinePath);

        $this->asAdmin()
            ->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'));

        Storage::disk('public')->assertMissing($inlinePath);
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_uploaded_inline_image_endpoint_returns_webp_url(): void
    {
        Storage::fake('public');

        $response = $this->asAdmin()->post(route('admin.posts.upload-image'), [
            'image' => UploadedFile::fake()->image('inline.png', 800, 600),
        ]);

        $response->assertOk();
        $url = $response->json('url');

        $this->assertStringContainsString('posts/inline/', $url);
        $this->assertStringEndsWith('.webp', $url);
    }
}
