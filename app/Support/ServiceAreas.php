<?php

namespace App\Support;

/**
 * Comunas de la Región Metropolitana donde el estudio atiende. Fuente única usada por el
 * hub de zonas, las páginas de comuna, el sitemap y el schema.org del layout.
 *
 * El estudio no tiene oficina física abierta al público: atiende de forma remota
 * (videollamada) y coordina encuentros presenciales según el caso. El contenido de cada
 * comuna debe reflejar eso honestamente — nunca insinuar una dirección que no existe.
 */
class ServiceAreas
{
    /**
     * Comunas con página propia: solo las que tienen contenido genuinamente distinto que
     * ofrecer (no una plantilla con el nombre cambiado). Si se agrega una comuna acá, tiene
     * que traer algo real — un dato de tribunal verificado, un perfil de demanda distinto,
     * no solo relleno.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function featured(): array
    {
        return [
            'santiago-centro' => [
                'slug' => 'santiago-centro',
                'name' => 'Santiago Centro',
                'tagline' => 'En el corazón judicial y comercial de la Región Metropolitana.',
                'intro' => 'Santiago Centro concentra la mayoría de los tribunales civiles, laborales y de familia de la Región Metropolitana, además del grueso de la actividad bancaria y comercial del país. Atendemos consultas de residentes y empresas del centro por videollamada, y coordinamos encuentros presenciales cuando el caso lo requiere — sin depender de una oficina fija.',
                'highlight_areas' => ['derecho-civil', 'cobranza-judicial', 'derecho-laboral'],
                'court_note' => 'La mayoría de las causas civiles, laborales y de familia de comunas vecinas también se litigan en los tribunales con asiento en Santiago, así que conocemos bien sus tiempos y procedimientos.',
                'faqs' => [
                    ['¿Atienden empresas del centro además de personas naturales?', 'Sí. Además de derecho de familia y civil para personas, asesoramos a empresas y comercios del centro en contratos, cobranza y materia laboral.'],
                    ['¿Puedo hacer todo el proceso sin ir a una oficina?', 'En la mayoría de los casos sí: las reuniones son por videollamada y solo se requiere presencia física para audiencias específicas del tribunal, no para reunirse con nosotros.'],
                ],
                'meta_description' => 'Abogados para Santiago Centro: derecho civil, laboral y cobranza judicial. Atención por videollamada, primera consulta sin costo — Arsa & Asociados.',
            ],
            'estacion-central' => [
                'slug' => 'estacion-central',
                'name' => 'Estación Central',
                'tagline' => 'Asesoría laboral, de familia y penal para una de las comunas con más población trabajadora de Santiago.',
                'intro' => 'Estación Central combina un alto número de trabajadores dependientes con una fuerte presencia estudiantil y comercial. Las consultas más frecuentes que recibimos de esta comuna son por despidos, finiquitos mal calculados y asuntos de familia. Coordinamos toda la atención de forma remota, sin que tenga que trasladarse a una oficina.',
                'highlight_areas' => ['derecho-laboral', 'derecho-de-familia', 'derecho-penal'],
                'court_note' => 'En materia penal, Estación Central depende del 6° Juzgado de Garantía de Santiago (que también cubre Quinta Normal); las causas civiles y laborales se litigan en los tribunales con asiento en Santiago.',
                'faqs' => [
                    ['Me despidieron sin causa justificada, ¿qué hago primero?', 'Reúna su liquidación de sueldo, contrato y carta de despido, y contáctenos cuanto antes: el plazo para reclamar es de 60 días hábiles desde la separación.'],
                    ['¿Trabajan también con estudiantes o personas con pocos recursos?', 'La primera consulta es siempre sin costo, precisamente para que cualquier persona pueda entender sus opciones antes de decidir cómo seguir.'],
                ],
                'meta_description' => 'Abogados en Estación Central: despidos, finiquitos y derecho de familia. Primera consulta sin costo, atención por videollamada — Arsa & Asociados.',
            ],
            'maipu' => [
                'slug' => 'maipu',
                'name' => 'Maipú',
                'tagline' => 'Derecho de familia, inmobiliario y laboral para una de las comunas más pobladas de Chile.',
                'intro' => 'Maipú es una de las comunas más grandes y con mayor crecimiento habitacional del país, lo que trae consigo tanto conflictos de familia como consultas inmobiliarias (compraventas, loteos, arriendos). Atendemos a vecinos de Maipú de forma remota, con la misma dedicación que si tuviéramos oficina en la comuna.',
                'highlight_areas' => ['derecho-de-familia', 'derecho-inmobiliario', 'derecho-laboral'],
                'court_note' => 'Maipú cuenta con su propio Juzgado de Familia, lo que agiliza bastante los tiempos frente a comunas que dependen de los tribunales de Santiago.',
                'faqs' => [
                    ['¿Puedo tramitar mi divorcio o pensión de alimentos sin viajar al centro?', 'Sí. Maipú tiene su propio Juzgado de Familia, y nosotros llevamos el caso completo de forma remota, presentándonos solo cuando la ley exige audiencia presencial.'],
                    ['Estoy comprando una casa en Maipú, ¿necesito un abogado?', 'Le recomendamos un estudio de títulos antes de firmar cualquier promesa de compraventa — es la forma de confirmar que la propiedad no tiene hipotecas, embargos ni problemas de dominio.'],
                ],
                'meta_description' => 'Abogados en Maipú: derecho de familia, inmobiliario y laboral. Maipú tiene Juzgado de Familia propio — le acompañamos en todo el proceso, Arsa & Asociados.',
            ],
            'puente-alto' => [
                'slug' => 'puente-alto',
                'name' => 'Puente Alto',
                'tagline' => 'La comuna más poblada de Chile, con tribunales propios de familia y civil.',
                'intro' => 'Puente Alto es la comuna más poblada del país, con tribunales de familia y civiles propios que atienden también a otras comunas de la provincia Cordillera. Eso significa procesos con plazos y dinámicas particulares, que conocemos de cerca. Toda la asesoría se coordina de forma remota.',
                'highlight_areas' => ['derecho-de-familia', 'derecho-civil', 'cobranza-judicial'],
                'court_note' => 'El Juzgado de Familia y el Juzgado Civil de Puente Alto tienen competencia sobre toda la provincia Cordillera (Puente Alto, Pirque y San José de Maipo).',
                'faqs' => [
                    ['Vivo en Puente Alto, ¿mi causa se ve ahí mismo?', 'En la mayoría de los casos de familia y civiles, sí — el Juzgado de Familia y el Juzgado Civil de Puente Alto tienen competencia sobre la comuna.'],
                    ['¿Cuánto demora una demanda de alimentos en Puente Alto?', 'Depende de la carga del tribunal y de si hay acuerdo entre las partes. Le damos una estimación realista apenas revisamos su caso, no un plazo genérico.'],
                ],
                'meta_description' => 'Abogados en Puente Alto: derecho de familia, civil y cobranza judicial ante los tribunales de la comuna. Primera consulta sin costo — Arsa & Asociados.',
            ],
            'la-florida' => [
                'slug' => 'la-florida',
                'name' => 'La Florida',
                'tagline' => 'Derecho de familia, civil e inmobiliario para el sector sur-oriente de Santiago.',
                'intro' => 'La Florida es una comuna extensa y mayoritariamente residencial, donde las consultas más habituales tienen que ver con familia (pensiones, cuidado personal) y con temas de propiedad y arriendos. Le atendemos por videollamada, sin necesidad de trasladarse.',
                'highlight_areas' => ['derecho-de-familia', 'derecho-civil', 'derecho-inmobiliario'],
                'faqs' => [
                    ['¿Tengo que ir a un tribunal fuera de mi comuna?', 'Dependiendo de la materia, algunas causas de La Florida se ven en tribunales que también cubren comunas vecinas. Le indicamos exactamente cuál corresponde a su caso apenas lo revisamos.'],
                    ['¿Cómo empiezo una consulta si vivo en La Florida?', 'Agende una hora o escríbanos por WhatsApp — la primera consulta es sin costo y se hace por videollamada.'],
                ],
                'meta_description' => 'Abogados en La Florida: derecho de familia, civil e inmobiliario. Atención por videollamada, primera consulta sin costo — Arsa & Asociados.',
            ],
            'nunoa' => [
                'slug' => 'nunoa',
                'name' => 'Ñuñoa',
                'tagline' => 'Derecho inmobiliario, de arriendos y civil para una comuna de alta rotación habitacional.',
                'intro' => 'Ñuñoa tiene una población flotante alta (estudiantes, arriendos de corto y mediano plazo) y una vida de barrio consolidada, lo que se traduce en consultas frecuentes sobre contratos de arriendo, desalojos y conflictos de convivencia. También asesoramos en herencias y asuntos de familia.',
                'highlight_areas' => ['derecho-inmobiliario', 'derecho-civil', 'derecho-de-familia'],
                'faqs' => [
                    ['Mi arrendatario no paga, ¿cómo inicio el desalojo?', 'Se requiere una notificación formal y, si no hay acuerdo, una demanda de terminación de contrato de arriendo. Revisamos su contrato y le indicamos el camino más rápido según su caso.'],
                    ['¿Revisan contratos de arriendo antes de firmar?', 'Sí, es una de las consultas más comunes que recibimos de Ñuñoa — una revisión previa evita conflictos costosos después.'],
                ],
                'meta_description' => 'Abogados en Ñuñoa: contratos de arriendo, desalojos y derecho civil. Primera consulta sin costo, atención por videollamada — Arsa & Asociados.',
            ],
            'san-bernardo' => [
                'slug' => 'san-bernardo',
                'name' => 'San Bernardo',
                'tagline' => 'Derecho de familia, laboral y cobranza judicial con tribunal de familia propio.',
                'intro' => 'San Bernardo cuenta con su propio Juzgado de Familia, que también atiende a Calera de Tango. Es una comuna con fuerte presencia industrial y comercial, por lo que también concentramos consultas laborales y de cobranza de facturas y pagarés.',
                'highlight_areas' => ['derecho-de-familia', 'derecho-laboral', 'cobranza-judicial'],
                'court_note' => 'El Juzgado de Familia de San Bernardo tiene competencia sobre San Bernardo y Calera de Tango.',
                'faqs' => [
                    ['¿El Juzgado de Familia de San Bernardo también ve causas de Calera de Tango?', 'Sí, ambas comunas comparten el mismo tribunal de familia.'],
                    ['Tengo una empresa en San Bernardo y me deben facturas, ¿qué opciones tengo?', 'Si cuenta con la factura, pagaré o documento correspondiente, puede iniciarse un cobro ejecutivo, que suele ser más rápido que un juicio ordinario. Evaluamos su documentación sin costo.'],
                ],
                'meta_description' => 'Abogados en San Bernardo: derecho de familia (con tribunal propio), laboral y cobranza judicial. Primera consulta sin costo — Arsa & Asociados.',
            ],
            'providencia' => [
                'slug' => 'providencia',
                'name' => 'Providencia',
                'tagline' => 'Derecho civil, comercial e inmobiliario para una de las comunas con más oficinas de Santiago.',
                'intro' => 'Providencia concentra una alta densidad de oficinas, comercio y edificios residenciales de alto valor, lo que se traduce en consultas sobre contratos comerciales, arriendos de oficina, copropiedad y cobranza entre empresas. Coordinamos toda la asesoría de forma remota, con la misma seriedad que exige una comuna de este perfil.',
                'highlight_areas' => ['derecho-civil', 'derecho-inmobiliario', 'cobranza-judicial'],
                'faqs' => [
                    ['¿Asesoran a empresas, no solo a personas naturales?', 'Sí, buena parte de nuestras consultas de Providencia son de empresas y profesionales independientes que necesitan revisar contratos o cobrar deudas comerciales.'],
                    ['Tengo un conflicto con la administración de mi edificio, ¿me pueden ayudar?', 'Sí, los conflictos de copropiedad (gastos comunes, reglamento de copropiedad) son parte de nuestra práctica de derecho civil e inmobiliario.'],
                ],
                'meta_description' => 'Abogados en Providencia: derecho civil, comercial e inmobiliario. Asesoría a empresas y particulares, primera consulta sin costo — Arsa & Asociados.',
            ],
        ];
    }

    public static function find(string $slug): ?array
    {
        return self::featured()[$slug] ?? null;
    }

    /**
     * Resto de comunas del Gran Santiago sin página propia: se listan en el hub con una
     * mención breve, no una página indexable — evita contenido delgado duplicado a escala.
     *
     * @return list<string>
     */
    public static function others(): array
    {
        return [
            'Independencia', 'Recoleta', 'Conchalí', 'Huechuraba', 'Quilicura', 'Renca',
            'Quinta Normal', 'Lo Prado', 'Pudahuel', 'Cerro Navia', 'San Miguel', 'San Joaquín',
            'La Granja', 'La Pintana', 'San Ramón', 'El Bosque', 'Lo Espejo',
            'Pedro Aguirre Cerda', 'La Cisterna', 'La Reina', 'Las Condes', 'Vitacura',
            'Lo Barnechea', 'Macul', 'Peñalolén', 'Padre Hurtado', 'Calera de Tango',
            'Colina', 'Lampa', 'Buin', 'Paine', 'Talagante', 'Peñaflor', 'El Monte',
            'Isla de Maipo',
        ];
    }
}
