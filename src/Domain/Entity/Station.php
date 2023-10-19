<?php

namespace Charging\Domain\Entity;

use Location\Coordinate;

class Station
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly Coordinate $coordinate,
        public readonly string $address,
        public readonly int $companyId
    ) {
    }


}
