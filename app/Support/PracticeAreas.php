<?php

namespace App\Support;

/**
 * Áreas de práctica del estudio. Fuente única usada por las páginas de servicio,
 * el sitemap y los enlaces de la home.
 */
class PracticeAreas
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'derecho-civil' => [
                'slug'    => 'derecho-civil',
                'name'    => 'Derecho Civil',
                'tagline' => 'Contratos, propiedad, responsabilidad civil, herencias y sucesiones.',
                'icon'    => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z',
                'intro'   => 'El Derecho Civil regula las relaciones entre particulares y es la base de la mayoría de los conflictos patrimoniales y personales. En Arsa & Asociados le asesoramos con rigor técnico para proteger su patrimonio y hacer valer sus derechos, ya sea en la redacción de un contrato o en un juicio.',
                'services' => [
                    'Redacción y revisión de contratos',
                    'Responsabilidad civil e indemnización de perjuicios',
                    'Herencias, testamentos y posesión efectiva',
                    'Particiones de bienes y comunidades',
                    'Acciones posesorias y de dominio',
                ],
                'faqs' => [
                    ['¿Necesito un abogado para redactar un contrato?', 'No es obligatorio, pero sí altamente recomendable. Un contrato bien redactado previene conflictos futuros y protege sus intereses. Una revisión profesional cuesta mucho menos que un juicio.'],
                    ['¿Qué es una posesión efectiva y cuándo la necesito?', 'Es el trámite que reconoce legalmente a los herederos de una persona fallecida. Se requiere para poder disponer de los bienes hereditarios (vender, transferir o inscribir propiedades).'],
                ],
                'meta_description' => 'Asesoría en Derecho Civil en Santiago: contratos, herencias, responsabilidad civil y particiones. Proteja su patrimonio con Arsa & Asociados.',
            ],
            'derecho-laboral' => [
                'slug'    => 'derecho-laboral',
                'name'    => 'Derecho Laboral',
                'tagline' => 'Despidos, finiquitos, negociación colectiva y defensa ante tribunales.',
                'icon'    => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z',
                'intro'   => 'El Derecho Laboral protege los derechos de trabajadores y entrega seguridad jurídica a los empleadores. Le representamos en despidos injustificados, cobro de prestaciones, finiquitos y conflictos laborales, defendiendo sus intereses ante la Inspección del Trabajo y los Tribunales Laborales.',
                'services' => [
                    'Despidos injustificados y nulidad del despido',
                    'Cobro de finiquitos y prestaciones adeudadas',
                    'Autodespido (despido indirecto)',
                    'Tutela de derechos fundamentales',
                    'Asesoría a empresas en materia laboral',
                ],
                'faqs' => [
                    ['Me despidieron, ¿cuánto tiempo tengo para reclamar?', 'El plazo para demandar por despido injustificado es de 60 días hábiles desde la separación, que se suspende si reclama ante la Inspección del Trabajo. No deje pasar el tiempo: actúe cuanto antes.'],
                    ['¿Qué puedo hacer si no me pagan el finiquito?', 'Puede exigir el pago ante la Inspección del Trabajo o demandar directamente ante el Tribunal Laboral. Le ayudamos a calcular lo que realmente le corresponde y a recuperarlo.'],
                ],
                'meta_description' => 'Abogados laborales en Santiago: despidos, finiquitos, autodespido y tutela de derechos. Defensa para trabajadores y empresas en Arsa & Asociados.',
            ],
            'derecho-de-familia' => [
                'slug'    => 'derecho-de-familia',
                'name'    => 'Derecho de Familia',
                'tagline' => 'Divorcios, pensiones alimenticias, cuidado personal y régimen de visitas.',
                'icon'    => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
                'intro'   => 'Los asuntos de familia requieren un enfoque humano además de técnico. Le acompañamos en los momentos más sensibles con cercanía y firmeza, buscando siempre la mejor solución para usted y sus hijos, ya sea mediante acuerdo o defendiendo sus derechos en tribunales.',
                'services' => [
                    'Divorcio de común acuerdo y contencioso',
                    'Pensión de alimentos (demanda, rebaja y cobro)',
                    'Cuidado personal y relación directa y regular',
                    'Compensación económica',
                    'Medidas de protección y violencia intrafamiliar',
                ],
                'faqs' => [
                    ['¿Cuánto demora un divorcio en Chile?', 'Un divorcio de común acuerdo puede resolverse en pocos meses. El divorcio unilateral, que exige acreditar el cese de la convivencia, suele tomar más tiempo. Le orientamos según su caso particular.'],
                    ['¿Cómo se calcula la pensión de alimentos?', 'Se considera tanto las necesidades del hijo como la capacidad económica del alimentante. La ley fija mínimos según el número de hijos. Le ayudamos a determinar un monto justo y a hacerlo cumplir.'],
                ],
                'meta_description' => 'Abogados de familia en Santiago: divorcios, pensión de alimentos, cuidado personal y compensación económica. Enfoque humano en Arsa & Asociados.',
            ],
            'derecho-inmobiliario' => [
                'slug'    => 'derecho-inmobiliario',
                'name'    => 'Derecho Inmobiliario',
                'tagline' => 'Compraventa, arriendos, estudio de títulos y regularización de propiedades.',
                'icon'    => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z',
                'intro'   => 'Comprar, vender o arrendar una propiedad implica riesgos jurídicos que conviene anticipar. Realizamos estudios de títulos, redactamos contratos seguros y regularizamos propiedades para que su inversión inmobiliaria esté plenamente protegida.',
                'services' => [
                    'Estudio de títulos de propiedad',
                    'Redacción de contratos de compraventa y arriendo',
                    'Regularización de propiedades (Ley 20.898)',
                    'Promesas de compraventa',
                    'Conflictos de arrendamiento y desalojos',
                ],
                'faqs' => [
                    ['¿Qué es un estudio de títulos y por qué es importante?', 'Es la revisión legal del historial de una propiedad para confirmar que el vendedor es el dueño y que no existen hipotecas, embargos ni problemas. Es imprescindible antes de comprar para evitar sorpresas.'],
                    ['¿Puedo arrendar sin contrato escrito?', 'No es recomendable. Un contrato escrito protege tanto al arrendador como al arrendatario y es esencial para hacer valer sus derechos en caso de conflicto o no pago.'],
                ],
                'meta_description' => 'Derecho Inmobiliario en Santiago: estudio de títulos, compraventa, arriendos y regularización de propiedades. Inversión segura con Arsa & Asociados.',
            ],
            'cobranza-judicial' => [
                'slug'    => 'cobranza-judicial',
                'name'    => 'Cobranza Judicial',
                'tagline' => 'Recuperación de créditos y deudas mediante gestión prejudicial y juicios ejecutivos.',
                'icon'    => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'intro'   => 'Recuperar lo que le adeudan requiere una estrategia eficaz y persistente. Gestionamos la cobranza de sus créditos desde la etapa prejudicial hasta los procedimientos ejecutivos, actuando con rapidez para maximizar la recuperación.',
                'services' => [
                    'Cobranza prejudicial de deudas',
                    'Juicios ejecutivos',
                    'Cobro de cheques, pagarés y facturas',
                    'Gestión preparatoria de la vía ejecutiva',
                    'Embargos y realización de bienes',
                ],
                'faqs' => [
                    ['¿Con qué documentos puedo iniciar una cobranza judicial?', 'Cheques, pagarés, facturas, letras de cambio y escrituras públicas son títulos que permiten un cobro ejecutivo más rápido. Evaluamos su documento y le indicamos la mejor vía.'],
                    ['¿Cuánto cuesta cobrar una deuda?', 'Trabajamos con esquemas adaptados a cada caso. Lo importante es que el costo de recuperar suele ser muy inferior al monto adeudado. Le entregamos una evaluación clara desde el inicio.'],
                ],
                'meta_description' => 'Cobranza judicial en Santiago: recupere sus créditos con juicios ejecutivos y cobro de cheques, pagarés y facturas. Arsa & Asociados.',
            ],
            'derecho-penal' => [
                'slug'    => 'derecho-penal',
                'name'    => 'Derecho Penal',
                'tagline' => 'Defensa penal, querellas y representación ante tribunales de garantía y juicio oral.',
                'icon'    => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                'intro'   => 'En materia penal, cada minuto cuenta y la defensa técnica es determinante. Le representamos con máxima dedicación como imputado o como víctima, resguardando sus derechos en cada etapa del proceso, desde la investigación hasta el juicio oral.',
                'services' => [
                    'Defensa penal de imputados',
                    'Querellas y representación de víctimas',
                    'Audiencias de control de detención y formalización',
                    'Salidas alternativas y procedimientos abreviados',
                    'Delitos económicos y de cuello blanco',
                ],
                'faqs' => [
                    ['Detuvieron a un familiar, ¿qué hago?', 'Contáctenos de inmediato. En las primeras horas se realizan diligencias clave como el control de detención. Contar con defensa especializada desde el inicio puede marcar la diferencia en el resultado.'],
                    ['¿Puedo presentar una querella como víctima?', 'Sí. La querella le permite participar activamente en el proceso, proponer diligencias y exigir reparación. Le asesoramos para ejercer plenamente sus derechos como víctima.'],
                ],
                'meta_description' => 'Defensa penal en Santiago: imputados y víctimas, querellas y juicio oral. Representación con máxima dedicación en Arsa & Asociados.',
            ],
        ];
    }

    public static function find(string $slug): ?array
    {
        return self::all()[$slug] ?? null;
    }
}
