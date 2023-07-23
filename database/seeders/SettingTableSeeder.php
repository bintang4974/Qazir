<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'id' => 1,
            'company_name' => 'Qazir',
            'address' => 'IT Telkom',
            'telephone' => '081573890456',
            'note_type' => 1,
            'discount' => 5,
            'path_logo' => '/img/logo.png',
            'member_card_path' => '-'
        ]);
    }
}
