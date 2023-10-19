<?php

namespace Charging\Application\Commands\Station\DeleteStation;

use Charging\Domain\Exception\NotFoundException;
use Charging\Domain\Repository\StationRepositoryInterface;

class DeleteStationCommand
{
    public function __construct(private readonly StationRepositoryInterface $stationRepository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(DeleteStationDTO $deleteStationDTO): void
    {
        $this->stationRepository->getById($deleteStationDTO->id) ?? throw new NotFoundException('Not found');
        $this->stationRepository->delete($deleteStationDTO->id);
    }
}
