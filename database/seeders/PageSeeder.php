<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // Sección HOME — usa updateOrCreate para overwrite
        Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title'   => '¿Dónde estamos?',
                'content' => <<<HTML
<h2 class="h-3 mb-3">¿Dónde estamos?</h2>
<p>
  Nuestra sede en Mérida nos permite coordinar la entrega de productos frescos de la
  Península de <strong>Yucatán</strong> a todo México. Esta región, con su clima cálido, suelos
  fértiles y tradición agrícola que une técnicas ancestrales y tecnología moderna, es la base de
  nuestra producción sostenible y de alta calidad.
</p>
<ul class="list-unstyled mt-1">
  <li class="mb-2">
    <i class="bi bi-geo-alt-fill text-success me-5"></i>
    Oficinas centrales en Mérida
  </li>
  <li class="mb-2">
    <i class="bi bi-clock-fill text-success me-2"></i>
    Atención al público: 9 AM–5 PM
  </li>
  <li>
    <i class="bi bi-people-fill text-success me-2"></i>
    Contacto directo con productores
  </li>
  <li class="d-flex align-items-start mb-2">
    <i class="bi bi-truck me-2 text-success"></i>
    Envíos diarios a distribuidores regionales
  </li>
</ul>
HTML
            ]
        );

        // Sección QUIÉNES SOMOS (igual si quieres actualizarla siempre)
        Page::updateOrCreate(
            ['slug' => 'quienes-somos'],
            [
                'title'   => 'Quiénes Somos',
                'content' => <<<HTML
<h2 class="h-3 mb-3">Quiénes Somos</h2>
<p>
  Somos una agrupación comprometida con la calidad y la sostenibilidad. Nuestra
  misión es conectar productores locales de la Península de Yucatán con mercados
  nacionales e internacionales, resaltando las técnicas ancestrales y el respeto
  por el medio ambiente.
</p>
<ul class="list-unstyled mt-1">
  <li class="mb-2">
    <i class="bi bi-award-fill text-success me-2"></i>
    Más de 20 años de experiencia
  </li>
  <li class="mb-2">
    <i class="bi bi-people-fill text-success me-2"></i>
    Red de productores certificados
  </li>
  <li>
    <i class="bi bi-globe2 text-success me-2"></i>
    Exportamos a todo el mundo
  </li>
</ul>
HTML
            ]
        );
    }
}
