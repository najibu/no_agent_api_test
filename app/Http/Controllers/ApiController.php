<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiController extends Controller
{
    //const HTTP_NOT_FOUND = 404

    /**
     * $statusCode
     * @var integer
     */
    protected $statusCode = 200;

    /**
     * Gets the value of statusCode.
     *
     * @return mixed
     */
    public function getstatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param mixed $statusCode the statu code
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * responseNotFound
     * @param  string $message
     * @return [type]
     */
    public function responseNotFound($message = 'Not Found!')
    {
        return $this->setstatusCode(Response::HTTP_NOT_FOUND)->respondWithMessage($message);
    }

    /**
     * respondInternalError
     * @param  string $message
     * @return [type]
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respondWithMessage($message);
    }

    /**
     * respondCreated
     * @param  string $message
     * @return [type]
     */
    public function respondCreated($message = 'Property successfully created.')
    {
        return $this->setStatusCode(201)->respondWithMessage($message);
    }

    /**
     * respond
     * @param  array $data
     * @param  array  $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getstatusCode(), $headers);
    }

    /**
     * respondWithMessage
     * @param  [type] $message
     * @return array
     */
    public function respondWithMessage($message)
    {
        return $this->respond([
          'message' => $message,
          'status_code' => $this->getstatusCode()
      ]);
    }

    /**
     * respondWithPagination
     * @param  LengthAwarePaginator $properties
     * @param  array                $data
     * @return array
     */
    protected function respondWithPagination(LengthAwarePaginator $properties, array $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $properties->total(),
                'total_pages' => ceil($properties->total() / $properties->perPage()),
                'current_page' => $properties->currentPage(),
                'limit' => $properties->perPage(),
            ]
       ]);

        return $this->respond($data);
    }
}
