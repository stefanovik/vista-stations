<?php

namespace App\Http\Docs\Schemas;

use Illuminate\Support\Collection;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class ClosestStationsDTO
{
    #[Property(type: 'array', items: new Items(ref: '#/components/schemas/CloseStationDTO'))]
    public Collection $stations;
}
