<?php

namespace Charging\Domain\Repository;

use Charging\Domain\Entity\Station;
use Charging\Domain\Entity\StationCollection;

interface StationRepositoryInterface
{
    public function create(Station $station): void;
    public function update(Station $station): void;
    public function getById(int $id): ?Station;
    public function getByCompany(int $companyId): StationCollection;
    public function delete(int $id): void;
}
