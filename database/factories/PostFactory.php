<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake('es_ES')->sentence(6);

        return [
            'title'            => $title,
            'slug'             => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'meta_title'       => Str::limit($title, 60),
            'meta_description' => Str::limit(fake('es_ES')->sentence(18), 155),
            'excerpt'          => fake('es_ES')->paragraph(),
            'content'          => collect(fake('es_ES')->paragraphs(3))
                                    ->map(fn ($p) => "<p>{$p}</p>")
                                    ->implode(''),
            'category'         => fake()->randomElement(['derecho-civil', 'derecho-laboral', 'derecho-familia']),
            'image'            => null,
            'published_at'     => now()->subDays(fake()->numberBetween(1, 30)),
        ];
    }

    public function draft(): static
    {
        return $this->state(['published_at' => null]);
    }

    public function published(): static
    {
        return $this->state(['published_at' => now()->subDay()]);
    }

    public function scheduled(): static
    {
        return $this->state(['published_at' => now()->addDay()]);
    }
}
