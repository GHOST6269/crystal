<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\DownloadItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DownloadItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('filePath', TextType::class, ['label' => 'Chemin PDF', 'required' => false])
            ->add('pdfFile', FileType::class, [
                'label' => 'Uploader un PDF',
                'mapped' => false,
                'required' => false,
            ])
            ->add('position', IntegerType::class, ['label' => 'Ordre']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DownloadItem::class,
        ]);
    }
}
