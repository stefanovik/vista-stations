<?php

namespace Charging\Application\Commands\Company\ClosestStations;

use Location\Coordinate;

class ClosestStationsDTO
{
    public function __construct(
        public readonly int $id,
        public readonly int $radius,
        public readonly Coordinate $startPoint
    ) {
    }
}
