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
                'name' => 'New Card Request',
                'request_code' => 'new_card',
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
                'name' => 'Check 25',
                'request_code' => 'check_25',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Check 50',
                'request_code' => 'check_50',
                'created_at' => now(),
                'updated_at' => now()]
        ]);

    }
}
