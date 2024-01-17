<?php

use Illuminate\Database\Seeder;
use App\AdminUser;
use App\RoleAdmin;
use App\Role;
class RoleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin_user_id = AdminUser::create([
            'email' => 'admin@gmail.com',
            'password' => md5('admin'),
            'token' => md5('admin')
           ])->id;
        $role_admin = RoleAdmin::create([
            'role_id' => Role::first()->id,
            'admin_id' => $admin_user_id
        ]);
    }
}
