<?php

namespace App\Form;

use App\Entity\DataSource;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Shapecode\Bundle\HiddenEntityTypeBundle\Form\Type\HiddenEntityType;

class DataSourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('source', DropzoneType::class, [
                'attr' => [
                    'placeholder' => 'Drag and drop a file or click to browse',
                ],
                'mapped' => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'extensions' => [
                            'csv' => [
                                'text/csv',
                                'text/plain',
                                'text/x-csv',
                                'application/csv',
                                'application/x-csv',
                                'text/csv',
                                'text/comma-separated-values',
                                'text/x-comma-separated-values',
                                'text/tab-separated-values',
                        ]],
                        'extensionsMessage' => 'Please upload a valid CSV file',
                    ])
                ],
            ])
            // ->add('filename')
            // ->add('created_at')
            ->add('uploader', HiddenEntityType::class, [
                'class' => User::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DataSource::class,
        ]);
    }
}
 