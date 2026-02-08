<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\SiteContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heroTitle', TextType::class, ['label' => 'Titre principal'])
            ->add('heroSubtitle', TextType::class, ['label' => 'Sous-titre'])
            ->add('heroDescription', TextareaType::class, ['label' => 'Description', 'attr' => ['rows' => 4]])
            ->add('phone', TextType::class, ['label' => 'Téléphone'])
            ->add('whatsapp', TextType::class, ['label' => 'WhatsApp'])
            ->add('email', TextType::class, ['label' => 'Email']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SiteContent::class,
        ]);
    }
}
