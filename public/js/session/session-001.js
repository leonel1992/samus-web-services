class Session {
    
    code = null;
    codeID = null;
    modalCode = null;

    constructor(modalCode = null){
        this.modalCode = modalCode;
        this.initModalCode();

        Forms.initValidateForm();
        Inputs.initAll();
    }

    // MODAL CODE ------------------------------------------------------------

    initModalCode() {
        document.querySelector(`#${this.modalCode} input[name="code"]`)?.addEventListener("input", () => {
            this.validateCode();
        });
    
        document.querySelector(`#${this.modalCode} button[name="submit-code"]`)?.addEventListener("click", () => {
            this.sendCode();
        });
    }

    validateCode() {
        this.code = document.querySelector(`#${this.modalCode} input[name="code"]`)?.value ?? "";
        const button = document.querySelector(`#${this.modalCode} button[name="submit-code"]`);
        if (button) {
            button.disabled = this.code.length < 6;
        }
    }
    
    async sendCode() {
        await this.sendData({
            'code': this.code,
            'code_id': this.codeID
        },'code/validate').then((resp) => {
            if (resp?.success) {
                this.hideModalCode();
                document.dispatchEvent(new CustomEvent('modal:codeValidated'));
            }
        });
    }   

    hideModalCode() {
        hideModal(`#${this.modalCode}`);
    }

    showModalCode() {
        const modalElement = document.querySelector(`#${this.modalCode}`);
        if (modalElement) {
            modalElement.querySelector(`input[name="code"]`).value = '';
            showModal(`#${this.modalCode}`);
        }
    }
    
    // DATA ------------------------------------------------------------

    async sendData(data, method, toast=null) {
        data["csrf_token"] = getTokenCSRF();
        
        $("#loading").fadeIn("fast");
        let resp = await new Data(
            URL_LANG + `/session/`, "POST", "json"
        ).load(data, method);
        
        let ret = resp;
        let typeToast;

        if (resp?.success) {
            if (resp.codeID) {
                ret = null;
                typeToast = TypeToast.info;
                this.codeID = resp.codeID;
                this.showModalCode();
            } else if (toast) {
                typeToast = toast;
            } else {
                typeToast = TypeToast.success;
            }
        } else {
            typeToast = TypeToast.danger;
            console.error(resp.message);
        } 
        
        $("#loading").fadeOut("fast");
        showToast(typeToast, resp.message);
        return ret;
    }
 
    validateFormData(key, fields) {

        const toastCount = (from) => {
            return Object.keys(validFields).reduce((acc, field, index) => {
                return from <= index + 1 && !validFields[field] ? acc + 1 : acc;
            }, 0);
        }

        const toastPX = () => {
            return toastCount(1) > 1 ? "px-2" : "px-0";
        }

        const toastMessage = (type, index, cont) => {
            let pt = cont > 0 ? "" : "pt-0";
            let pb = toastCount(index) > 1 ? "" : "pb-0";
            let element = document.getElementById(`${key}-toast-${type}`);
            return `<li class="list-group-item bg-transparent ${toastPX()} ${pt} ${pb}">
                ${element?.value ?? ''}
            </li>`;
        }

        //----------------------------------
    
        let validFields = {};
        fields.forEach(field => {
            let input = document.querySelector(`#${key}-${field}`);
            if (input && (input.required || input.hasAttribute("required"))) {
                validFields[field] = Forms.validate(`#${key}-${field}`);
            }
        });

        if (Object.values(validFields).every(Boolean)) {
            return true;
        } 
        
        let message = '<ul class="list-group list-group-flush">';
        let count = 0;

        Object.keys(validFields).forEach((field, index) => {
            if (!validFields[field]) {
                message += toastMessage(field, index + 1, count);
                count++;
            }
        });

        message += "</ul>";
        showToast(TypeToast.danger, message);
        return false;
    }

    getFormData(key, fields) {
        let data = {};
        fields.forEach(field => {
            let element = document.querySelector(`#${key}-${field}`);
            if (element) {
                if (element.tagName === "INPUT" && element.type === "checkbox") {
                    data[field.replaceAll('-','_')] = element.checked;
                } else {
                    data[field.replaceAll('-','_')] = element.value;
                }
            }
        });

        return data;
    }

}