<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin *',
            'email' => 'super@ubc.cm',
            'email_verified_at' => now(),
            'employee_id'=>'su1000',
            'branch_id'=>'000',
            'department'=>'superadmin',
            'oldbranch'=>'',
            'newbranch'=>'',
            'is_changed'=>0,
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
