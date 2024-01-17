<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            ['role' => 'Admin'],
            ['role' => 'Manager'],
        ];
        DB::table('roles')->insert($roles);
    }
}
