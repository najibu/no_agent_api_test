<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model implements Geocodable
{
    protected $guarded = ['id'];

    public function getAddressString($address)
    {
        $string = implode(' ', $address);

        return urlencode($string);
    }

    public function createProperty($address)
    {
        $geoCodeAddressService = app()->make(GeocodeAddressService::class);

        list($latitude, $longitude) = $geoCodeAddressService->getCoordinates($this->getAddressString($address));
        // dd($latitude, $longitude);
        $address['latitude'] = $latitude;
        $address['longitude'] = $longitude;

        return $this->create($address);
    }
}
