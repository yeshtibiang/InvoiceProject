<?php

namespace App\Form;

use App\Entity\InvoiceLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description',
                    'class' => 'form-control mt-2',
                ],
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'placeholder' => 'Quantity',
                    'class' => 'form-control mt-2',
                ],
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount',
                'attr' => [
                    'placeholder' => 'Amount',
                    'class' => 'form-control mt-2',
                ],
            ])
            ->add('vatAmount', NumberType::class, [
                'label' => 'VAT Amount',
                'attr' => [
                    'placeholder' => 'VAT Amount',
                    'class' => 'form-control mt-2',
                ],
            ])
//            ->add('totalVat', NumberType::class, [
//                'label' => 'Total VAT',
//                'attr' => [
//                    'placeholder' => 'Total VAT',
//                    'class' => 'form-control mt-2',
//                ],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLine::class,
        ]);
    }
}
