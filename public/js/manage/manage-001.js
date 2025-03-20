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

    DELETE = false;
    UPDATE = false;
    INSERT = false;
    
    classData;
    classDataUrl = null;
    classDataType = "POST";
    classDataTypeData = "json";
    classDataTimeout = 5000;
 
    ref;
    data = {};
    paths =  {};
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

        this.DELETE = document.getElementById('manage-delete-permission')?.dataset.value === "true";
        this.INSERT = document.getElementById('manage-insert-permission')?.dataset.value === "true";
        this.UPDATE = document.getElementById('manage-update-permission')?.dataset.value === "true";

        this.classData = new Data(
            this.classDataUrl, 
            this.classDataType,
            this.classDataTypeData,
            this.classDataTimeout,
        );

        Forms.initValidateForm();
        Forms.initInputLabel();
        Tables.initTable();
        Inputs.initAll();
        
        this.initMenu();
        this.initFilter();
        this.initTable();
        this.initForm();
        this.initResp();
        this.loadData();

        document.getElementById("manage-insert")?.classList.remove("disabled");
        document.getElementById("manage-update")?.classList.remove("disabled");
        document.getElementById("manage-delete")?.classList.remove("disabled");
        document.querySelectorAll(".nav-manage .nav-link").forEach(item => {
            item.classList.remove("disabled");
        });
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
    
    changeDataItem(key){
        let item = this.getSubmitFormData();
        let oldKey = this.submitKey;
        let newKey = key ?? item[this.ref];
        this.data[newKey] = item;
        this.submitKey = newKey;
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
        const formData = document.querySelector("#manage-form");
        const formGroupData = document.querySelector("#form-group-manage-data");
        (formGroupData ?? formData)?.querySelectorAll(".form-control, .custom-control").forEach(element => {
            const index = element.getAttribute('id')?.replaceAll('-', '_');
            if(index && !index.startsWith("input_group")) {
                if (element.classList.contains("custom-file")) {
                    data[index] = element.dataset.value;
                } else if (element.tagName === "SELECT") {
                    data[index] = element.value !== this.optionNull ? element.value : null;
                } else if (element.tagName === "INPUT" && element.type === "checkbox") {
                    data[index] = element.checked;
                } else {
                    data[index] = element.value?.trim();
                }
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
        Forms.validate("#manage-id");
        let id = this.submitKey;
        return id !== '' && id !== 0 && id !== null && id !== undefined;
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
        setTimeout(async () => {
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

                    this.printViewData();
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
        }, 500);
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
            this.printViewData();
        }
    }

    async updateData(){
        this.submitType = ManageSubmitType.update;
        let response = await this.submitData();
        if(response.success){
            let key = response[this.ref];
            this.changeDataItem(key);
            this.printViewData();
        }
    }

    async deleteData(confirm = false){
        this.submitType = ManageSubmitType.delete;
        if(confirm){
            let response = await this.submitData();
            if(response.success){
                this.removeDataItem();
                this.printViewData();
                this.updateFormData();
            }
        }else{
            const question = document.getElementById("manage-delete-question")?.dataset.text;
            newModal(TypeModal.question, question, () => this.deleteData(true));
        } 
    }

    // LISTENERS -------------------------------------------------

    tableHandleDblClick = event => {
        this.showSelectedItem(event.currentTarget.dataset.key);
    };
    
    tableHandleDblTouch = event => {
        if (event.detail === 2) {
            this.showSelectedItem(event.currentTarget.dataset.key);
        }
    };

    tableHandleUpdateClick = event => {
        const tr = event.currentTarget.closest("tr");
        this.showSelectedItem(tr.dataset.key);
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

            if (count == 0) {
                this.viewEmpty();
            } else {
                this.viewSuccess();
            }
        };

        document.getElementById("manage-filter-clean")?.addEventListener("click", () => {
            document.getElementById("manage-filter").value = "";
            filterTable();
        });

        document.getElementById("manage-filter")?.addEventListener("input", (e) => {
            filterTable();
        });
    }

    initMenu() {
        let navbarManage = document.getElementById("navbar-manage");
        if (!navbarManage || navbarManage.querySelectorAll(".nav-link").length <= 1) {
            document.documentElement.style.setProperty("--navbar-manage-heigth", "0px");
            navbarManage?.remove();
        } else {
            document.getElementById("tab-table-manage")?.addEventListener("click", () => {
                this.submitType = ManageSubmitType.table;
                this.submitKey = null;
            });
    
            document.getElementById("tab-insert-manage")?.addEventListener("click", () => {
                document.getElementById("manage-insert").classList.remove("d-none");
                document.getElementById("manage-update").classList.add("d-none");
                document.getElementById("manage-delete").classList.add("d-none");
                this.submitKey = null;
                this.submitType = ManageSubmitType.insert;
                this.enabledInputs("#form-group-manage-data");
                this.updateFormData();
                this.hideId();
            });
    
            document.getElementById("tab-update-manage")?.addEventListener("click", () => {
                document.getElementById("manage-update").classList.remove("d-none");
                document.getElementById("manage-insert").classList.add("d-none");
                document.getElementById("manage-delete").classList.add("d-none");
                this.submitKey = document.getElementById("manage-id").value;
                this.submitType = ManageSubmitType.update;
                this.disabledInputs("#form-group-manage-data");
                this.updateFormData();
                this.showId();
            });
    
            document.getElementById("tab-delete-manage")?.addEventListener("click", () => {
                document.getElementById("manage-delete").classList.remove("d-none");
                document.getElementById("manage-insert").classList.add("d-none");
                document.getElementById("manage-update").classList.add("d-none");
                this.submitKey = document.getElementById("manage-id").value;
                this.submitType = ManageSubmitType.delete;
                this.disabledInputs("#form-group-manage-data");
                this.updateFormData();
                this.showId();
            });
        }
    }

    initForm(){

        const modalBody = Array.from(document.body.children).find(el => el.id === 'manage-modal-form');
        if (modalBody) {
            modalBody.remove();
        }

        const modalContent = document.querySelector('#content #manage-modal-form');
        if (modalContent) {
            document.body.appendChild(modalContent);
        }
   
        document.querySelector("#manage-form")?.addEventListener("submit", (e) => {
            e.preventDefault();
        });

        $("#manage-id").on("select2:select", (e) => {
            Forms.cleanAll();
            this.submitKey = e.target.value;
            this.updateFormData(false);
            switch (this.submitType) {
                case ManageSubmitType.update:
                    if (this.submitKey) {
                        this.enabledInputs("#form-group-manage-data");
                    } else {
                        this.disabledInputs("#form-group-manage-data");
                    } break;

                case ManageSubmitType.insert:
                    this.enabledInputs("#form-group-manage-data");
                    break;
                
                case ManageSubmitType.delete:
                    this.disabledInputs("#form-group-manage-data");
                    break;
            }
        });
        
        document.querySelector("#manage-show-form")?.addEventListener("click", () => {
            document.querySelector("#manage-insert")?.classList.remove("d-none");
            document.querySelector("#manage-delete")?.classList.add("d-none");
            document.querySelector("#manage-update")?.classList.add("d-none");
            this.submitKey = null;
            this.updateFormData();
            this.hideId();
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
        const thead = table?.querySelector("thead");
        const tbody = table?.querySelector("tbody");
        if (tbody) {
            tbody.style.transition = "opacity 0.6s";
            tbody.style.display = "none";
            tbody.style.opacity = 0;
            
        }

        let theadHeight = thead?.offsetHeight;
        document.documentElement.style.setProperty("--manage-table-head-height", (theadHeight ?? 0) + "px");
 
        tbody?.querySelectorAll("tr").forEach(row => {
            if (table.classList.contains('table-update')) {
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
        document.querySelector("#response-error button")?.addEventListener("click", () => {
            this.responseView(true);
            setTimeout(() => this.loadData(), 500);
        });
    }

    // VIEWS -----------------------------------------------------------

    showId(){
        const formGroup = document.getElementById("form-group-manage-id");
        if (formGroup) {
            this.enabledInputs("#form-group-manage-id");
            formGroup.style.display = "block";
        }
    }
    
    hideId(){
        const formGroup = document.getElementById("form-group-manage-id");
        if (formGroup) {
            this.disabledInputs("#form-group-manage-id");
            formGroup.style.display = "none";
        }
    }

    disabledInputs(formGroup) {
        const formGroupElement = document.querySelector(formGroup);
        formGroupElement?.querySelectorAll(".form-control, .custom-control, .input-group-label").forEach(element => {
            element.setAttribute("disabled", "true");
        });
    }

    enabledInputs(formGroup){
        const formGroupElement = document.querySelector(formGroup);
        formGroupElement?.querySelectorAll(".form-control, .custom-control, .input-group-label").forEach(element => {
            element.removeAttribute("disabled");
        });
    }

    //-------------------------------------
    
    showSelectedItem(key){
        document.querySelector("#manage-update")?.classList.remove("d-none");
        document.querySelector("#manage-insert")?.classList.add("d-none");
        document.querySelector("#manage-delete")?.classList.add("d-none");
        this.submitKey = key;
        this.updateFormData();
        this.showId();

        const formModal = document.querySelector("#manage-modal-form");
        if (formModal) {
            showModal("#manage-modal-form");
        }

        const formTab = document.querySelector("#manage-view-form.tab-pane");
        if (formTab) {
            const buttonTab = document.querySelector('#tab-update-manage');
            const tab = new bootstrap.Tab(buttonTab);
            tab?.show();
        }
    }

    updateFormData(updateId = true) {
        const key = this.submitKey;
        const data = key !== null ? this.data?.[key] : null;

        const formData = document.querySelector("#manage-form");
        const formGroupData = document.querySelector("#form-group-manage-data");
        (formGroupData ?? formData)?.querySelectorAll(".form-control, .custom-control").forEach(element => {

            try {
                if (data) { 
                    const index = element.id?.replaceAll('-', '_');
                    if(index && !index.startsWith("input_group")) {
                        if (element.classList.contains("custom-file")) {
                            Inputs.fileSetValue(element, this.paths[index] + data[index]);
                        } else if (element.type === "checkbox" || element.type === "radio") {
                            element.checked = !!data[index];
                        } else {
                            element.value = data[index];
                        }
                    }
                } else {
                    if (element.classList.contains("custom-file")) {
                        Inputs.fileSetValue(element, null);
                    } if (element.type === "checkbox" || element.type === "radio") {
                        element.checked = false;
                    } else {
                        element.value = "";
                        if (element.tagName === "SELECT") {
                            element.selectedIndex = -1;
                        }
                    }
                }
            } catch (_) {}

            Forms.clean(element);
            if (element.tagName === "SELECT") {
                element.dispatchEvent(new Event("change", { bubbles: true }));
                // if (element.classList.contains("custom-select")) {
                //     $(element).trigger("select2:select");
                // }
            } else if (element.type === "checkbox" || element.type === "radio") {
                element.dispatchEvent(new Event("change", { bubbles: true }));
            } else {
                element.dispatchEvent(new Event("input", { bubbles: true }));
            }
        });

        if (updateId) {
            const manageId = document.querySelector("#manage-id");
            if (manageId) {
                manageId.value = key;
                manageId.dispatchEvent(new Event("change", { bubbles: true }));
                // if (manageId.classList.contains("custom-select")) {
                //     $(manageId).trigger("select2:select");
                // }
            }
        }
    }

    //------------------------------------

    viewSuccess(){
        this.responseView(false);
    }

    viewEmpty(){
        this.responseView(false, "#response-empty");
    }

    viewError(response){
        this.responseView(false, "#response-error", response);
    }
    
    //------------------------------------

    responseView(loading, respView = null, respData = null) {
        
        const respLoading = document.getElementById("response-loading");
        const respEmpty = document.getElementById("response-empty");
        const respError = document.getElementById("response-error");

        if (loading || respView) {
            document.querySelectorAll(".manage-view .response").forEach(element => {
                element.classList.remove("d-none");
            });
        }

        if (respLoading) {
            if (loading) {
                respLoading.style.opacity = "1";
            } else {
                respLoading.style.opacity = "0";
            }
        }

        if (respView) {
            const respElement = document.querySelector(respView);
            if (respElement) {
                respElement.style.opacity = "1";
                if (respData) {
                    respElement.querySelector(".title").textContent = respData.title ?? LANGUAGE.error.title.replace('[[CODE]]', '000');
                    respElement.querySelector(".message").textContent = respData.message ?? LANGUAGE.error.default;
                }
            }
        } else {
            if (respEmpty) respEmpty.style.opacity = "0";
            if (respError) respError.style.opacity = "0";
        }

        if (!loading && !respView) {
            document.querySelectorAll(".manage-view .response").forEach(element => {
                element.classList.add("d-none");
            });
        }
    }

    printViewData(){
        
        let count = 0;
        let htmlTable = '';
        let htmlSelect = "<option value=''></option>";
        Object.entries(this.data).forEach(([key, item]) => {
            if (typeof item === "object") {
                htmlSelect += this.htmlSelectOption(count, key, item);
                htmlTable += this.htmlTableRow(count, key, item);
                count++;
            }
        });        

        const tbody = document.querySelector("#manage-table tbody");
        if (tbody) {
            tbody.innerHTML = htmlTable;
        }

        const select = document.querySelector("#manage-id");
        if (select) {
            select.innerHTML = htmlSelect;
            if (this.submitKey) {
                const selectedOption = select.querySelector(`option[value="${this.submitKey}"]`);
                if (selectedOption) {
                    selectedOption.selected = true;
                }
            }
        }

        this.initTable();
        Inputs.initSelects();
        if (tbody) {
            setTimeout(() => {
                tbody.style.opacity = 1;
                tbody.style.display = "table-row-group";
                document.dispatchEvent(new Event("manageLoadedTable"));
            }, 10);
        }
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

    htmlSelectOption(index, key, item) {
        const selected = key === this.submitKey ? 'selected' : '';
        return `<option data-index="${index}" value="${key}" ${selected}>${item.name ?? key}<option>`;
    }

    //-------------------------------------

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

    htmlTableLabel(type, text, width=null) {
        let style = '';
        if (width) style = `style="width: ${width}px"`;
        return `<td>
            <span class="table-label table-label-${type}" ${style}>
                ${text}
            </span>
        </td>`;
    }

    htmlTableUpdateButton() {
        if (!this.UPDATE) {
            return `<td class="p-0"></td>`;
        } 

        return `<td class="cell-btn">
            <button class="manage-update custom-text">
                <i class="bi bi-pencil-square"></i>
            </button>
        </td>`;
    }

    htmlTableDeleteButton() {
        if (!this.DELETE) {
            return `<td class="p-0"></td>`;
        }

        return `<td class="cell-btn">
            <button class="manage-delete text-danger">
                <i class="bi bi-trash"></i>
            </button>
        </td>`;
    }

}