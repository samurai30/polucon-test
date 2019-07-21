<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 11-07-2019
 * Time: 03:13 PM
 */

namespace App\Entity;


interface CreatedDateInterface
{
    public function setCreatedDate(\DateTimeInterface $dateTime):CreatedDateInterface;
}