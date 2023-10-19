<?php

namespace Charging\Domain\Entity;

use Illuminate\Support\Collection;

class Company
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly StationCollection $stations = new StationCollection(),
        public readonly CompanyCollection $companiesOwned = new CompanyCollection(),
        public readonly ?int $parentId = null
    ) {
    }

    public function getAllStations(): Collection
    {
        $allStations = $this->stations;
        $this->companiesOwned->each(
            function (Company $company) use (&$allStations) {
                $allStations = $allStations->merge($company->getAllStations());
            }
        );

        return $allStations;
    }
}
