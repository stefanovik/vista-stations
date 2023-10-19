<?php

namespace Charging\Application\Commands\Company\DeleteCompany;

use Charging\Domain\Exception\NotFoundException;
use Charging\Domain\Repository\CompanyRepositoryInterface;

final class DeleteCompanyCommand
{
    public function __construct(private readonly CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(DeleteCompanyDTO $deleteCompanyDTO): void
    {
        $this->companyRepository->getById($deleteCompanyDTO->id) ?? throw new NotFoundException("Not found");
        $this->companyRepository->delete($deleteCompanyDTO->id);
    }
}
