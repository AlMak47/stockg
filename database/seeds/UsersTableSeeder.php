<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('users')->insert([
            'username' => 'admin',
            'email' => "admin@stockg.com",
            'password' => bcrypt("admin"),
            'statut'	=>	'admin'
        ]);
    }
}
