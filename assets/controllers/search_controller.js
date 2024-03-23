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

    static targets = ["grid", "exportBtn"]
    
    grid = null 
    
    gridOptions = {
        allowCut: false,
        allowPaste: false,
        allowEditCells: false,
        allowFillCells: false,
        allowDeleteCols: false,
        allowInsertCols: false,
        allowMoveCols: false,
        allowFreezeCols: true,
        allowDeleteRows: false,
        allowInsertRows: false,
        allowMoveRows: false,
        allowHideRows: false,
        allowShowRows: false,
        allowFreezeRows: false
    }

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

        let formData = new FormData(form)

        if(this.isFormEmpty(formData)) {
            alert('Le formulaire est vide !')
            return false
        }

        let response = await (await fetch(url, {
            method: 'POST',
            body: formData
        })).json()
        
        if(response.status == 'success'){
            
            this.gridTarget.classList.remove('u-hide')
            this.exportBtnTarget.classList.remove('u-hide')

            let opts = this.gridOptions

            this.grid = new DataGridXL('grid', {
                data: response.data,
                allowCut: false,
                allowPaste: false,
                allowEditCells: false,
                allowFillCells: false,
                allowDeleteCols: false,
                allowInsertCols: false,
                allowMoveCols: false,
                allowFreezeCols: true,
                allowDeleteRows: false,
                allowInsertRows: false,
                allowMoveRows: false,
                allowHideRows: false,
                allowShowRows: false,
                allowFreezeRows: false
            });            
        }
    }

    isFormEmpty(formData) {

        let isEmpty = true

        for (var pair of formData.entries()) {
            if(pair[0] != '_token'){
                if(pair[1]){
                    isEmpty = false
                    break
                }
            }
            console.log(pair[0]+ ", " + pair[1]);
        }

        return isEmpty
    }

    hideColumn(event) {
        console.log('hideColumn', event.detail)
        
    }

}
