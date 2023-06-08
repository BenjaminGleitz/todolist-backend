<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    /**
     * Provide a centralized display of a JSON, with httpStatusCode, to all Controllers
     *
     * @param mixed $data
     * @param integer $httpStatusCode
     * @return void
     */
    // protected function sendJsonResponse($data, $httpStatusCode=200) {
    protected function sendJsonResponse($data, $httpStatusCode=Response::HTTP_OK) {
        // Return response, with headers
        return response()->json($data, $httpStatusCode);
    }

    /**
     * Provide a centralized empty response, with httpStatusCode, to all Controllers
     *
     * @param integer $httpStatusCode
     * @return void
     */
    // protected function sendEmptyResponse($httpStatusCode=204) {
    // A la place des codes HTTP numériques, on peut utiliser les
    // constantes définies dans la classe Response grâce à la dépendance
    // de Symfony utilisée dans Lumen
    // https://github.com/symfony/symfony/blob/6.0/src/Symfony/Component/HttpFoundation/Response.php
    protected function sendEmptyResponse($httpStatusCode=Response::HTTP_NO_CONTENT) {
        // Return response, with headers
        return response('', $httpStatusCode);
    }
}