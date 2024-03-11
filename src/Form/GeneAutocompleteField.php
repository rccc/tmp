<?php

namespace App\Form;

use App\Entity\Experimentation;
use App\Repository\ExperimentationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField(route: 'ux_entity_autocomplete_search')]
class GeneAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Experimentation::class,
            'placeholder' => '',
            // 'choice_label' => 'name',
            'searchable_fields' => ['gene'],
            // 'query_builder' => function (ExperimentationRepository $experimentationRepository) {
            //     return $experimentationRepository->createQueryBuilder('experimentation');
            // },
            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
