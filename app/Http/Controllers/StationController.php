<?php

namespace App\Http\Controllers;

use App\Http\Docs\DTOSchema;
use App\Http\Docs\Schemas\ErrorDTO;
use App\Http\Docs\Schemas\StationDTO;
use Charging\Application\Commands\Station\CreateStation\CreateStationCommand;
use Charging\Application\Commands\Station\CreateStation\CreateStationDTO;
use Charging\Application\Commands\Station\DeleteStation\DeleteStationCommand;
use Charging\Application\Commands\Station\DeleteStation\DeleteStationDTO;
use Charging\Application\Commands\Station\GetStation\GetStationCommand;
use Charging\Application\Commands\Station\GetStation\GetStationDTO;
use Charging\Application\Commands\Station\UpdateStation\UpdateStationCommand;
use Charging\Application\Commands\Station\UpdateStation\UpdateStationDTO;
use Charging\Domain\Exception\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\PathParameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Response;

class StationController extends Controller
{
    #[Post(
        '/station',
    )]
    #[RequestBody(
        content: new JsonContent(
            required: ['latitude', 'longitude', 'company_id', 'name', 'address'],
            properties: [
                new Property('latitude', type: 'float'),
                new Property('longitude', type: 'float'),
                new Property('companyId', type: 'integer'),
                new Property('name', type: 'string'),
                new Property('address', type: 'string'),
            ]
        )
    )]
    #[\OpenApi\Attributes\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Invalid request',
        content: new JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    public function create(Request $request, CreateStationCommand $command): JsonResponse
    {
        $request->validate([
            'name' => 'required | string | min:1 | max:30',
            'latitude' => 'required',
            'longitude' => 'required',
            'companyId' => 'required | integer',
            'address' => 'required | string | min:1',
        ]);

        $command(new CreateStationDTO(
            $request->input('name'),
            $request->input('latitude'),
            $request->input('longitude'),
            $request->input('address'),
            $request->input('companyId')
        ));

        return new JsonResponse();
    }

    #[Get(
        '/station/{id}',
    )]
    #[\OpenApi\Attributes\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
        content: new JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    #[\OpenApi\Attributes\Response(
        response: Response::HTTP_OK,
        description: 'Company get',
        content: new JsonContent(ref: DTOSchema::STATION_SCHEMA)
    )]
    public function get(
        #[PathParameter(schema: new Schema(type: 'integer'))] int $id,
        GetStationCommand $command
    ): JsonResponse {
        try {
            $station = $command(new GetStationDTO($id));
        } catch (NotFoundException $exception) {
            return \response()->json(new ErrorDTO($exception));
        }

        return \response()->json(new StationDTO($station));
    }

    #[Put(
        '/station/{id}',
    )]
    #[RequestBody(
        content: new JsonContent(
            required: ['id', 'latitude', 'longitude', 'company_id', 'name', 'address'],
            properties: [
                new Property('id', type: 'integer'),
                new Property('latitude', type: 'float'),
                new Property('longitude', type: 'float'),
                new Property('companyId', type: 'integer'),
                new Property('name', type: 'string'),
                new Property('address', type: 'string'),
            ]
        )
    )]
    #[\OpenApi\Attributes\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Invalid request',
        content: new JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    public function update(
        #[PathParameter(schema: new Schema(type: 'integer'))] int $id,
        Request $request,
        UpdateStationCommand $command
    ): JsonResponse {
        $request->validate([
            'id' => 'required | integer',
            'name' => 'required | string | min:1 | max:30',
            'latitude' => 'required',
            'longitude' => 'required',
            'companyId' => 'required | integer',
            'address' => 'required | string | min:1',
        ]);

        try {
            $command(
                new UpdateStationDTO(
                    $id,
                    $request->input('name'),
                    $request->input('latitude'),
                    $request->input('longitude'),
                    $request->input('address'),
                    $request->input('companyId')
                )
            );
        } catch (NotFoundException $exception) {
            return \response()->json(new ErrorDTO($exception));
        }

        return new JsonResponse();
    }

    #[Delete(
        '/station/{id}',
    )]
    #[\OpenApi\Attributes\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
        content: new JsonContent(ref: DTOSchema::ERROR_DTO_SCHEMA)
    )]
    public function delete(
        #[PathParameter(schema: new Schema(type: 'integer'))] int $id,
        DeleteStationCommand $command
    ): JsonResponse {
        try {
            $command(new DeleteStationDTO($id));
        } catch (NotFoundException $exception) {
            return \response()->json(new ErrorDTO($exception));
        }

        return new JsonResponse();
    }
}
