<?php

namespace App\Http\Docs\Schemas;

use Charging\Domain\Entity\Company;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class CompanyDTO
{
    #[Property]
    public int $id;
    #[Property]
    public string $name;
    #[Property]
    public ?string $parentCompanyId;

    public function __construct(Company $company)
    {
        $this->id = $company->id;
        $this->name = $company->name;
        $this->parentCompanyId = $company->parentId;
    }
}
