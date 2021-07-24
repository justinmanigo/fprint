<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrintPriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('print_prices')->insert([
            [
                'size' => 'A4',
                'isColored' => 'Yes',
                'price'=> 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'A4',
                'isColored' => 'No',
                'price'=> 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'Short',
                'isColored' => 'Yes',
                'price'=> 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'Short',
                'isColored' => 'No',
                'price'=> 3,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
            [
                'size' => 'Long',
                'isColored' => 'Yes',
                'price'=> 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'Long',
                'isColored' => 'No',
                'price'=> 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
