<?php

namespace Charging\Domain\Repository;

use Charging\Domain\Entity\Company;
use Charging\Domain\Entity\CompanyCollection;

interface CompanyRepositoryInterface
{
    public function create(Company $company): void;
    public function update(Company $company): void;
    public function getById(int $id): ?Company;
    public function delete(int $id): void;
}
