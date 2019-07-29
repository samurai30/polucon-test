<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Image;
use App\Form\ImageUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UploadUserImageActionController extends AbstractController
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(FormFactoryInterface $formFactory,EntityManagerInterface $manager,ValidatorInterface $validator)
    {


        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->validator = $validator;
    }

    public function __invoke(Request $request)
    {

        $image = new Image();

        $form = $this->formFactory->create(ImageUserType::class,$image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($image);
            $this->manager->flush();
            $image->setFile(null);
            return $image;
        }

        throw new ValidationException(
            $this->validator($image)
        );

    }
}
