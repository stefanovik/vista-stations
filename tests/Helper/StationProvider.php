<?php

namespace Tests\Helper;

use Charging\Domain\Entity\Station;
use Illuminate\Support\Facades\DB;
use Location\Coordinate;

class StationProvider
{
    private static int $id = 1;

    public static function provideStation(int $companyId): Station {
        return new Station(
            self::$id++,
            fake()->name,
            new Coordinate(
                fake()->latitude(60),
                fake()->longitude(60, 90)
            ),
            fake()->address,
            $companyId
        );
    }

    public static function saveStation(
        int $companyId,
        ?float $latitude = null,
        ?float $longitude = null
    ): int {
        return DB::table('stations')->insertGetId([
            'name' => fake()->name,
            'latitude' => $latitude ?? fake()->latitude(60),
            'longitude' => $longitude ?? fake()->longitude(60, 90),
            'address' => fake()->address,
            'company_id' => $companyId
        ]);
    }
}
