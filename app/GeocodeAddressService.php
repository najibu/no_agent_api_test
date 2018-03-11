<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GeocodeAddressService
{
    const GOOGLE_MAPS_GEOCODE_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCoordinates($address)
    {
        $options = [
            'address' => $address,
            'key' => env('GOOGLE_MAPS_API_KEY')
        ];

        $response = $this->client->get(
            self::GOOGLE_MAPS_GEOCODE_URL
            .
            '?'
            .
            http_build_query($options)
        );

        $data = json_decode($response->getBody(), true);

        if ($response->getStatusCode() !== Response::HTTP_OK ||
            json_last_error() !== JSON_ERROR_NONE ||
            empty($data['results'][0]['geometry']['location']['lat']) ||
            empty($data['results'][0]['geometry']['location']['lng'])
        ) {
            $this->geoCodeException();
        }

        return [
            $data['results'][0]['geometry']['location']['lat'],
            $data['results'][0]['geometry']['location']['lng']
        ];
    }

    protected function geoCodeException()
    {
        $errors = [
            'message' => 'No address found'
        ];

        throw new HttpResponseException(
            response()->json(
                [
                    'errors' => $errors
                ],
                JsonResponse::HTTP_BAD_REQUEST
            )
        );
    }
}
