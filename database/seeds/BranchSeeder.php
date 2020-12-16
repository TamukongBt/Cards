<?php

use Illuminate\Database\Seeder;
use App\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            ['name' => 'Bamenda',
            'branch_code' => '001',
            'created_at' => now(),
            'updated_at' => now()],
            [
                'name' => 'Akwa',
                'branch_code' => '002',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Limbe',
                'branch_code' => '003',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Yaounde',
                'branch_code' => '004',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Kumba',
                'branch_code' => '005',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Bafoussam',
                'branch_code' => '007',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Bonamoussadi',
                'branch_code' => '011',
                'created_at' => now(),
                'updated_at' => now()],
            [
                'name' => 'Mboppi',
                'branch_code' => '012',
                'created_at' => now(),
                'updated_at' => now()],
                [
                    'name' => 'HeadOffice',
                    'branch_code' => '000',
                    'created_at' => now(),
                    'updated_at' => now()]
        ]);

    }
}
