<?php

namespace App\Form;

use App\Entity\InvoiceImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_image',FileType::class,
                [
                'label' => 'label.file_image',
                'required' => false
                 ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoiceImage::class,
            'csrf_protection' => false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
