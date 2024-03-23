import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

    inputs
    columns = [
        'numero-experimentation',
        'type-experimentation',
        'site-essai',
        'systeme-essai',
        'lot-cellules',
        'passage',
        'stress',
        'temps-traitement',
        'genes-analyses',
        'proteine-correspondante',
        'proteines-analysees',
        'gene-correspondant',
        'projet',
        'nom-item',
        'numero-item',
        'type-echantillon',
        'nom-r-et-d',
        'nom-commercial',
        'reference-produit',
        'pourcentage-produit',
        'genre',
        'espece',
        'fold-change',
        'augmentation-diminution',
        'notation'
    ];

    connect() {

        this.inputs = this.element.querySelectorAll('input[type="checkbox"]')
        
        for(let input of this.inputs){
            input.addEventListener('change', (event) => {

                console.log(event.target.value, event.target.checked)
                console.log(this.columns.indexOf(event.target.value))

                this.dispatch("hide", { 
                    detail: {
                        index: this.columns.indexOf(event.target.value), 
                        checked: event.target.checked
                    }
                })

            })
        }

    }

    disconnect(){

        for(let input of this.inputs){
            input.removeEventListener('change')
        }
    }



}
