<?php

namespace Charging\Application\Commands\Company\GetCompany;

class GetCompanyDTO
{
    public function __construct(public readonly int $id)
    {
    }
}
