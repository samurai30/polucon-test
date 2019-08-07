<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 21-07-2019
 * Time: 07:34 PM
 */

namespace App\Exceptions;


use Throwable;

class SurveyorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Sorry surveyors are not allowed to login to Dashboard", $code, $previous);
    }
}