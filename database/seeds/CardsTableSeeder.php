<?php

use Illuminate\Database\Seeder;

class CardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cards')->insert([
            ['name' => 'Silver',
            'card_type' => 'silver',
            'created_at' => now(),
            'updated_at' => now()],
            [
                'name' => 'Gold',
                'card_type' => 'gold',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Sapphire',
                'card_type' => 'saphire',
                'created_at' => now(),
                'updated_at' => now()],
        ]);

    }
}
