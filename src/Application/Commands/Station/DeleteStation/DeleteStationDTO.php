<?php

namespace Charging\Application\Commands\Station\DeleteStation;

class DeleteStationDTO
{
    public function __construct(public readonly int $id)
    {
    }
}
