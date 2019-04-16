<?php
/**
 * Created by PhpStorm.
 * User: Sohail Khan
 * Date: 4/12/2019
 * Time: 8:13 PM
 */

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        if($e instanceof ModelNotFoundException)
        {
            return response()->json([
                'errors' => 'Product Model not found'
            ],Response::HTTP_NOT_FOUND);
        }

        if($e instanceof NotFoundHttpException)
        {
            return response()->json([
                'errors' => 'Route not found'
            ],Response::HTTP_NOT_FOUND);
        }
    }
}