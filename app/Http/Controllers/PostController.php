<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $buscar    = $request->input('buscar');
        $categoria = $request->input('categoria');

        $categorias = Post::published()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $posts = Post::published()
            ->when($buscar, fn ($q) => $q->where(function ($q) use ($buscar) {
                $q->where('title', 'like', "%{$buscar}%")
                  ->orWhere('excerpt', 'like', "%{$buscar}%");
            }))
            ->when($categoria, fn ($q) => $q->where('category', $categoria))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->appends($request->query());

        return view('blog.index', compact('posts', 'categorias', 'buscar', 'categoria'));
    }

    public function show(string $slug): View
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'related'));
    }
}
