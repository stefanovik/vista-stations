<?php

namespace App\Http\Docs\Schemas;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
final class ErrorDTO
{
    #[Property]
    public string $message;

    public function __construct(\Exception $error)
    {
        $this->message = $error->getMessage();
    }
}
