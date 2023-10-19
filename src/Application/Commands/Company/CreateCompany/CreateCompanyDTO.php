<?php

namespace Charging\Application\Commands\Company\CreateCompany;

class CreateCompanyDTO
{
    public function __construct(
        public string $name,
        public ?int $parentCompanyId
    ) {
    }
}
