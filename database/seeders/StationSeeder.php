<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = DB::table('companies')->get()->pluck('id');
        $companies->each(
            fn (int $companyId) => collect(range(0, 5))->each(fn () => DB::table('stations')->insert([
                'name' => fake()->name(),
                'latitude' => fake()->latitude(50, 60),
                'longitude' => fake()->longitude(50, 60),
                'company_id' => $companyId,
                'address' => fake()->address()
            ]))
        );
    }
}
