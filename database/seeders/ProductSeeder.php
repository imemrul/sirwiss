<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 1000; $i++) { 
            $type = ($i % 2 == 0)?'item':'service';
            DB::table('products')->insert([
                'name' => Str::random(10),
                'detail' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                'type' => $type,
                'user_id' => rand(1,10),
                'original_price' => rand(500,1000),
            ]);
        }
    }
}
