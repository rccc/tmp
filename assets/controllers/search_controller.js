import { Controller } from '@hotwired/stimulus';
import DataGridXL from "@datagridxl/datagridxl2";

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

    async submit(e){
        e.preventDefault()
        let form = this.element.querySelector('form')

        if(!form){
            return false
        } 

        let url = form.getAttribute('action')

        if(!url){
            return false
        } 

        let response = await (await fetch(url, {
            method: 'POST',
            body: new FormData(form)
        })).json()
        
        if(response.status == 'success'){
            let grid = new DataGridXL('grid', {
                data: response.data
            });            
        }

    }
}
