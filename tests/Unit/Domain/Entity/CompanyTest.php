<?php

use Charging\Domain\Entity\Company;
use Charging\Domain\Entity\CompanyCollection;
use Charging\Domain\Entity\StationCollection;
use Tests\Helper\StationProvider;

it('tests that company returns expected number of stations', function(Company $company, int $expected) {
    $this->assertEquals($expected, $company->getAllStations()->count());
})->with([
    [
        new Company(
            1,
            'Companie Test',
            new StationCollection(),
            new CompanyCollection()
        ),
        0
    ],
    [
        new Company(
            1,
            'Test Company',
            new StationCollection([StationProvider::provideStation(1)]),
            new CompanyCollection()
        ),
        1
    ],
    [
        new Company(
            1,
            'Test Company',
            new StationCollection([StationProvider::provideStation(1)]),
            new CompanyCollection([
                new Company(
                    2,
                    'Test Company Child',
                    new StationCollection(),
                    new CompanyCollection()
                )
            ])
        ),
        1
    ],
    [
        new Company(
            1,
            'Test Company',
            new StationCollection([StationProvider::provideStation(1)]),
            new CompanyCollection([
                new Company(
                    2,
                    'Test Company Child',
                    new StationCollection([StationProvider::provideStation(2)]),
                    new CompanyCollection()
                )
            ])
        ),
        2
    ],
    [
        new Company(
            1,
            'Test Company',
            new StationCollection([StationProvider::provideStation(1)]),
            new CompanyCollection([
                new Company(
                    2,
                    'Test Company Child 1',
                    new StationCollection([StationProvider::provideStation(2)]),
                    new CompanyCollection()
                ),
                new Company(
                    3,
                    'Test Company Child 2',
                    new StationCollection([StationProvider::provideStation(3)]),
                    new CompanyCollection()
                )
            ])
        ),
        3
    ],
    [
        new Company(
            1,
            'Test Company',
            new StationCollection([StationProvider::provideStation(1)]),
            new CompanyCollection([
                new Company(
                    2,
                    'Test Company Child',
                    new StationCollection([StationProvider::provideStation(2)]),
                    new CompanyCollection([
                        new Company(
                            3,
                            'Test Company Child 2',
                            new StationCollection([StationProvider::provideStation(3)]),
                            new CompanyCollection()
                        )
                    ])
                )
            ])
        ),
        3
    ],
]);
