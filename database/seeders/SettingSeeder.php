<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::firstOrCreate(
          ['key'=>'logo'],
          ['value'=>'']  // deja vacío o pon ruta por defecto
        );
    }
}
