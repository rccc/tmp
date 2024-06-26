import { Controller } from '@hotwired/stimulus';
import DataGridXL from "@datagridxl/datagridxl2";
import Papa from 'papaparse';

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

    static targets = ["spinner"]

    static grid
    static id

    initialize() {
        // console.log()
        // this.element.style.height = (this.element.clientHeight - 38) +"px";
    }
    
    connect() {

        let my_data = DataGridXL.createEmptyData(100, 20);
        this.id = this.element.querySelector('#grid')
        if(this.id){

            this.grid = new DataGridXL(this.id, {
                data: my_data,
                // disallow drag actions
                allowInsertRows: false,
                allowDeleteRows: false,
                allowMoveRows: false,
                allowInsertCols: false,
                allowDeleteCols: false,
                allowMoveCols: false,
                allowFillCells: false,
                allowEditCells: false,
                // disallow clipboard
                allowCut: false,
                allowPaste: false,
                // still allow copy & col resize (default)
                allowResizeCols: true,
                allowCopy: true
            });
        }
    }

    onFileChange(event){
        let _grid = this.grid
        let _id =  this.id
        let file = event.target.files[0];
        
        if(file){
            Papa.parse(file, {
                header: true,
                dynamicTyping: true,
                skipEmptyLines : true,
                complete: function(results) {
                    _grid = new DataGridXL(_id, {
                        data: results.data,
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
            });            
        }
    }

    submit(event){
        this.spinnerTarget.classList.remove('u-hide')
        this.element.querySelector('form').submit();
    }

}
