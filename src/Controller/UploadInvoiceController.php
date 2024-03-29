<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Images;
use App\Entity\InvoiceImage;
use App\Entity\Invoices;
use App\Form\ImageUserType;
use App\Form\InvoiceImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;


class UploadInvoiceController extends AbstractController
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

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $manager, ValidatorInterface $validator)
    {


        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->validator = $validator;
    }

    public function __invoke(Request $request)
    {
        $invoice_image = new InvoiceImage();

        $form = $this->formFactory->create(InvoiceImageType::class,$invoice_image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($invoice_image);
            $this->manager->flush();
            $invoice_image->setFileImage(null);

            return $invoice_image;
        }

        throw new ValidationException(
            $this->validator->validate($invoice_image)
        );

    }
}
