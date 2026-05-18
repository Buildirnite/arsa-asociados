<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_returns_200(): void
    {
        $this->get('/blog')->assertOk();
    }

    public function test_blog_show_returns_200_for_published_post(): void
    {
        $post = Post::factory()->published()->create();

        $this->get("/blog/{$post->slug}")->assertOk();
    }

    public function test_blog_show_returns_404_for_draft_post(): void
    {
        $post = Post::factory()->draft()->create();

        $this->get("/blog/{$post->slug}")->assertNotFound();
    }

    public function test_blog_show_returns_404_for_scheduled_post(): void
    {
        $post = Post::factory()->scheduled()->create();

        $this->get("/blog/{$post->slug}")->assertNotFound();
    }

    public function test_blog_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/blog/slug-que-no-existe')->assertNotFound();
    }
}
