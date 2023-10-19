<?php

namespace Charging\Application\Commands\Station\UpdateStation;

class UpdateStationDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $address,
        public readonly int $companyId
    ) {
    }
}
