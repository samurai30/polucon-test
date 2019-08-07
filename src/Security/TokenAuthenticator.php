<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 08-07-2019
 * Time: 08:05 PM
 */

namespace App\Security;

use App\Entity\Users;
use App\Exceptions\SurveyorException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticator extends  JWTTokenAuthenticator
{
    /**
     * @param PreAuthenticationJWTUserToken $preAuthToken
     * @param UserProviderInterface $userProvider
     * @return UserInterface|void|null
     * @throws SurveyorException
     */
    public function getUser($preAuthToken, UserProviderInterface $userProvider)
 {
    $user = parent::getUser($preAuthToken,$userProvider);
    if ($user->getPasswordChangeDate() && $preAuthToken->getPayload()['iat']<$user->getPasswordChangeDate()){
        throw new ExpiredTokenException();
    }

    return $user;

 }



}