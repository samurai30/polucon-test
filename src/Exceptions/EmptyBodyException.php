<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 21-07-2019
 * Time: 07:34 PM
 */

namespace App\Exceptions;


use Throwable;

class EmptyBodyException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct("The body cannot be null for POST/PUT methods", $code, $previous);
    }
}