<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\GalleryItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('imagePath', TextType::class, ['label' => 'Chemin image', 'required' => false])
            ->add('imageFile', FileType::class, [
                'label' => 'Uploader une image (jpg/png)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('position', IntegerType::class, ['label' => 'Ordre']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GalleryItem::class,
        ]);
    }
}
