class ManageSubmitType {
    static table = 'table';
    static insert = 'insert';
    static update = 'update';
    static delete = 'delete';
};

/**
 * Abstract Class Manage.
 *
 * @class Manage
 */
class Manage {
    
    classData;
    classDataUrl = null;
    classDataType = "POST";
    classDataTypeData = "json";
    classDataTimeout = 5000;
 
    ref;
    data = {};
    submitId = null;
    submitKey = null;
    submitType = ManageSubmitType.table;
    optionNull = '{{OPTION_NULL}}';

    constructor (dataUrl, ref='id') {
        this.ref = ref;

        if (this.constructor === Manage) {
            throw new Error("Abstract classes can't be instantiated.");
        } 

        this.classDataUrl = dataUrl;
        if (this.classDataUrl === '' || this.classDataUrl === null || this.classDataUrl === undefined) {
            throw new Error("URL for data Managa not defined");
        }

        this.classData = new Data(
            this.classDataUrl, 
            this.classDataType,
            this.classDataTypeData,
            this.classDataTimeout,
        );

        Forms.initValidateForm();
        Inputs.initAll();
        
        this.initFilter();
        this.initTable();
        this.initForm();
        this.initResp();
        this.loadData();
    }

    // GETTER - SETTERS  ------------------------------------------------

    getDataLength(){
        return Object.keys(this.data).length;
    }

    pushDataItem(key) {
        let item = this.getSubmitFormData();
        item[this.ref] = key;
        this.data[key] = item;
    }
    
    changeDataItem(){
        let item = this.getSubmitFormData();
        let oldKey = this.submitKey;
        let newKey = item[this.ref];
        this.data[newKey] = item;
        if (newKey !== oldKey) {
            delete this.data[oldKey];
        }
    }

    removeDataItem(){
        delete this.data[this.submitKey];
        if(this.getDataLength() == 0){
            this.viewEmpty();
        }
    }

    // ----------------------------------

    getSubmitData() {
        let data = {};
        document.querySelectorAll("#manage-form .form-control").forEach(element => {
            const index = element.getAttribute('id')?.replaceAll('-', '_');
            if (element.tagName === "INPUT" && element.type === "checkbox") {
                data[index] = element.checked;
            } else if (element.tagName === "SELECT") {
                if (element.value === this.optionNull) {
                    data[index] = null;
                } else {
                    data[index] = element.value;
                }
            } else {
                data[index] = element.value.trim();
            }
        }); return data;
    }

    getSubmitFormData() {  
        return this.getSubmitData();
    }

    getSubmitFinalData() { 
        switch (this.submitType) {
            case ManageSubmitType.insert:
                return {
                    "data": this.getSubmitData()
                };
        
            case ManageSubmitType.update:
                return {
                    "key": this.submitKey,
                    "data": this.getSubmitData()
                };
        
            case ManageSubmitType.delete:
                return {
                    "key": this.submitKey
                };
            
            default: 
                return {};
        }
    }
    
    // ----------------------------------

    validateSubmitData(){
        return Forms.validateAll();
    } 

    validateSubmitId(){
        let id = this.submitKey;
        return id !== '' && id !== 0 && id !== null && id !== undefined;
    }

    // LISTENERS -------------------------------------------------

    tableHandleDblClick = event => {
        this.showSelectedItem(event.currentTarget);
    };
    
    tableHandleDblTouch = event => {
        if (event.detail === 2) {
            this.showSelectedItem(event.currentTarget);
        }
    };

    tableHandleUpdateClick = event => {
        const tr = event.currentTarget.closest("tr");
        this.showSelectedItem(tr);
    };
    
    tableHandleDeleteClick = event => {
        const tr = event.currentTarget.closest("tr");
        this.submitKey = tr.dataset.key;
        this.deleteData();
    };

    tableHandleFilter = event => {
        const tr = event.currentTarget.closest("tr");
        this.submitKey = tr.dataset.key;
        this.deleteData();
    };

    // INIT DOM -------------------------------------------------
    
    initFilter() {

        const filterTable = ()=> {
            const tableRows = document.querySelectorAll("#manage-table tbody tr");
            const input =  document.getElementById("manage-filter");
            const filter = normalizeText(input.value);

            tableRows.forEach(row => {
                let display = "none";
                row.querySelectorAll("th, td").forEach(cell => {
                    let text = normalizeText(cell.textContent);
                    if (text.includes(filter)) {
                        display = "";
                    }
                }); 
                
                row.style.display = display;
            });
        };

        document.getElementById("manage-filter-clear")?.addEventListener("click", () => {
            document.getElementById("manage-filter").value = "";
            filterTable();
        });

        document.getElementById("manage-filter")?.addEventListener("input", (e) => {
            filterTable();
        });
    }

