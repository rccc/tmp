import { Controller } from '@hotwired/stimulus';
import { useDebounce, useClickOutside } from 'stimulus-use'

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

    static debounces = ['change']
    static targets = ['input','list']
    static values = {
      url: String
    }

    connect() {
        useDebounce(this, { wait: 100 })
        useClickOutside(this)
    }

    async change(event) {

        let value = event.target.value
        
        if(value.length > 1) {

            let response = await (await fetch(this.urlValue, {
                method: 'POST',
                headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({'pattern':value})
            })).json()
            
            if(response.status == 'success'){
                this.createList(response.data)
            }

        }

    }

    createList(data) {
        this.listTarget.innerHTML = data
        this.listTarget.classList.remove('u-hide')
    }

    select(event){
        this.inputTarget.value = event.params.value
        this.removeList()
    }

    clickOutside(event) {
        this.removeList()
    }

    removeList() {
        this.listTarget.classList.add('u-hide')
        this.listTarget.innerHTML = ''
    }
}
