<?php

use Illuminate\Database\Seeder;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('request_types')->insert([
            ['name' => 'Change Of Pin',
            'request_code' => 'pin_change',
            'created_at' => now(),
            'updated_at' => now()],
            [
                'name' => 'Card Subscription',
                'request_code' => 'new_card',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Card Renewal',
                'request_code' => 'renew_card',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Block Card',
                'request_code' => 'block_card',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Renew Card',
                'request_code' => 'renew_card',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'New Check Request',
                'request_code' => 'cheque',
                'created_at' => now(),
                'updated_at' => now()],

        ]);

    }
}
