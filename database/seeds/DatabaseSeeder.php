<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(LangSeader::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CapSeeder::class);
        $this->call(OptionSeeder::class);
    }

}
