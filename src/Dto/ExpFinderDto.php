<?php 

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ExpFinderDto
{
	public function __construct(
	    public ?string $num_exp = null,
	    public ?string $type_exp = null,
	    public ?string $site_essai = null,
	    public ?string $syst_essai = null,
	    public ?string $lot_cell = null,
	    public ?string $passage = null,
	    public ?string $stress = null,
	    public ?string $temps_traitement = null,
	    public ?string $gene = null,
	    public ?string $prot_analyse = null,
	    public ?string $gene_corr = null,
	    public ?string $projet = null,
	    public ?string $nom_item = null,
	    public ?string $nom_comm = null,
	    public ?string $ref_produit = null,
	    public ?string $pourcentage_produit = null,
	    public ?string $genre = null,
	    public ?string $espece = null,
	    public ?string $fold_change = null,
	    public ?string $augm_dim = null,
	    public ?string $notation = null,
	    public ?string $prot_corr = null,
	    public ?string $num_item = null,
	    public ?string $type_echantillon = null,
	    public ?string $nom_rec_dev = null,
	    public ?string $export = null
	)
	{
	}	
}