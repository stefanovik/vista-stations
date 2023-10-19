<?php

namespace App\Http\Controllers;

use App\Http\Docs\DTOSchema;
use App\Http\Docs\Schemas\CompanyDTO;
use App\Http\Docs\Schemas\ErrorDTO;
use Charging\Application\Commands\Company\ClosestStations\ClosestStationsCommand;
use Charging\Application\Commands\Company\ClosestStations\ClosestStationsDTO;
use Charging\Application\Commands\Company\CreateCompany\CreateCompanyCommand;
use Charging\Application\Commands\Company\CreateCompany\CreateCompanyDTO;
use Charging\Application\Commands\Company\DeleteCompany\DeleteCompanyCommand;
use Charging\Application\Commands\Company\DeleteCompany\DeleteCompanyDTO;
use Charging\Application\Commands\Company\GetCompany\GetCompanyCommand;
use Charging\Application\Commands\Company\GetCompany\GetCompanyDTO;
use Charging\Application\Commands\Company\UpdateCompany\UpdateCompanyCommand;
use Charging\Application\Commands\Company\UpdateCompany\UpdateCompanyDTO;
use Charging\Domain\Exception\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Location\Coordinate;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="Assignment", version="0.1")
 */
class CompanyController extends Controller
{
    #[OA\Post(
        '/company',
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            required: ['parentCompanyId', 'name'],
            properties: [
                new OA\Property('parentCompanyId', type: 'integer', minimum: 1),
                new OA\Property('name', type: 'string'),
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Invalid request',
        content: new OA\JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    public function create(Request $request, CreateCompanyCommand $command): JsonResponse
    {
        $request->validate([
            'name' => 'required | string | min:1 | max:30',
        ]);
        try {
            $command(new CreateCompanyDTO($request->get('name'), $request->get('parentCompanyId')));
        } catch (\Exception $e) {
            return \response()->json(new ErrorDTO($e));
        }

        return new JsonResponse();
    }

    #[OA\Get(
        '/company/{id}',
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
        content: new OA\JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Company get',
        content: new OA\JsonContent(ref: DTOSchema::COMPANY_DTO_SCHEMA)
    )]
    public function get(
        #[OA\PathParameter(schema: new OA\Schema(type: 'integer'))] int $id,
        GetCompanyCommand $command
    ): JsonResponse {
        try {
            $company = $command(new GetCompanyDTO($id));
        } catch (NotFoundException $exception) {
            return \response()->json(new ErrorDTO($exception));
        }

        return \response()->json(new CompanyDTO($company));
    }

    #[OA\Put(
        '/company/{id}',
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            required: ['id', 'parentCompanyId', 'name'],
            properties: [
                new OA\Property('id', type: 'integer', minimum: 1),
                new OA\Property('parentCompanyId', type: 'integer', minimum: 1),
                new OA\Property('name', type: 'string'),
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Invalid request',
        content: new OA\JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    public function update(
        #[OA\PathParameter(schema: new OA\Schema(type: 'integer'))] int $id,
        Request $request,
        UpdateCompanyCommand $command
    ): JsonResponse {
        $request->validate([
            'name' => 'required | string | min:1 | max:30',
        ]);

        try {
            $command(
                new UpdateCompanyDTO(
                    $id,
                    $request->input('name'),
                    $request->input('parentCompanyId')
                )
            );
        } catch (NotFoundException $exception) {
            return \response()->json(new ErrorDTO($exception));
        }

        return new JsonResponse();
    }

    #[OA\Delete(
        '/company/{id}',
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
        content: new OA\JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    public function delete(
        #[OA\PathParameter(schema: new OA\Schema(type: 'integer'))] int $id,
        DeleteCompanyCommand $command
    ): JsonResponse {
        try {
            $command(new DeleteCompanyDTO($id));
        } catch (NotFoundException $exception) {
            return \response()->json(new ErrorDTO($exception));
        }

        return new JsonResponse();
    }

    #[OA\Get(
        '/company/{id}/closestStations',
        parameters: [
            new OA\Parameter(
                name: 'radius',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'float')
            ),
            new OA\Parameter(
                name: 'latitude',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'float')
            ),
            new OA\Parameter(
                name: 'longitude',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'float')
            )
        ]
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
        content: new OA\JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Company get closest stations',
        content: new OA\JsonContent(ref: DTOSchema::CLOSEST_STATIONS_SCHEMA)
    )]
    public function getClosestStations(
        #[OA\PathParameter(schema: new OA\Schema(type: 'integer'))] int $id,
        Request $request,
        ClosestStationsCommand $command
    ): JsonResponse {
        try {
            $stations = $command(
                new ClosestStationsDTO(
                    $id,
                    $request->input('radius'),
                    new Coordinate(
                        $request->input('latitude'),
                        $request->input('longitude')
                    )
                )
            );
        } catch (NotFoundException $exception) {
            return \response()->json(new ErrorDTO($exception));
        }

        return response()->json(['stations' => $stations->toArray()]);
    }
}
