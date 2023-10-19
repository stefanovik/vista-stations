<?php

namespace Charging\Infrastructure\Repository;

use Charging\Domain\Entity\Company;
use Charging\Domain\Entity\CompanyCollection;
use Charging\Domain\Repository\CompanyRepositoryInterface;
use Charging\Domain\Repository\StationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private readonly StationRepositoryInterface $stationRepository)
    {
    }

    public function create(Company $company): void
    {
        DB::table('companies')->insert([
            'name' => $company->name,
            'parent_company_id' => $company->parentId
        ]);
    }

    public function update(Company $company): void
    {
        DB::table('companies')->update([
            'id' => $company->id,
            'name' => $company->name,
            'parent_company_id' => $company->parentId
        ]);
    }

    public function getById(int $id): ?Company
    {
        return $this->mapToCompany(DB::table('companies')
            ->select(["id", "name", "parent_company_id"])
            ->where('id', $id)
            ->first());
    }

    public function delete(int $id): void
    {
        DB::table('companies')->delete($id);
    }

    private function mapToCompany(mixed $record): ?Company
    {
        if (!$record) {
            return null;
        }

        return new Company(
            $record->id,
            $record->name,
            $this->stationRepository->getByCompany($record->id),
            $this->getChildren($record->id),
            $record->parent_company_id
        );
    }

    private function getChildren(int $companyId): CompanyCollection
    {
        return new CompanyCollection(
            DB::table('companies')
                ->where('parent_company_id', $companyId)
                ->get()
                ->map(fn (mixed $record) => $this->mapToCompany($record))
        );
    }
}
