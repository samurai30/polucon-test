<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 08-07-2019
 * Time: 11:57 PM
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserConfirmation
 * @ApiResource(
 *     itemOperations={},
 *     collectionOperations={
 *     "post"={
 *          "path" = "/users/confirm"
 *     }
 *     }
 * )
 */
class UserConfirmation
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=30, max=30)
     */
public $confirmationToken;
}