<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Helper\CompanyProvider;
use Tests\Helper\StationProvider;

uses(RefreshDatabase::class);

it(
    'creates station correctly',
    function (string $name, float $latitude, float $longitude, string $address) {
        $companyId = CompanyProvider::createCompany();

        $this->postJson('api/station', [
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'companyId' => $companyId,
            'address' => $address
        ]);

        $station = DB::table('stations')->where('name', $name)->first();
        $this->assertNotNull($station);
})->with([
    [
        fake()->name,
        fake()->latitude,
        fake()->longitude,
        fake()->address
    ],
]);

it('creates station with error', function () {
    $previousCount = DB::table('companies')->count();

    $this->postJson('api/station')
        ->assertJsonValidationErrorFor('name')
        ->assertJsonValidationErrorFor('latitude')
        ->assertJsonValidationErrorFor('longitude')
        ->assertJsonValidationErrorFor('companyId')
        ->assertJsonValidationErrorFor('address');

    $afterCount = DB::table('companies')->count();
    $this->assertEquals($previousCount, $afterCount);
});

it('gets a station correctly', function () {
    $companyId = CompanyProvider::createCompany();
    $stationId = StationProvider::saveStation($companyId);
    $this->getJson('/api/station/' . $stationId)->assertJson(
        [
            'id' => $stationId
        ]
    );
});

it('returns 404 for non existing company', function () {
    $this->getJson('/api/station/1')->assertJson(
        [
            'message' => "Not found"
        ]
    );
});

it('updates a station correctly', function (string $name, float $latitude, float $longitude, string $address) {
    $companyId = CompanyProvider::createCompany();
    $stationId = StationProvider::saveStation($companyId);
    $this->putJson('/api/station/' . $stationId, [
        'id' => $stationId,
        'name' => $name,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'companyId' => $companyId,
        'address' => $address
    ]);

    $station = DB::table('stations')->select('name')->where('id', $stationId)->first();
    $this->assertEquals($name, $station->name);
})->with([
    [
        fake()->name,
        fake()->latitude,
        fake()->longitude,
        fake()->address
    ]
]);

it('returns 404 for non existing station when updating', function () {
    $this->putJson('/api/station/1', [
        'id' => 1,
        'name' => fake()->name,
        'latitude' => fake()->latitude,
        'longitude' => fake()->longitude,
        'companyId' => 1,
        'address' => fake()->address
    ])->assertJson([
        'message' => 'Not found'
    ]);
});

it('returns validation error on update', function () {
    $companyId = CompanyProvider::createCompany();
    $stationId = StationProvider::saveStation($companyId);
    $this->putJson('/api/station/' . $stationId)
        ->assertJsonValidationErrorFor('id')
        ->assertJsonValidationErrorFor('name')
        ->assertJsonValidationErrorFor('latitude')
        ->assertJsonValidationErrorFor('longitude')
        ->assertJsonValidationErrorFor('companyId')
        ->assertJsonValidationErrorFor('address');
});

it('deletes a station correctly', function () {
    $companyId = CompanyProvider::createCompany();
    $stationId = StationProvider::saveStation($companyId);

    $this->delete('/api/station/' . $stationId);
    $station = DB::table('stations')->select('name')->where('id', $stationId)->first();
    $this->assertNull($station);
});

it('returns 404 for non existing company when deleting', function () {
    $this->delete('/api/station/1')->assertJson([
        'message' => 'Not found'
    ]);
});
