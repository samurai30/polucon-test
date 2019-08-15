<?php

namespace App\Form;

use App\Entity\Invoices;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoicePdfImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_pdf',FileType::class,
                [
                'label' => 'label.file_pdf',
                'required' => false
                 ])
            ->add('file_image',
                FileType::class,
                [
                    'label' => 'label.file_image',
                    'required' => false
                ])
            ->add('status',TextType::class,[
                'label' => 'label.status',
                'required' => true
            ])
            ->add('clients',EntityType::class,[
                'class' => Users::class,
                'required' => true

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoices::class,
            'csrf_protection' => false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
