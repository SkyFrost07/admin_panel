<?php

use Illuminate\Database\Seeder;
use App\Models\Lang;

class LangSeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lang::create(['name' => 'Tiếng Việt', 'code' => 'vi', 'icon' => 'vi.png', 'folder' => 'vi', 'unit' => 'VNĐ', 'ratio_currency' => 1, 'order' => 1, 'default' => 1]);
        Lang::create(['name' => 'English', 'code' => 'en', 'icon' => 'en.png', 'folder' => 'en', 'unit' => '$', 'ratio_currency' => '23000', 'order' => 2, 'default' => 0]);
    }
}
