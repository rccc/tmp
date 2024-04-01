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

    connect() {

        this.inputs = this.element.querySelectorAll('input[type="checkbox"]')

        console.log(this.inputs)

        if(this.inputs){
            for(let input of this.inputs){
                input.addEventListener('change', this.handleChange)
            }
        }
    }

    handleChange(event){

        event.preventDefault()

        let input = event.target
        
        if(!input){
            return false
        }

        let formName = input.dataset.optionsName

        if(!formName){
            return false
        }

        let el = document.querySelector(`[name="${formName}"]`)

        if(!el){
            return false
        }

        if(input.checked){
            el.closest('[data-options-row]').classList.remove('u-hide')
        }
        else{
            el.closest('[data-options-row]').classList.add('u-hide')
        }

        this.persistState()
    }

    persistState() {

    }

    disconnect() {

        if(this.inputs){
            for(let input of this.inputs){
                input.removeEventListener('change', this.handleChange)
            }
        }
    }


}
