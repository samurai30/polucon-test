<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GetAllSurveyorsController extends AbstractController
{
    /**
     * @Route("/get/all/surveyors", name="get_all_surveyors")
     */
    public function index()
    {
        return $this->render('get_all_surveyors/index.html.twig', [
        'controller_name' => 'GetAllSurveyorsController',
    ]);
    }
}
