<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ersin Önüt',
            'email' => 'ersincnc@hotmail.com',
            'password' => Hash::make('5PPgvR8O'),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
    }
}