    initForm(){

        document.querySelector("#manage-form")?.addEventListener("submit", (e) => {
            e.preventDefault();
        });

        document.querySelector("#manage-show-form")?.addEventListener("click", () => {
            document.querySelector("#manage-insert").classList.remove("d-none");
            document.querySelector("#manage-update").classList.add("d-none");
            this.submitKey = null;
            this.updateFormData();
        });

        document.querySelector("#manage-insert")?.addEventListener("click", () => {
            if(this.validateSubmitData()){
                this.insertData();
            }
        });

        document.querySelector("#manage-update")?.addEventListener("click", () => {
            if(this.validateSubmitData() && this.validateSubmitId()){
                this.updateData();
            }
        });

        document.querySelector("#manage-delete")?.addEventListener("click", () => {
            if(this.validateSubmitId()){
                this.deleteData(false);
            }
        });
    }

    initTable() {
        const table = document.querySelector("#manage-table");
        const tbody = table.querySelector("tbody");
        tbody.style.transition = "opacity 0.6s";
        tbody.style.display = "none";
        tbody.style.opacity = 0;

        tbody.querySelectorAll("tr").forEach(row => {
            if (table.classList.contains('table-edit')) {
                row.removeEventListener("dblclick", this.tableHandleDblClick);
                row.removeEventListener("touchend", this.tableHandleDblTouch);
                row.addEventListener("dblclick", this.tableHandleDblClick);
                row.addEventListener("touchend", this.tableHandleDblTouch);

                const btnUpdate = row.querySelector(".manage-update");
                if (btnUpdate) {
                    btnUpdate.removeEventListener("click", this.tableHandleUpdateClick);
                    btnUpdate.addEventListener("click", this.tableHandleUpdateClick);
                }
            }

            const btnDelete = row.querySelector(".manage-delete");
            if (btnDelete) {
                btnDelete.removeEventListener("click", this.tableHandleDeleteClick);
                btnDelete.addEventListener("click", this.tableHandleDeleteClick);
            }
        });
    }

    initResp(){
        // $("#response-error-data").find("button").click(() => {
        //     this.#responseView(true);
        //     setTimeout(() => this.init(), 500);
        // });
    }

    // LOAD DATA -----------------------------------------------------------

    async loadDataList(url) {
        try {
            const resp = await $.getJSON(url);
            return resp ?? [];
        } catch (error) {
            console.error("Error load list: ", url, error);
            return [];
        }
    }

    async loadData(){
        this.responseView(true);
        let response = await this.classData.load({},'table');
        if(response.success){
            if( response.data && Object.keys(response.data).length>0 ){
                if (Array.isArray(response.data)) {
                    this.data = response.data.reduce((acc, item) => {
                        acc[item[this.ref]] = item;
                        return acc;
                    }, {});
                } else {
                    this.data = response.data;
                }

                this.printTable();
                this.viewSuccess();
            }else{
                this.data = {};
                this.viewEmpty();
            }
        }else{
            this.data = {};
            this.viewError(response);
        }

        document.dispatchEvent(new CustomEvent("manageLoadedData", { 
            detail: response.success, 
        }));
    }

    // SUBMIT DATA -----------------------------------------------------------

    async submitData(){
        $("#loading").fadeIn("fast");
        let data = this.getSubmitFinalData();
        let response = await this.classData.load(data, this.submitType);
        if(response.success){
            showToast(TypeToast.success, response.message);
            hideModal("#manage-modal-form");
            this.responseView(false);
        }else{
            showToast(TypeToast.danger, response.message);
        } 
        
        $("#loading").fadeOut("slow");
        return response;
    }

    async insertData(){
        this.submitType = ManageSubmitType.insert;
        let response = await this.submitData();
        if(response.success){
            let key = response[this.ref];
            this.pushDataItem(key);
            this.printTable();
        }
    }

    async updateData(){
        this.submitType = ManageSubmitType.update;
        let response = await this.submitData();
        if(response.success){
            this.changeDataItem();
            this.printTable();
        }
    }

    async deleteData(confirm = false){
        this.submitType = ManageSubmitType.delete;
        if(confirm){
            let response = await this.submitData();
            if(response.success){
                this.removeDataItem();
                this.printTable();
            }
        }else{
            const question = document.getElementById("manage-delete-question")?.dataset.text;
            newModal(TypeModal.question, question, () => this.deleteData(true));
        } 
    }

