<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyStore;
use App\Http\Transformers\PropertyTransformer;
use App\Property;

class PropertiesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::paginate(10);

        $array = fractal()
                    ->collection($properties)
                    ->transformWith(new PropertyTransformer())
                    ->toArray();

        return $this->respondWithPagination($properties, $array);
    }

    /**
     * Store a property.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyStore $request, Property $property)
    {
        $address = $request->all();

        $property->createProperty($address);

        return $this->respondCreated();
    }

    /**
     * Display the specified property.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::find($id);

        if (! $property) {
            return $this->responseNotFound('Property does not exist.');
        }

        $array = fractal()
                    ->item($property, new PropertyTransformer())
                    ->toArray();

        return $this->respond($array);
    }
}
