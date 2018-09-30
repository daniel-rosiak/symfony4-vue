<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ApiController
 * @package App\Controller\Api
 */
abstract class ApiController extends Controller
{

    /**
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    protected function response($data, int $code = 200) : JsonResponse
    {
        return new JsonResponse(
            $data,
            $code,
            [
                'Access-Control-Allow-Headers' => 'origin, content-type, accept',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, PUT, DELETE, PATCH, OPTIONS'
            ]
        );
    }

    /**
     * @param array $parameters
     * @return array
     */
    protected function prepareParameters(array $parameters) : array
    {
        $parameters = $this->unsetEmptyParameters($parameters);
        return $parameters;
    }

    /**
     * @param array $parameters
     * @return array
     */
    private function unsetEmptyParameters(array $parameters) : array
    {
        $callback = function ($val) {
            if(!is_array($val)) {
                $val = trim($val);
                return $val !== '';
            }
            elseif(is_array($val) && !empty($val)) {
                return true;
            }
            return false;
        };

        return array_filter($parameters, $callback);
    }

}
