<?php

namespace Tests\Helper;

use Charging\Domain\Entity\Company;
use Illuminate\Support\Facades\DB;

class CompanyProvider
{
    public static function createCompany(
        ?int $parentId = null,
        ?string $name = null
    ): int {
        return DB::table('companies')->insertGetId([
            'name' => $name ?? fake()->name,
            'parent_company_id' => $parentId
        ]);
    }
}
