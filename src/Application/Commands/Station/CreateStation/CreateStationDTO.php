<?php

namespace Charging\Application\Commands\Station\CreateStation;

class CreateStationDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $address,
        public readonly int $companyId
    ) {
    }
}
