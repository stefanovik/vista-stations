<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    private const NUMBER_OF_COMPANIES = 10;
    private const PARENTS = [null, 1, 3, 6];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = collect(range(1, self::NUMBER_OF_COMPANIES))
            ->map(fn (int $i) => [
                'parent_company_id' => in_array($i, self::PARENTS) ?
                    null : self::PARENTS[array_rand(self::PARENTS)],
                'name' => fake()->name()
            ])->values()->toArray();

        DB::table('companies')->insert($companies);
    }
}
