<?php

namespace App\Form;

use App\Dto\ExpFinderDto;
use App\Entity\Experimentation;
use App\Form\GeneAutocompleteField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_exp',ChoiceType::class, [
                'placeholder' => '',
                'choices' => !empty($options['num_exp']) ? $options['num_exp'] : [],
                'required' => false 
            ])
            ->add('type_exp',ChoiceType::class, [
                'placeholder' => '',
                'choices' => !empty($options['type_exp']) ? $options['type_exp'] : [],
                'required' => false 
            ])
            ->add('site_essai')
            ->add('syst_essai',ChoiceType::class, [
                'placeholder' => '',
                'choices' => !empty($options['syst_essai']) ? $options['syst_essai'] : [],
                'required' => false 
            ])
            ->add('lot_cell')
            ->add('passage')
            ->add('stress')
            ->add('temps_traitement')
            ->add('gene')   
            ->add('prot_analyse')
            ->add('gene_corr')
            ->add('projet')
            ->add('nom_item')
            ->add('nom_comm',ChoiceType::class, [
                'placeholder' => '',
                'choices' => !empty($options['nom_comm']) ? $options['nom_comm'] : [],
                'required' => false 
            ])
            ->add('ref_produit')
            ->add('pourcentage_produit')
            ->add('genre')
            ->add('espece')
            ->add('fold_change')
            ->add('augm_dim')
            ->add('notation')
            ->add('prot_corr')
            ->add('num_item')
            ->add('type_echantillon')
            ->add('nom_rec_dev')
            ->add('export', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'    => ExpFinderDto::class,
            'num_exp'       => [],
            'type_exp'      => [],
            'nom_comm'      => [],
            'syst_essai'    => []
        ]);
    }
}
