<?php

namespace App\Form;

use App\Entity\InvoiceImage;
use App\Entity\InvoicePdf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class InvoicePdfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_pdf',VichFileType::class,
                [
                'label' => 'label.file_image',
                'required' => false
                 ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoicePdf::class,
            'csrf_protection' => false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
