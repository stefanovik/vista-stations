<?php

namespace Charging\Domain\Exception;

class NotFoundException extends \Exception
{
    public $code = 404;
}
