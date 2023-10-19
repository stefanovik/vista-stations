<?php

namespace Charging\Application\Commands\Company\UpdateCompany;

use Charging\Application\Commands\Company\GetCompany\GetCompanyDTO;
use Charging\Domain\Entity\Company;
use Charging\Domain\Exception\NotFoundException;
use Charging\Domain\Repository\CompanyRepositoryInterface;

final class UpdateCompanyCommand
{
    public function __construct(private readonly CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateCompanyDTO $updateCompanyDTO): void
    {
        $this->companyRepository->getById($updateCompanyDTO->id) ?? throw new NotFoundException("Not found");

        $this->companyRepository->update(
            new Company(
                $updateCompanyDTO->id,
                $updateCompanyDTO->name,
                parentId: $updateCompanyDTO->parentId
            )
        );
    }
}
