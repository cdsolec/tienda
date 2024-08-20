<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = Content::factory()->create([
            'name' => 'Acerca de Nosotros',
            'description' => '<p class="py-2">Somos un grupo de empresas 100% capital venezolano, conformadas por profesionales con clara visión tecnológica y gerencial, con más de 40 años de experiencia en soluciones de automatización, instrumentación, control de proceso y distribución eficiente y segura de la Energía, para sectores de mercado como Industria química, alimentos y bebidas, Oil&Gas, metal mecánico, minería, residencial y construcción. En todas nuestras soluciones integrales incorporamos productos con las últimas tecnologías en digitalización e interconectividad a los fines de asegurar el manejo inteligente y eficiente de los recursos.</p>
            <p class="py-2">En <strong>CD-SOLEC</strong> distribuimos equipos y componentes de las mejores marcas disponibles, tales como Siemens, Schneider Electric, Rockwell Automation, Mitsubishi Electric y ABB, a los fines de facilitarles a nuestros clientes el desarrollo de soluciones de ingeniería a los mejores precios con máxima calidad y sin intermediarios.</p>'
        ]);

        $content = Content::factory()->create([
            'name' => 'Nosotros',
            'description' => '<p class="py-2">Somos un grupo de empresas 100% capital venezolano, conformadas por profesionales con clara visión tecnológica y gerencial, con más de 40 años de experiencia en soluciones de automatización, instrumentación, control de proceso y distribución eficiente y segura de la Energía, para sectores de mercado como Industria química, alimentos y bebidas, Oil&Gas, metal mecánico, minería, residencial y construcción. En todas nuestras soluciones integrales incorporamos productos con las últimas tecnologías en digitalización e interconectividad a los fines de asegurar el manejo inteligente y eficiente de los recursos.</p>
			<p class="py-2">En <strong>CD-SOLEC</strong> distribuimos equipos y componentes de las mejores marcas disponibles, tales como Siemens, Schneider Electric, Rockwell Automation, Mitsubishi Electric y ABB, a los fines de facilitarles a nuestros clientes el desarrollo de soluciones de ingeniería a los mejores precios con máxima calidad y sin intermediarios.</p>
            <p class="py-2">Nuestra seriedad, responsabilidad y compromiso con los clientes, garantiza la continua operatividad, interconectividad y calidad de todas las soluciones diseñadas e implementadas además de estar construidas y/o instaladas según las Normativas Vigentes (ANSI, IEC, NEMA, NEC, NFPA, UL, ISA).</p>
			<h6 class="leading-tight font-bold mt-4">VISION</h6>
			<p class="py-2">CONVERTIRNOS EN LA MEJOR OPCIÓN DE NUESTROS CLIENTES AL OFRECERLES EN NUESTRA PAGINA WEB UN AMPLIO PORTAFOLIO DE PRODUCTOS DEL SECTOR ENERGIA Y TELECOMUNICACIONES CON SOLUCIONES INNOVADORAS Y DONDE PODRAN DESCUBRIR LAS ULTIMAS TENDENCIAS EN UN MUNDO CADA DIA MAS DIGITAL.</p>
			<h6 class="leading-tight font-bold mt-4">MISION</h6>
			<p class="py-2">PONER EN LA MANO DE NUESTROS CLIENTES PRODUCTOS Y SOLUCIONES INNOVADORAS PARA LLEVAR A TERMINO LOS PROYECTOS Y SERVICIOS EN EL MENOR TIEMPO POSIBLE, GARANTIZANDO SOSTENIBILIDAD, EFICIENCIA, SEGURIDAD, DIGITALIZACION Y RENTABILIDAD.</p>'
        ]);

        $content = Content::factory()->create([
            'name' => 'Contáctanos',
            'description' => '<div class="w-full flex items-center mb-5">
                <i class="mr-3 fas fa-5x fa-fw fa-envelope-open-text"></i>
                <div>
                    <p><a href="mailto:ventas@cd-solec.com">ventas@cd-solec.com</a></p>
                </div>
            </div>
            <div class="w-full flex items-center mb-5">
                <i class="mr-3 fab fa-5x fa-fw fa-whatsapp"></i>
                <div>
                    <p><a href="https://wa.me/+584128915299">(0412)-891.52.99</a></p>
                    <p><a href="https://wa.me/+584243158430">(0424)-315.84.30</a></p>
                </div>
            </div>
            <div class="w-full flex items-center mb-5">
                <i class="mr-3 fas fa-5x fa-fw fa-mobile-alt"></i>
                <div>
                    <p><a href="tel:+582446888375">(0244)-688.83.75</a></p>
                    <p><a href="tel:+582446888377">(0244)-688.83.77</a></p>
                    <p><a href="tel:+582446888379">(0244)-688.83.79</a></p>
                </div>
            </div>
            <div class="w-full flex items-center mb-5">
                <i class="mr-3 fas fa-5x fa-fw fa-map-marked-alt"></i>
                <div>
                    <p>Edo. Aragua, Venezuela</p>
                </div>
            </div>'
        ]);
    }
}