    // VIEWS -----------------------------------------------------------

    showSelectedItem(trTable){
        document.querySelector("#manage-update").classList.remove("d-none");
        document.querySelector("#manage-insert").classList.add("d-none");
        this.submitKey = trTable.dataset.key;
        this.updateFormData();
        showModal("#manage-modal-form");
    }

    updateFormData(){
        const key = this.submitKey;
        const data = key !== null ? this.data?.[key] : null;
        document.querySelectorAll("#manage-form .form-control").forEach(element => {
            if (data) {
                const index = element.getAttribute('id')?.replaceAll('-', '_');
                element.value = data[index];
            } else {
                element.value = "";
                if (element.tagName === "SELECT") {
                    element.selectedIndex = -1;
                } 
            }
            
            Forms.clean(element);
            if (element.tagName === "SELECT") {
                element.dispatchEvent(new Event("change"));
                if (element.classList.contains("custom-select")) {
                    $(element).trigger("select2:select");
                }
            } else if (element.type === "checkbox" || element.type === "radio") {
                element.dispatchEvent(new Event("change"));
            } else {
                element.dispatchEvent(new Event("input"));
            }
        });
    }

    //------------------------------------

    viewSuccess(){
        this.responseView(false);
    }

    viewEmpty(){
        this.responseView(false, "#response-empty");
    }

    viewError(response){
        this.responseView(false, "#response-error-data", response);
    }
    
    //------------------------------------

    responseView(isLoading, responseID = null, response = null) {

        // if (isLoading || responseID) {
        //     $(".manage-view").find(".response").removeClass("d-none");
        // }

        // if(isLoading){ 
        //     $("#response-loading").css("opacity","1");
        // } else {
        //     $("#response-loading").css("opacity","0");
        // }

        // if (responseID) {
        //     $(responseID).css("opacity","1");
        //     if (response) {
        //         $(responseID).find(".title").text(response.title);
        //         $(responseID).find(".message").text(response.message);
        //     }
        // } else {
        //     $("#response-empty").css("opacity","0");
        //     $("#response-error-data").css("opacity","0");
        // }

        // if (!isLoading && !responseID) {
        //     $(".manage-view").find(".response").addClass("d-none");
        // }
    }

    printTable(){
        
        let html = '';
        let count = 0;
        Object.entries(this.data).forEach(([key, item]) => {
            if (typeof item === "object") {
                html += this.htmlTableRow(count, key, item);
                count++;
            }
        });        

        const tbody = document.querySelector("#manage-table tbody");
        tbody.innerHTML = html;
    
        this.initTable();
        setTimeout(() => {
            tbody.style.opacity = 1;
            tbody.style.display = "table-row-group";
            document.dispatchEvent(new Event("manageLoadedTable"));
        }, 10);
    }

    printSelect(select, data, htmlSelectOption, textOptionNull=null) {
        const selectElement = document.querySelector(select);
        if (selectElement && textOptionNull) {
            const htmlOption = this.htmlOptionNull(textOptionNull);
            selectElement.insertAdjacentHTML("beforeend", htmlOption);
        }

        if (data && typeof data === "object" && Object.keys(data).length > 0 && selectElement) {
            Object.entries(data).forEach(([key, item]) => {
                if (typeof item === "object") {
                    const htmlOption = htmlSelectOption(key, item);
                    selectElement.insertAdjacentHTML("beforeend", htmlOption);
                }
            });
        }
    }

    // HTML -----------------------------------------------------------

    htmlOptionNull(text) {
        return `<option value="${this.optionNull}">${text}<option>`;
    }

    htmlTableRow(index, key, _item) {
        return `
        <tr data-index="${index}" data-key="${key}">
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }

    htmlTableEmptyText(text) {
        if (!text || text === '') {
            return '-';
        } return text;
    }

    htmlTableUpdateButton() {
        return `<td class="text-center p-0" style="width:40px!important;">
            <button class="manage-update border-0 bg-transparent text-primary w-100 p-2 fs-5">
                <i class="bi bi-pencil-square"></i>
            </button>
        </td>`;
    }

    htmlTableDeleteButton() {
        return `<td class="text-center p-0" style="width:40px!important;">
            <button class="manage-delete border-0 bg-transparent text-danger w-100 p-2 fs-5">
                <i class="bi bi-trash"></i>
            </button>
        </td>`;
    }

}