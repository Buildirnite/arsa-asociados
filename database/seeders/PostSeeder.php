<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::truncate();

        $posts = [
            // ── Publicado 1 ────────────────────────────────────────────────
            [
                'title'            => 'Qué es un contrato de promesa de compraventa y por qué importa',
                'slug'             => 'contrato-promesa-compraventa-chile',
                'meta_title'       => 'Contrato de promesa de compraventa en Chile | Arsa & Asociados',
                'meta_description' => 'Explicamos qué es la promesa de compraventa, sus requisitos legales en Chile y los errores más comunes que pueden anularla.',
                'excerpt'          => 'La promesa de compraventa es uno de los contratos más utilizados en operaciones inmobiliarias, pero también uno de los que genera más conflictos cuando no se redacta correctamente.',
                'content'          => '<p>La promesa de compraventa es un contrato preparatorio mediante el cual las partes se obligan a celebrar en el futuro un contrato definitivo —generalmente la compraventa de un inmueble— en los términos y condiciones acordados. En Chile, su regulación se encuentra en el artículo 1554 del Código Civil, que establece cuatro requisitos copulativos para su validez.</p>

<p>El primero es que el contrato prometido no debe ser de aquellos que la ley declara ineficaces. El segundo exige que la promesa conste por escrito. El tercero demanda que el contrato prometido no sea inválido en sí mismo, es decir, que reúna todos los elementos esenciales del contrato definitivo. El cuarto y más relevante en la práctica es que la promesa contenga un plazo o condición que fije la época en que deberá celebrarse el contrato, así como la especificación del contrato prometido de manera suficiente.</p>

<p>En la práctica notarial y judicial, el requisito que más conflictos genera es justamente el cuarto: la determinación del bien raíz y del precio. Si el contrato no individualiza correctamente la propiedad —número de rol de avalúo, dirección precisa, cabida, linderos— o deja el precio sujeto a variables no acordadas, un tribunal puede declararlo nulo. Por ello es fundamental contar con asesoría jurídica especializada antes de suscribir cualquier promesa, especialmente cuando hay arras de por medio.</p>

<p>Finalmente, es importante distinguir la promesa del contrato de reserva que suelen ofrecer las inmobiliarias. Mientras la promesa es un instrumento con fuerza obligatoria regulada por el Código Civil, la reserva es un documento privado cuya eficacia jurídica es mucho más limitada. Conocer esta diferencia puede evitar sorpresas desagradables al momento de escriturar.</p>',
                'category'         => 'derecho-civil',
                'image'            => null,
                'published_at'     => Carbon::now()->subDays(20),
            ],

            // ── Publicado 2 ────────────────────────────────────────────────
            [
                'title'            => 'Derechos del trabajador ante un despido injustificado en Chile',
                'slug'             => 'derechos-trabajador-despido-injustificado-chile',
                'meta_title'       => 'Despido injustificado en Chile: qué derechos te corresponden',
                'meta_description' => 'Si fuiste despedido sin causa legal o sin los pagos correspondientes, conoce tus derechos y los plazos para reclamar ante el Juzgado del Trabajo.',
                'excerpt'          => 'El despido injustificado activa una serie de derechos a favor del trabajador que van más allá de la simple indemnización por años de servicio. Conocer estos derechos marca la diferencia.',
                'content'          => '<p>En Chile, el Código del Trabajo contempla distintas causales para poner término a un contrato de trabajo. Cuando el empleador invoca una causal que no corresponde a la realidad, omite el aviso previo o no paga las indemnizaciones correspondientes, el trabajador tiene acción legal para reclamar ante el Juzgado de Letras del Trabajo. El plazo para interponer la demanda es de sesenta días hábiles contados desde la separación, ampliable a noventa si el trabajador concurre a mediación ante la Inspección del Trabajo.</p>

<p>Las indemnizaciones a las que tiene derecho el trabajador despedido injustificadamente incluyen la indemnización por años de servicio —equivalente a treinta días de la última remuneración mensual devengada por cada año trabajado, con tope de once años—, el incremento legal del treinta, cincuenta u ochenta por ciento según la causal invocada, y la indemnización sustitutiva del aviso previo equivalente a treinta días de remuneración cuando no se dio el mes de anticipación requerido.</p>

<p>Un aspecto frecuentemente omitido es el despido indirecto o autodespido, contemplado en el artículo 171 del Código del Trabajo. Este mecanismo permite al trabajador poner término al contrato cuando es el empleador quien incurre en incumplimientos graves —como no pagar oportunamente las remuneraciones o atentar contra la integridad del trabajador— y accionar por las mismas indemnizaciones que corresponderían a un despido injustificado.</p>

<p>Antes de tomar cualquier decisión, es aconsejable revisar la carta de aviso de término de contrato, verificar que las cotizaciones previsionales estén al día y recabar todos los antecedentes de la relación laboral. Una asesoría jurídica temprana permite evaluar la solidez del caso y la conveniencia de llegar a un acuerdo en mediación o litigar en sede judicial.</p>',
                'category'         => 'derecho-laboral',
                'image'            => null,
                'published_at'     => Carbon::now()->subDays(7),
            ],

            // ── Borrador 1 ─────────────────────────────────────────────────
            [
                'title'            => 'Divorcio de mutuo acuerdo en Chile: requisitos y procedimiento',
                'slug'             => 'divorcio-mutuo-acuerdo-chile-requisitos',
                'meta_title'       => 'Divorcio de mutuo acuerdo en Chile | Requisitos y pasos',
                'meta_description' => 'Guía completa sobre el divorcio de mutuo acuerdo en Chile: plazos, requisitos, acuerdo completo y suficiente, y cómo tramitarlo correctamente.',
                'excerpt'          => 'El divorcio de mutuo acuerdo es la vía más rápida para disolver el vínculo matrimonial cuando ambos cónyuges están de acuerdo, pero exige cumplir requisitos precisos que conviene conocer.',
                'content'          => '<p>La Ley N.° 19.947 de Matrimonio Civil permite a los cónyuges solicitar el divorcio de común acuerdo cuando han cesado en la convivencia por un período mínimo de un año. A diferencia del divorcio unilateral, que exige tres años de cese de convivencia, esta vía resulta más expedita y suele resolverse en audiencia única si los antecedentes están bien preparados.</p>

<p>El requisito central es la existencia de un acuerdo completo y suficiente que regule las relaciones mutuas de los cónyuges y las relaciones entre estos y sus hijos. La jurisprudencia ha precisado que "completo" implica que el acuerdo cubra todas las materias relevantes —alimentos, tuición, régimen de visitas, bienes comunes— y "suficiente" que resguarde el interés superior de los hijos y no deje a ninguno de los cónyuges en situación de desamparo. Un acuerdo que omita alguna de estas materias puede ser rechazado por el tribunal.</p>

<p>El trámite se inicia presentando una demanda conjunta ante el Juzgado de Familia del último domicilio conyugal en Chile. Junto con la demanda deben acompañarse el certificado de matrimonio, las partidas de nacimiento de los hijos si los hay, y el acuerdo regulador suscrito por ambas partes. El tribunal puede aprobar el acuerdo, pedir ajustes o rechazarlo si no cumple los estándares de protección que exige la ley.</p>

<p>Un error frecuente es creer que basta con presentar cualquier acuerdo escrito entre las partes. La experiencia judicial muestra que los acuerdos redactados sin asesoría jurídica suelen contener vacíos que obligan a reformularlos, alargando innecesariamente el proceso. Contar con un abogado especialista desde el inicio garantiza que el acuerdo sea aceptado en la primera audiencia.</p>',
                'category'         => 'derecho-familia',
                'image'            => null,
                'published_at'     => null,
            ],

            // ── Borrador 2 ─────────────────────────────────────────────────
            [
                'title'            => 'Prescripción adquisitiva: cómo convertirse en dueño de un bien por el paso del tiempo',
                'slug'             => 'prescripcion-adquisitiva-chile-como-funciona',
                'meta_title'       => 'Prescripción adquisitiva en Chile: requisitos y plazos',
                'meta_description' => 'Aprende qué es la prescripción adquisitiva, sus tipos ordinaria y extraordinaria, y cómo tramitar el juicio para obtener el dominio de un bien.',
                'excerpt'          => 'La prescripción adquisitiva permite obtener el dominio de un bien mediante la posesión continua durante los plazos que fija la ley. Es una institución de gran relevancia práctica en Chile.',
                'content'          => '<p>La prescripción adquisitiva o usucapión es el modo de adquirir el dominio de las cosas ajenas mediante la posesión durante cierto tiempo y con los demás requisitos legales. En Chile se regula en el Título XLII del Libro IV del Código Civil y constituye una institución de amplio uso práctico, especialmente en zonas rurales donde la regularización de títulos de propiedad presenta históricas deficiencias.</p>

<p>La ley distingue dos clases principales: la prescripción ordinaria y la extraordinaria. La ordinaria exige posesión regular —esto es, que el poseedor haya obtenido el bien de buena fe y con justo título— y un plazo de dos años para muebles y cinco años para inmuebles. La extraordinaria, en cambio, no exige buena fe ni justo título y se aplica cuando no concurren los requisitos de la ordinaria, con un plazo de diez años para toda clase de bienes.</p>

<p>Para hacer valer la prescripción adquisitiva de un inmueble es necesario interponer una demanda ante el Juzgado de Letras en lo Civil del lugar en que esté ubicado el predio, acompañando antecedentes que acrediten la posesión continua, exclusiva, pública y no violenta durante el período correspondiente. Estos antecedentes pueden incluir contratos de arriendo previos, pagos de contribuciones, declaraciones de vecinos y documentos de mejoras realizadas en el inmueble.</p>

<p>Una vez dictada la sentencia declarativa, esta debe inscribirse en el Conservador de Bienes Raíces competente para que el nuevo dominio sea oponible a terceros. Este paso es fundamental: sin inscripción, la sentencia no produce el efecto de transferir la propiedad en términos registrales.</p>',
                'category'         => 'derecho-civil',
                'image'            => null,
                'published_at'     => null,
            ],

            // ── Programado para mañana ─────────────────────────────────────
            [
                'title'            => 'Tuición y régimen de visitas: lo que dice la ley chilena',
                'slug'             => 'tuicion-regimen-visitas-ley-chilena',
                'meta_title'       => 'Tuición y visitas en Chile: guía legal para padres separados',
                'meta_description' => 'Todo lo que necesitas saber sobre tuición personal, cuidado personal compartido y régimen comunicacional en Chile, según la Ley N.° 20.680.',
                'excerpt'          => 'Cuando los padres se separan, la regulación de la tuición y el régimen de visitas es una de las materias más sensibles. La ley chilena privilegia siempre el interés superior del niño.',
                'content'          => '<p>En Chile, la Ley N.° 20.680 de 2013 introdujo importantes modificaciones al Código Civil en materia de cuidado personal de los hijos. El principio rector es el interés superior del niño, niña o adolescente, y la ley privilegia el acuerdo entre los padres por sobre cualquier resolución judicial. Cuando existe acuerdo, este puede formalizarse ante notario, en el Registro Civil o ante el Juzgado de Familia.</p>

<p>El cuidado personal puede ser unilateral —ejercido por uno de los padres— o compartido. El cuidado compartido no significa necesariamente que el hijo pase el mismo tiempo con cada padre; implica que ambos participan activamente en la vida cotidiana del niño, tomando decisiones conjuntas en materia educacional, de salud y de desarrollo personal. Para que el tribunal lo autorice, debe quedar acreditado que los padres tienen una comunicación suficiente y que los domicilios permiten la continuidad escolar y social del hijo.</p>

<p>El régimen comunicacional —conocido coloquialmente como "visitas"— es el derecho y deber del padre o madre que no tiene el cuidado personal de mantener un vínculo directo y regular con su hijo. La ley establece que no puede ser restringido sino por causa grave que afecte el bienestar del niño. Los tribunales pueden fijar un régimen provisional mientras se tramita el juicio, y el incumplimiento del régimen decretado puede dar lugar a apremios e incluso al cambio de tuición.</p>

<p>Es importante saber que los abuelos y otros parientes también tienen derecho a solicitar un régimen de relación directa y regular cuando sea de interés para el niño. En cualquier caso, la mediación familiar previa es obligatoria antes de acudir al tribunal, salvo excepciones legales, lo que hace recomendable contar con representación jurídica desde esa etapa inicial.</p>',
                'category'         => 'derecho-familia',
                'image'            => null,
                'published_at'     => Carbon::now()->addDay()->setTime(9, 0),
            ],
        ];

        foreach ($posts as $data) {
            Post::create($data);
        }
    }
}
