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
    
    static targets = ["panel"]

    toggleCollapse(event) {
        event.preventDefault()
        if(this.panelTarget.classList.contains('is-collapsed')){
            this.panelTarget.classList.remove('is-collapsed')
        }
        else{
            this.panelTarget.classList.add('is-collapsed')            
        }
    }

    togglePin(event) {
        event.preventDefault()
        if(this.panelTarget.classList.contains('is-pinned')){
            this.panelTarget.classList.remove('is-pinned')
        }
        else{
            this.panelTarget.classList.add('is-pinned')            
        }
    }

    close(event) {
        this.panelTarget.classList.add('is-collapsed')            
    }

    default(event) {
        this.panelTarget.classList.remove('is-narrow')
        this.panelTarget.classList.remove('is-wide')
    }

    wide(event) {
        this.panelTarget.classList.remove('is-narrow')
        this.panelTarget.classList.add('is-wide')
    }

    narrow(event) {
        this.panelTarget.classList.remove('is-wide')
        this.panelTarget.classList.add('is-narrow')
    }

}
