<?php

namespace Modules\Generality\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Modules\Generality\Http\Requests\WeatherRequest;
use Modules\Generality\Repositories\Interfaces\WeatherRepositoryInterface;

class WeatherController extends BaseController
{
    /**
     * repository
     * @var Object $weatherRepository
     */
    protected $weatherRepository;

    /**
     * WeatherController constructor.
     * @param WeatherRepositoryInterface $weatherRepository
     */
    public function __construct(WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $weathers = $this->weatherRepository->findAllTranslated();
        return $this->sendResponse($weathers, "List all weathers translated");
    }

    /**
     * Endpoint to create a new Weather
     * @param WeatherRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WeatherRequest $request)
    {
        $weatherData = $this->getWeatherData($request);
        try {
            $weather = $this->weatherRepository->create($weatherData);
            return $this->sendResponse($weather, 'Weather created!', 201);
        } catch (\Exception $e) {
            return $this->sendError("An error has occurred creating a Weather!", $e->getMessage());
        }
    }

    /**
     * Endpoint to update a Weather by ID
     * @param $id
     * @param WeatherRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, WeatherRequest $request)
    {
        $weather = $this->weatherRepository->find($id);
        if (!$weather) {
            return $this->sendError("Weather not found", "NOT_FOUND", 404);
        }

        $weatherData = $this->getWeatherData($request);

        try {
            $weather = $this->weatherRepository->update($weatherData, [
                "id" => $id
            ]);
            return $this->sendResponse($weather, 'Weather updated!', 200);
        } catch (\Exception $e) {
            return $this->sendError("An error has occurred updating a Weather!", $e->getMessage());
        }
    }

    /**
     * Endpoint to delete a Weather
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $weather = $this->weatherRepository->find($id);
        if (!$weather) {
            return $this->sendError("Weather not found", "NOT_FOUND", 404);
        }
        
        try {
            $weather = $this->weatherRepository->delete($id);
            return $this->sendResponse($weather, 'Weather deleted!', 200);
        } catch (\Exception $e) {
            return $this->sendError("An error has occurred trying to delete a Weather!", $e->getMessage());
        }
    }

    /**
     * @param WeatherRequest $request
     * @return array[]
     */
    private function getWeatherData(WeatherRequest $request)
    {
        return [
            "es" => [
                "name" => $request->es
            ],
            "en" => [
                "name" => $request->en
            ],
            "code" => $request->code
        ];
    }
}
