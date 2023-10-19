<?php

namespace Charging\Application\Commands\Company\ClosestStations;

use Charging\Domain\Entity\Station;
use Charging\Domain\Exception\NotFoundException;
use Charging\Domain\Repository\CompanyRepositoryInterface;
use Illuminate\Support\Collection;
use Location\Distance\DistanceInterface;
use Location\Distance\Haversine;

final class ClosestStationsCommand
{
    private DistanceInterface $distanceCalculator;

    public function __construct(private readonly CompanyRepositoryInterface $companyRepository)
    {
        $this->distanceCalculator = new Haversine();
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(ClosestStationsDTO $closestStationsDTO): Collection
    {
        $company = $this->companyRepository->getById($closestStationsDTO->id) ?? throw new NotFoundException("Not found");

        return new Collection(
            $company
                ->getAllStations()->sort()
                ->map(fn (Station $station) => [
                    'id' => $station->id,
                    'name' => $station->name,
                    'address' => $station->address,
                    'lat' => $station->coordinate->getLat(),
                    'long' => $station->coordinate->getLng(),
                    'distance' => $closestStationsDTO->startPoint->getDistance(
                        $station->coordinate,
                        $this->distanceCalculator
                    )
                ])
                ->sortBy('distance')
                ->reject(fn (array $station) => $station['distance'] > $closestStationsDTO->radius)
                ->groupBy(fn (array $station) => $station['lat'] . '-' . $station['long'])
        );
    }
}
