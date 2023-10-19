<?php

namespace Charging\Application\Commands\Company\DeleteCompany;

class DeleteCompanyDTO
{
    public function __construct(public readonly int $id)
    {
    }
}
