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
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_exp',ChoiceType::class, [
                'label' => 'Numéro expérimentation',
                'placeholder' => '',
                'choices' => !empty($options['num_exp']) ? $options['num_exp'] : [],
                'required' => false 
            ])
            ->add('type_exp',ChoiceType::class, [
                'label' => 'Type expérimentation',
                'placeholder' => '',
                'choices' => !empty($options['type_exp']) ? $options['type_exp'] : [],
                'required' => false 
            ])
            ->add('site_essai', null, [
                'label' => 'Site essai'
            ])
            ->add('syst_essai',ChoiceType::class, [
                'label' => "Système essai",
                'placeholder' => '',
                'choices' => !empty($options['syst_essai']) ? $options['syst_essai'] : [],
                'required' => false 
            ])
            ->add('lot_cell',ChoiceType::class, [
                'label' => 'Lot cellules',
                'placeholder' => '',
                'choices' => !empty($options['lot_cell']) ? $options['lot_cell'] : [],
                'required' => false 
            ])
            ->add('passage',ChoiceType::class, [
                'label' => 'Passage',
                'placeholder' => 'Passage',
                'choices' => !empty($options['passage']) ? $options['passage'] : [],
                'required' => false 
            ])
            ->add('stress', null, [
                'label' => 'Stress'
            ])
            ->add('temps_traitement',null, [
                'label' => 'Temps traitement'
            ])

            ->add('gene',null, [
                'label' => 'Gènes analysés'
            ])   
            ->add('prot_analyse',null, [
                'label' => 'Protéines analysées'
            ])
            ->add('gene_corr',null, [
                'label' => 'Gène correspondant'
            ])
            ->add('projet', ChoiceType::class, [
                'label' => 'Projet',
                'placeholder' => '',
                'choices' => !empty($options['project']) ? $options['project'] : [],
                'required' => false 
            ])
            ->add('nom_item',null, [
                'label' => 'Nom item'
            ])
            ->add('nom_comm',ChoiceType::class, [
                'label' => 'Nom commercial',
                'placeholder' => '',
                'choices' => !empty($options['nom_comm']) ? $options['nom_comm'] : [],
                'required' => false 
            ])
            ->add('ref_produit',null, [
                'label' => 'Référence produit'
            ])
            ->add('pourcentage_produit',null, [
                'label' => 'Pourcentage produit'
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'placeholder' => '',
                'choices' => !empty($options['genre']) ? $options['genre'] : [],
                'required' => false 
            ])
            ->add('espece', ChoiceType::class, [
                'label' => 'Espèce',
                'placeholder' => '',
                'choices' => !empty($options['espece']) ? $options['espece'] : [],
                'required' => false 
            ])
            ->add('fold_change',null, [
                'label' => 'Fold change'
            ])
            ->add('augm_dim',null, [
                'label' => '% augmentation/diminution'
            ])
            ->add('notation',ChoiceType::class, [
                'label' => 'Notation',
                'placeholder' => '',
                'choices' => !empty($options['notation']) ? $options['notation'] : [],
                'required' => false 
            ])
            ->add('prot_corr',null, [
                'label' => 'Protéine correspondante'
            ])
            ->add('num_item',ChoiceType::class, [
                'label' => 'Numéro item',
                'placeholder' => '',
                'choices' => !empty($options['num_item']) ? $options['num_item'] : [],
                'required' => false 
            ])
            ->add('type_echantillon',ChoiceType::class, [
                'label' => 'Type échantillon',
                'placeholder' => '',
                'choices' => !empty($options['type_echantillon']) ? $options['type_echantillon'] : [],
                'required' => false 
            ])
            ->add('nom_rec_dev',null, [
                'label' => 'Nom R&D'
            ])
            ->add('export', SubmitType::class, [
            ])
            ->add('reset', ResetType::class, [
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'    => ExpFinderDto::class,
            'num_exp'       => [],
            'type_exp'      => [],
            'nom_comm'      => [],
            'syst_essai'    => [],
            'project'       => [],
            'num_item'      => [],
            'genre'         => [],
            'espece'        => [],
            'lot_cell'      => [],
            'passage'       => [],
            'notation'      => [],
            'type_echantillon' => []
        ]);
    }
}
