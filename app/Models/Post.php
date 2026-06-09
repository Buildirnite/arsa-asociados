<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    /** Categorías disponibles para los artículos. */
    public const CATEGORIES = [
        'Derecho Civil', 'Derecho Laboral', 'Derecho de Familia',
        'Derecho Inmobiliario', 'Cobranza Judicial', 'Derecho Penal', 'General',
    ];

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'category', 'image', 'meta_title', 'meta_description', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    public function isScheduled(): bool
    {
        return $this->published_at !== null && $this->published_at->isFuture();
    }

    public function readingTime(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->content)) / 200));
    }

    /**
     * Extrae los encabezados H2/H3 del contenido para construir el índice.
     *
     * @return array<int, array{id: string, text: string, level: int}>
     */
    public function tableOfContents(): array
    {
        preg_match_all('/<(h[23])\b[^>]*>(.*?)<\/\1>/is', $this->content ?? '', $matches, PREG_SET_ORDER);

        $toc = [];
        foreach ($matches as $match) {
            $text = trim(strip_tags($match[2]));
            if ($text === '') {
                continue;
            }
            $toc[] = [
                'id'    => Str::slug($text),
                'text'  => $text,
                'level' => (int) substr($match[1], 1),
            ];
        }

        return $toc;
    }

    /**
     * Devuelve el contenido con un id (ancla) inyectado en cada H2/H3,
     * coherente con los generados por tableOfContents().
     */
    public function contentWithAnchors(): string
    {
        return preg_replace_callback(
            '/<(h[23])\b[^>]*>(.*?)<\/\1>/is',
            function (array $m): string {
                $id = Str::slug(strip_tags($m[2]));

                return "<{$m[1]} id=\"{$id}\">{$m[2]}</{$m[1]}>";
            },
            $this->content ?? '',
        );
    }
}
