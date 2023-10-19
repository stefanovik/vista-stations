<?php

namespace Charging\Application\Commands\Station\GetStation;

class GetStationDTO
{
    public function __construct(public readonly int $id)
    {
    }
}
