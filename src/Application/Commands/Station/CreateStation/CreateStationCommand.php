<?php

namespace Charging\Application\Commands\Station\CreateStation;

use Charging\Domain\Entity\Station;
use Charging\Domain\Repository\StationRepositoryInterface;
use Location\Coordinate;

class CreateStationCommand
{
    public function __construct(private readonly StationRepositoryInterface $stationRepository)
    {
    }

    public function __invoke(CreateStationDTO $createStationDTO): void
    {
        $this->stationRepository->create(new Station(
            -1,
            $createStationDTO->name,
            new Coordinate(
                $createStationDTO->latitude,
                $createStationDTO->longitude
            ),
            $createStationDTO->address,
            $createStationDTO->companyId
        ));
    }
}
