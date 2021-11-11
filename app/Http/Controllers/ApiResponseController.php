<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMostPopularVideosRequest;
use App\Http\Resources\MostPopularVideosCollection;
use App\Services\Interfaces\ApiResponseServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;


class ApiResponseController extends Controller
{

   private const PER_PAGE = 2;

    /**
     * @var ApiResponseServiceInterface
     */
    private ApiResponseServiceInterface $apiResponseService;

    /**
     * @param ApiResponseServiceInterface $apiResponseService
     */
    public function __construct(ApiResponseServiceInterface $apiResponseService)
    {
        $this->apiResponseService = $apiResponseService;
    }

    /**
     * Get Most Popular Videos
     *
     * @param GetMostPopularVideosRequest $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function getMostPopularVideos(GetMostPopularVideosRequest $request){

        $data = collect($this->apiResponseService->fetchYouTubeResults());

        if (!$data){
            return response(['message' => 'Something went wrong!'],500);
        }

        $response =  new LengthAwarePaginator(
            $data->forPage($request->page ?? 1, $request->size ?? self::PER_PAGE),
            $data->count(),
            $request->size ?? self::PER_PAGE,
            $request->page ?? 1
        );

        return response(new MostPopularVideosCollection($response),200);
    }
}
