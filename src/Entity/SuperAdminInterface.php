<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 11-07-2019
 * Time: 11:56 AM
 */

namespace App\Entity;


use Symfony\Component\Security\Core\User\UserInterface;

Interface SuperAdminInterface
{
    public function addUser(UserInterface $user): SuperAdminInterface;
    public function removeUser(UserInterface $user): SuperAdminInterface;
}