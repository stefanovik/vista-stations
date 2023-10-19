<?php

namespace Charging\Application\Commands\Company\UpdateCompany;

class UpdateCompanyDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?int $parentId
    ) {
    }
}
