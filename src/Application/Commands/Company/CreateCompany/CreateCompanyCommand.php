<?php

namespace Charging\Application\Commands\Company\CreateCompany;

use Charging\Domain\Entity\Company;
use Charging\Domain\Entity\CompanyCollection;
use Charging\Domain\Entity\StationCollection;
use Charging\Domain\Repository\CompanyRepositoryInterface;

final class CreateCompanyCommand
{
    public function __construct(private readonly CompanyRepositoryInterface $companyRepository)
    {
    }

    public function __invoke(CreateCompanyDTO $createCompanyDTO): void
    {
        $this->companyRepository->create(
            new Company(
                0,
                $createCompanyDTO->name,
                new StationCollection(),
                new CompanyCollection(),
                $createCompanyDTO->parentCompanyId
            )
        );
    }
}
