<?php

namespace Charging\Infrastructure\Providers;

use Charging\Domain\Repository\CompanyRepositoryInterface;
use Charging\Domain\Repository\StationRepositoryInterface;
use Charging\Infrastructure\Repository\CompanyRepository;
use Charging\Infrastructure\Repository\StationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StationRepositoryInterface::class, StationRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
    }
}
