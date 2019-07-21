<?php

namespace App\Controller;

use App\Security\UserConfirmationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/user_confirmation_token/{token}",name="confirm_user_token")
     * @param string $token
     * @param UserConfirmationService $confirmationService
     * @return RedirectResponse
     */
    public function confirmUserTokenController(string $token, UserConfirmationService $confirmationService)
    {
        $confirmationService->confirmUser($token);
        return $this->redirectToRoute('default_index');
    }
    /**
     * @Route("/",name="default_index")
     * @return Response
     */
    public function index(){
        return $this->render('base.html.twig');
    }
}
