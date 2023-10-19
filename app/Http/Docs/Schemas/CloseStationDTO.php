<?php

namespace App\Http\Docs\Schemas;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class CloseStationDTO
{
    #[Property]
    public int $id;
    #[Property]
    public string $name;
    #[Property]
    public string $address;
    #[Property]
    public float $lat;
    #[Property]
    public float $long;
    #[Property]
    public float $distance;

    public function __construct(array $item)
    {
        $this->id = $item['id'];
        $this->name = $item['name'];
        $this->address = $item['address'];
        $this->lat = $item['lat'];
        $this->long = $item['long'];
        $this->distance = $item['distance'];
    }
}
