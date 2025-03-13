<?php

namespace App\Http\Controllers;

use App\DTO\NYTDtoParam;
use App\Http\Requests\NYTListRequest;
use App\Services\NYTIntegration;
use Illuminate\Http\JsonResponse;

class NYTController extends Controller
{
    public function __invoke(NYTListRequest $request, NYTIntegration $NYTIntegration): JsonResponse
    {
        $dto = new NYTDtoParam(
            author: $request->input('author'),
            isbn: $request->input('isbn'),
            title: $request->input('title'),
            offset: $request->input('offset')
        );

        $response = $NYTIntegration->fetchBestSellers($dto);

        return $response
            ? response()->json($response)
            : response()->json(['error' => 'Failed to fetch data from NYT API'], 503);
    }
}
