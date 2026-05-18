<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        ContactMessage::truncate();

        $messages = [
            // ── Leído 1 ────────────────────────────────────────────────────
            [
                'name'       => 'Rodrigo Fuentes Espinoza',
                'email'      => 'r.fuentes@ejemplo.cl',
                'phone'      => '+56 9 8821 4433',
                'message'    => 'Buenos días, me comunico porque necesito orientación sobre una situación laboral. Fui desvinculado de mi empresa hace dos semanas y no estoy seguro de que las causales que invocaron sean válidas. Me pagaron la liquidación pero no el mes de aviso previo. ¿Podría agendar una consulta para revisar mi caso? Quedo atento, muchas gracias.',
                'read_at'    => Carbon::now()->subDays(22)->setTime(11, 15),
                'created_at' => Carbon::now()->subDays(25)->setTime(10, 42),
                'updated_at' => Carbon::now()->subDays(22)->setTime(11, 15),
            ],

            // ── Leído 2 ────────────────────────────────────────────────────
            [
                'name'       => 'Valentina Morales Reyes',
                'email'      => 'valmorales87@ejemplo.com',
                'phone'      => null,
                'message'    => 'Hola, mi nombre es Valentina y estoy pasando por un proceso de separación. Llevamos más de un año separados con mi marido y quisiéramos hacer el divorcio de mutuo acuerdo. Tenemos dos hijos y ya tenemos ciertos acuerdos sobre tuición y pensión de alimentos, pero no sabemos cómo formalizarlo. ¿Cuánto tiempo toma el trámite y cuánto cuesta la asesoría? Gracias de antemano.',
                'read_at'    => Carbon::now()->subDays(10)->setTime(16, 30),
                'created_at' => Carbon::now()->subDays(14)->setTime(15, 8),
                'updated_at' => Carbon::now()->subDays(10)->setTime(16, 30),
            ],

            // ── No leído 1 ─────────────────────────────────────────────────
            [
                'name'       => 'Cristóbal Andrade Vargas',
                'email'      => 'candrade.v@ejemplo.net',
                'phone'      => '+56 2 2345 6789',
                'message'    => 'Estimada asesora, le escribo porque estoy en un proceso de compra de un departamento y el corredor insiste en que firme una promesa de compraventa esta semana. He revisado el documento y hay varias cláusulas que no entiendo bien, especialmente lo relacionado con las arras y la multa en caso de desistimiento. Me gustaría que alguien revisara el contrato antes de firmarlo. ¿Es posible una atención rápida esta semana?',
                'read_at'    => null,
                'created_at' => Carbon::now()->subDays(3)->setTime(9, 17),
                'updated_at' => Carbon::now()->subDays(3)->setTime(9, 17),
            ],

            // ── No leído 2 ─────────────────────────────────────────────────
            [
                'name'       => 'Carolina Ibáñez Pinto',
                'email'      => 'carolina.ibanez@ejemplo.cl',
                'phone'      => '+56 9 7654 3210',
                'message'    => 'Buenas tardes. Mi padre falleció hace un mes y estamos iniciando los trámites de posesión efectiva. Somos tres hermanos y uno de ellos dice que hay un testamento, pero nosotros no lo conocemos. No sabemos bien por dónde empezar ni qué documentos necesitamos reunir. Agradecería mucho si pudieran orientarme sobre los pasos a seguir y los plazos que debemos respetar.',
                'read_at'    => null,
                'created_at' => Carbon::now()->subDays(1)->setTime(14, 55),
                'updated_at' => Carbon::now()->subDays(1)->setTime(14, 55),
            ],
        ];

        foreach ($messages as $data) {
            (new ContactMessage())->forceFill($data)->save();
        }
    }
}
