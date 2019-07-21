<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 09-07-2019
 * Time: 11:58 PM
 */

namespace App\Security;


use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserConfirmationService
{

    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UsersRepository $usersRepository, EntityManagerInterface $entityManager)
    {
        $this->usersRepository = $usersRepository;
        $this->entityManager = $entityManager;
    }

    public function confirmUser(string $confirmationToken){
        $user = $this->usersRepository->findOneBy(['confirmationToken' => $confirmationToken]);

        if (!$user){
            throw new NotFoundHttpException();
        }
        $user->setEnabled(true);
        $user->setConfirmationToken(null);
        $this->entityManager->flush();
    }
}