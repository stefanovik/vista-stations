<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Helper\CompanyProvider;
use Tests\Helper\StationProvider;

uses(RefreshDatabase::class);

it('creates company correctly', function (string $name, ?int $parentCompany) {
    $this->postJson('api/company', [
        'name' => $name,
        'parentCompanyId' => $parentCompany
    ]);
    $company = DB::table('companies')->where('name', $name)->first();
    $this->assertNotNull($company);
})->with([
    [
        fake()->name,
        null
    ],
    [
        fake()->name,
        1
    ]
]);

it('creates company with error', function (?int $parentCompany) {
    $previousCount = DB::table('companies')->count();

    $this->postJson('company', [
        'parentCompanyId' => $parentCompany
    ]);
    $afterCount = DB::table('companies')->count();
    $this->assertEquals($previousCount, $afterCount);
})->with([
    [
        null
    ],
    [
        1
    ]
]);

it('gets a company correctly', function (?int $parentId) {
    $companyId = CompanyProvider::createCompany($parentId);
    $this->getJson('/api/company/' . $companyId)->assertJson(
        [
            'id' => $companyId
        ]
    );
})->with([
    [
        null
    ],
    [
        1
    ]
]);

it('returns 404 for non existing company', function () {
    $this->getJson('/api/company/1')->assertJson(
        [
            'message' => "Not found"
        ]
    );
});

it('updates a company correctly', function (string $name, ?int $parentId) {
    $companyId = CompanyProvider::createCompany($parentId);
    $this->putJson('/api/company/' . $companyId, [
        'id' => $companyId,
        'name' => $name,
        'parentCompanyId' => $parentId
    ]);
    $company = DB::table('companies')->select('name')->where('id', $companyId)->first();
    $this->assertEquals($name, $company->name);
})->with([
    [
        fake()->name,
        null
    ],
    [
        fake()->name,
        1
    ]
]);

it('returns 404 for non existing company when updating', function () {
    $this->putJson('/api/company/1', [
        'id' => 1,
        'name' => fake()->name,
    ])->assertJson([
        'message' => 'Not found'
    ]);
});

it('returns validation error on update', function () {
    $companyId = CompanyProvider::createCompany();
    $this->putJson('/api/company/' . $companyId)->assertJsonValidationErrorFor('name');
});

it('deletes a company correctly', function () {
    $companyId = CompanyProvider::createCompany();
    $this->delete('/api/company/' . $companyId);
    $company = DB::table('companies')->select('name')->where('id', $companyId)->first();
    $this->assertNull($company);
});

it('returns 404 for non existing company when deleting', function () {
    $this->delete('/api/company/1')->assertJson([
        'message' => 'Not found'
    ]);
});

it('gets station list correctly', function (float $latitude, float $longitude) {
    $companyId = CompanyProvider::createCompany();
    StationProvider::saveStation($companyId, 78.39, 90.02);
    StationProvider::saveStation($companyId, 78.39, 90.02);
    StationProvider::saveStation($companyId, 78.39, 90.12);

    $response = $this->getJson(
        '/api/company/' . $companyId . '/closestStations?radius=2500&latitude=' . $latitude . '&longitude=' . $longitude
    );
    $response->assertJsonCount(2, 'stations');
})->with([
    [
        78.39,
        90.02
    ],
]);

it('returns 404 for non existing company when getting stations', function (float $latitude, float $longitude) {
    $this
        ->getJson('/api/company/1/closestStations?radius=1&latitude=' . $latitude . '&longitude=' . $longitude)
        ->assertJson([
            'message' => "Not found"
        ]);
})->with([
    [
        90.0,
        90.0
    ],
    [
        67.0,
        67.0
    ]
]);
