<?php

namespace Charging\Infrastructure\Repository;

use Charging\Domain\Entity\Station;
use Charging\Domain\Entity\StationCollection;
use Charging\Domain\Repository\StationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Location\Coordinate;

class StationRepository implements StationRepositoryInterface
{
    public function create(Station $station): void
    {
        DB::table('stations')->insert([
            'name' => $station->name,
            'latitude' => $station->coordinate->getLat(),
            'longitude' => $station->coordinate->getLng(),
            'address' => $station->address,
            'company_id' => $station->companyId
        ]);
    }

    public function update(Station $station): void
    {
        DB::table('stations')->update([
            'id' => $station->id,
            'name' => $station->name,
            'latitude' => $station->coordinate->getLat(),
            'longitude' => $station->coordinate->getLng(),
            'address' => $station->address
        ]);
    }

    public function getById(int $id): ?Station
    {
        return $this->mapToStation(DB::table('stations')->where('id', $id)->first());
    }

    public function getByCompany(int $companyId): StationCollection
    {
        return new StationCollection(
            DB::table('stations')
                ->select(['id', 'name', 'latitude', 'longitude', 'address', 'company_id'])
                ->where('company_id', $companyId)
                ->get()
                ->map(fn (mixed $record) => $this->mapToStation($record))
        );
    }

    public function delete(int $id): void
    {
        DB::table('stations')->delete($id);
    }

    private function mapToStation(mixed $record): ?Station
    {
        if (!$record) {
            return null;
        }

        return new Station(
            $record->id,
            $record->name,
            new Coordinate($record->latitude, $record->longitude),
            $record->address,
            $record->company_id
        );
    }
}
