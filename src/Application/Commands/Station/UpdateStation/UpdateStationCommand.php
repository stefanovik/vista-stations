<?php

namespace Charging\Application\Commands\Station\UpdateStation;

use Charging\Application\Commands\Station\CreateStation\CreateStationDTO;
use Charging\Domain\Entity\Station;
use Charging\Domain\Exception\NotFoundException;
use Charging\Domain\Repository\StationRepositoryInterface;
use Location\Coordinate;

class UpdateStationCommand
{
    public function __construct(private readonly StationRepositoryInterface $stationRepository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateStationDTO $updateStationDTO): void
    {
        $this->stationRepository->getById($updateStationDTO->id) ?? throw new NotFoundException("Not found");
        $this->stationRepository->update(new Station(
            $updateStationDTO->id,
            $updateStationDTO->name,
            new Coordinate(
                $updateStationDTO->latitude,
                $updateStationDTO->longitude
            ),
            $updateStationDTO->address,
            $updateStationDTO->companyId
        ));
    }
}
