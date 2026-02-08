<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('hours', TextType::class, ['label' => 'Horaires'])
            ->add('focus', TextareaType::class, ['label' => 'Services clés', 'attr' => ['rows' => 3]])
            ->add('position', IntegerType::class, ['label' => 'Ordre']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
