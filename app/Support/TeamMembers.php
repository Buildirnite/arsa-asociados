<?php

namespace App\Support;

/**
 * Socios del estudio. Fuente única usada por la sección "Nosotros" de la home.
 */
class TeamMembers
{
    /**
     * @return array<int, array<string, string>>
     */
    public static function all(): array
    {
        return [
            [
                'photo' => 'images/team/abgd2.webp',
                'name'  => 'Nicool Armas',
                'role'  => 'Socia — Asesora Jurídica',
            ],
            [
                'photo'     => 'images/team/abogada2.webp',
                'name'      => 'Solange Bolaños Sepúlveda',
                'role'      => 'Socia — Abogada',
                'specialty' => 'Diplomado en Derecho Tributario',
            ],
            [
                'photo'     => 'images/team/abogado1.webp',
                'name'      => 'Fernando Zepeda Pastén',
                'role'      => 'Socio — Abogado',
                'specialty' => 'Derecho Laboral',
            ],
        ];
    }
}
