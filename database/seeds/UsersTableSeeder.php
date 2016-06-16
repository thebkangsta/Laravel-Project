<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('users')->delete();
        User::create([
			'name' => 'Brandon Kang',
			'email' => 'thebkangsta@gmail.com',
			'password' => '123qwe'
		]);
    }
}
