<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        $this->call([CardsTableSeeder::class]);
        $this->call([RequestTypeSeeder::class]);
        $this->call([BranchSeeder::class]);
        $this->call([PermissionsSeeder::class]);
    }
}
