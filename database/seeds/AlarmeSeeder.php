<?php

use Illuminate\Database\Seeder;

class AlarmeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Alarme::class, 10)->create();
    }
}
