<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\InvoiceImage;
use App\Entity\InvoicePdf;
use App\Form\InvoicePdfType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UploadInvoicePdfController extends AbstractController
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
        $invoice_pdf = new InvoicePdf();

        $form = $this->formFactory->create(InvoicePdfType::class,$invoice_pdf);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($invoice_pdf);
            $this->manager->flush();
            $invoice_pdf->setFilePdf(null);

            return $invoice_pdf;
        }

        throw new ValidationException(
            $this->validator->validate($invoice_pdf)
        );

    }
}
