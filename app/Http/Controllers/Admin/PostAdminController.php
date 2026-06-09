<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\ImageOptimizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PostAdminController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%' . $request->input('q') . '%'))
            ->when($request->input('category'), fn ($q, $category) => $q->where('category', $category))
            ->when($request->input('status'), function ($q, $status) {
                match ($status) {
                    'published' => $q->whereNotNull('published_at')->where('published_at', '<=', now()),
                    'scheduled' => $q->where('published_at', '>', now()),
                    'draft'     => $q->whereNull('published_at'),
                    default     => null,
                };
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', [
            'posts'      => $posts,
            'categories' => Post::CATEGORIES,
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', ['post' => new Post]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);
        $base = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($validated['title']);
        $validated['slug'] = $this->uniqueSlug($base);
        $validated['published_at'] = $request->filled('publish_at')
            ? \Carbon\Carbon::parse($request->input('publish_at'))
            : null;

        if ($request->hasFile('image')) {
            $validated['image'] = ImageOptimizer::store($request->file('image'), 'posts');
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Artículo creado.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatePost($request, $post->id);

        $base = $request->filled('slug') ? Str::slug($request->input('slug')) : $post->slug;
        $validated['slug'] = $this->uniqueSlug($base ?: $post->slug, $post->id);

        $validated['published_at'] = $request->filled('publish_at')
            ? \Carbon\Carbon::parse($request->input('publish_at'))
            : null;

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = ImageOptimizer::store($request->file('image'), 'posts');
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Artículo actualizado.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $this->deleteInlineImages($post->content);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Artículo eliminado.');
    }

    public function destroyImage(Post $post): RedirectResponse
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
            $post->update(['image' => null]);
        }

        return redirect()->route('admin.posts.edit', $post)->with('success', 'Imagen eliminada.');
    }

    public function uploadImage(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['image' => ['required', 'image', 'mimes:jpeg,png,webp', 'max:2048']]);
        $path = ImageOptimizer::store($request->file('image'), 'posts/inline');

        return response()->json(['url' => Storage::url($path)]);
    }

    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $posts = Post::orderByDesc('created_at')->get();

        $filename = 'articulos-arsa-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($posts) {
            $file = fopen('php://output', 'w');

            // BOM para compatibilidad con Excel en español
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, ['ID', 'Título', 'Categoría', 'Resumen', 'Contenido', 'Estado', 'Fecha publicación', 'Slug']);

            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->id,
                    $post->title,
                    $post->category,
                    $post->excerpt,
                    $post->content,
                    $post->isPublished() ? 'Publicado' : ($post->isScheduled() ? 'Programado' : 'Borrador'),
                    $post->published_at?->format('d/m/Y') ?? '—',
                    $post->slug,
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    public function preview(Post $post): View
    {
        return view('blog.show', ['post' => $post, 'related' => collect()]);
    }

    /**
     * Borra del disco las imágenes insertadas dentro del contenido del artículo
     * (posts/inline/...), para no dejar archivos huérfanos al eliminar el post.
     */
    private function deleteInlineImages(?string $content): void
    {
        if (blank($content)) {
            return;
        }

        preg_match_all('#/storage/(posts/inline/[^\s"\'?)]+)#', $content, $matches);

        foreach (array_unique($matches[1] ?? []) as $path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $i    = 1;

        while (Post::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-" . ++$i;
        }

        return $slug;
    }

    private function validatePost(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'slug'             => ['nullable', 'string', 'max:200', Rule::unique('posts', 'slug')->ignore($ignoreId)],
            'excerpt'          => ['required', 'string', 'max:300'],
            'content'          => ['required', 'string'],
            'category'         => ['required', 'string', 'max:60'],
            'image'            => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'meta_title'       => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ]);
    }
}
