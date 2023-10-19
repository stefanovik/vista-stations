<?php

namespace Charging\Application\Commands\Company\GetCompany;

use Charging\Domain\Entity\Company;
use Charging\Domain\Exception\NotFoundException;
use Charging\Domain\Repository\CompanyRepositoryInterface;

final class GetCompanyCommand
{
    public function __construct(private readonly CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(GetCompanyDTO $getCompanyDTO): Company
    {
        return $this->companyRepository->getById($getCompanyDTO->id) ?? throw new NotFoundException("Not found");
    }
}
