<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 150; $i++) {
            DB::table('income')->insert([
                'description' => $faker->text(100),
                'category_id' =>  $faker->numberBetween(1, 5),
                'price' => $faker->randomFloat(2, 10, 10000),
                'invoice' => "invoices/income/test.pdf",
                'invoice_date' => $faker->dateTimeBetween('-3 years', '+2 week'),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        }
    }
}
