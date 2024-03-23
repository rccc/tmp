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

    static values = {
        url: String
    }
    grid = null 

    async connect() {
        
        this.element.classList.add('u-hide')

        let response = await (await fetch(this.urlValue, {
            method: 'GET'
        })).json()

        if(response.status == 'success'){
            this.element.classList.remove('u-hide')

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
        }else{
            alert('Une erreur est intervenue lors de la récupération des données les données.')
        }
    }
}
