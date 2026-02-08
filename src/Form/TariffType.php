<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Tariff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TariffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, ['label' => 'Libellé'])
            ->add('price', TextType::class, ['label' => 'Prix'])
            ->add('position', IntegerType::class, ['label' => 'Ordre']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tariff::class,
        ]);
    }
}
