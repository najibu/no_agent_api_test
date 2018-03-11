<?php

namespace App\Http\Transformers;

use App\Property;
use League\Fractal\TransformerAbstract;

class PropertyTransformer extends TransformerAbstract
{
    public function transform(Property $property)
    {
        return [
            'id' => (int) $property->id,
            'address_1' => $property->address_1,
            'address_2' => $property->address_2,
            'city' => $property->city,
            'postcode' => $property->postcode,
            'latitude' => (float) $property->latitude,
            'longitude' => (float) $property->longitude,
        ];
    }
}
