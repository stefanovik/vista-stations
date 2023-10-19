<?php

namespace App\Http\Docs\Schemas;

use Charging\Domain\Entity\Company;
use Charging\Domain\Entity\Station;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class StationDTO
{
    #[Property]
    public int $id;
    #[Property]
    public string $name;
    #[Property]
    public float $latitude;
    #[Property]
    public float $longitude;
    #[Property]
    public string $address;

    public function __construct(Station $station)
    {
        $this->id = $station->id;
        $this->name = $station->name;
        $this->latitude = $station->coordinate->getLat();
        $this->longitude = $station->coordinate->getLng();
        $this->address = $station->address;
    }
}
