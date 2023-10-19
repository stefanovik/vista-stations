<?php

namespace Charging\Application\Commands\Station\GetStation;

use Charging\Domain\Entity\Station;
use Charging\Domain\Exception\NotFoundException;
use Charging\Domain\Repository\StationRepositoryInterface;

class GetStationCommand
{
    public function __construct(private readonly StationRepositoryInterface $stationRepository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(GetStationDTO $getStationDTO): Station
    {
        return $this->stationRepository->getById($getStationDTO->id) ?? throw new NotFoundException('Not found');
    }
}
