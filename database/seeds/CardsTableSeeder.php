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
            ['name' => 'Trust Silver',
            'card_type' => 'silver',
            'created_at' => now(),
            'updated_at' => now()],
            [
                'name' => 'Trust Gold',
                'card_type' => 'gold',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Trust Saphir',
                'card_type' => 'saphire',
                'created_at' => now(),
                'updated_at' => now()],
                [
                    'name' => 'Cheque 25',
                    'card_type' => 'cheque_25',
                    'created_at' => now(),
                    'updated_at' => now()],
                [
                    'name' => 'Cheque 50',
                    'card_type' => 'cheque_50',
                    'created_at' => now(),
                    'updated_at' => now()],
                    [
                        'name' => 'Certified Cheque',
                        'card_type' => 'certified',
                        'created_at' => now(),
                        'updated_at' => now()]
        ]);

    }
}
