<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class ExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 300; $i++) {
            DB::table('expenditure')->insert([
                'description' => $faker->text(100),
                'category_id' =>  $faker->numberBetween(1, 5),
                'price' => $faker->randomFloat(2, 10, 10000),
                'invoice' => "invoices/expenditure/test.pdf",
                'invoice_date' => $faker->dateTimeBetween('-3 years', '+1 year'),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        }
    }
}
