<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Optimiza imágenes subidas: las redimensiona a un ancho máximo y las convierte
 * a WebP (más livianas, mejor SEO y velocidad). Usa GD nativo, disponible tanto
 * en el contenedor como en el servidor de producción (php8.4-gd).
 */
class ImageOptimizer
{
    /**
     * Procesa la imagen y la guarda en el disco "public".
     * Devuelve la ruta relativa almacenada.
     */
    public static function store(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1600,
        int $quality = 82,
    ): string {
        $image = self::open($file);

        // Si GD no pudo procesarla, se guarda tal cual para no perder la subida.
        if ($image === null) {
            return $file->store($directory, 'public');
        }

        $width  = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newHeight = (int) round($height * ($maxWidth / $width));
            $scaled    = imagescale($image, $maxWidth, $newHeight);

            if ($scaled !== false) {
                imagedestroy($image);
                $image = $scaled;
            }
        }

        $path = $directory . '/' . Str::uuid()->toString() . '.webp';

        ob_start();
        imagewebp($image, null, $quality);
        $contents = ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put($path, $contents);

        return $path;
    }

    /**
     * Crea un recurso GD desde el archivo subido, preservando transparencia.
     */
    private static function open(UploadedFile $file): ?\GdImage
    {
        if (! function_exists('imagecreatefromstring')) {
            return null;
        }

        $image = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));

        if ($image === false) {
            return null;
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        return $image;
    }
}
