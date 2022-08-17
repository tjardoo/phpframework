<?php

namespace App\Services;

use Carbon\Carbon;
use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use App\DTO\DepartureResult;
use App\Enums\DepartureStatus;
use App\Enums\TrainCategory;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ConnectException;

class DutchRailwayService
{
    public function __construct(
        private string $apiKey,
    ) {
    }

    /**
     * List of departures for a specific station
     * @param string $station
     * @return Collection<int, \App\DTO\DepartureResult>
     */
    public function getDeparturesByStation(string $station)
    {
        $baseUrl = 'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/';

        $headers = [
            'Ocp-Apim-Subscription-Key' => $this->apiKey,
        ];

        $params = [
            'station' => $station,
            'maxJourneys' => 10,
        ];

        $stack = HandlerStack::create();

        $stack->push($this->getRetryMiddleware());

        $client = new Client([
            'base_uri' => $baseUrl,
            'timeout' => 5,
            'headers' => $headers,
            'handlers' => $stack,
        ]);

        $response = $client->get('departures', ['query' => $params]);

        $content = json_decode($response->getBody()->getContents(), true);

        $result = new Collection();

        foreach ($content['payload']['departures'] as $item) {
            $result->push(new DepartureResult(
                $item['direction'],
                $item['name'],
                DepartureStatus::from($item['departureStatus']),
                $item['plannedTrack'],
                TrainCategory::from($item['trainCategory']),
                Carbon::parse($item['plannedDateTime']),
                Carbon::parse($item['actualDateTime']),
            ));
        }

        return $result;
    }

    private function getRetryMiddleware(int $maxRetries = 5): callable
    {
        return Middleware::retry(function (int $retries, RequestInterface $request, ?RuntimeException $exception, ?ResponseInterface $response = null, ) use ($maxRetries) {
            if ($retries >= $maxRetries) {
                return false;
            }

            if ($response && in_array($response->getStatusCode(), [429, 503])) {
                return true;
            }

            if ($exception instanceof ConnectException) {
                return true;
            }

            return false;
        });
    }
}
