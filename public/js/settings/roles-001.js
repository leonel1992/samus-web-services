class RolesAccordionCkeckType {
    static all = 'all';
    static module = 'module';
    static submodule = 'submodule';
}

class RolesAccodionItemType {
    static item = 'item';
    static module = 'module';
}

class SettingsRoles extends Manage {

    #dataActions = {};
    #dataModules = {};
    #dataGrouped = {};

    constructor() {
        super(URL_LANG + "/settings/roles/");
    }
    
    // DATA ---------------------------------------------

    async loadData(){
        this.#dataActions = await this.loadDataList(URL_LANG + "/settings/roles/data-actions");
        this.#dataModules = await this.loadDataList(URL_LANG + "/settings/roles/data-modules");
        this.#dataGrouped = await this.loadDataList(URL_LANG + "/settings/roles/data-grouped-permissions");
        this.#printAccordion();
        super.loadData();
    }

    getSubmitData() {
        return {
            id: document.getElementById('id')?.value,
            name: document.getElementById('name')?.value,
            description: document.getElementById('description')?.value,
            permissions: this.#getDataPermissions()
        };
    }

    #getDataPermissions() {
        let permissions = [];
        document.querySelectorAll("#permissions .form-check-action").forEach((element) => {
            let permId = element.getAttribute("data-id");
            permissions.push({
                permission: permId,
                value: element.checked
            });
        });

        return permissions;
    }

    // INITS ---------------------------------------------

    #initAccordion() {
        document.querySelector("#permissions-check-all").addEventListener("click", (event) => {
            let accordion = document.querySelector("#permissions");
            let checked = event.currentTarget.checked;

            this.#accordionChecks(accordion, checked);
            this.#accordionCheckButtons(accordion, RolesAccordionCkeckType.submodule);
            this.#accordionCheckButtons(accordion, RolesAccordionCkeckType.module);
            this.#accordionCheckButtons(accordion, RolesAccordionCkeckType.all);
        });

        document.querySelectorAll("#permissions .form-check-module, #permissions .form-check-submodule").forEach(element => {
            element.addEventListener("click", (event) => {
                this.#accoridonCheckValues(event.currentTarget);
            });
        });

        document.querySelectorAll("#permissions .form-check-action").forEach(element => {
            element.addEventListener("click", (event) => {
                let item = this.#accodionItem(event.currentTarget, RolesAccodionItemType.item);
                let module = this.#accodionItem(event.currentTarget, RolesAccodionItemType.module);
                let accordion = document.querySelector("#permissions");

                this.#accordionCheckButtons(item, RolesAccordionCkeckType.submodule);
                this.#accordionCheckButtons(module, RolesAccordionCkeckType.module);
                this.#accordionCheckButtons(accordion, RolesAccordionCkeckType.all);
            });
        });
    }

    #accodionItem(input, type) {
        let ref = input.getAttribute(`for-${type}`);
        let item = document.getElementById(`permissions-accordion-item-${ref}`);
        return item;
    }

    #accodionCollapse(input) {
        let ref = input.getAttribute("for-item");
        let item = document.getElementById(`permissions-accordion-collapse-${ref}`);
        return item;
    }

    #accordionChecks(item, check) {
        item.querySelectorAll(".form-check-action").forEach(element => {
            element.checked = check;
        });
    } 

    #accoridonCheckValues(input){
        let item = this.#accodionItem(input, RolesAccodionItemType.item);
        let module = this.#accodionItem(input, RolesAccodionItemType.module);
        let collapse = this.#accodionCollapse(input);
        let accordion = document.querySelector("#permissions");
        let checked = input.checked;
        
        new bootstrap.Collapse(collapse, {
            toggle: true
        });

        this.#accordionChecks(item, checked);
        this.#accordionCheckButtons(item, RolesAccordionCkeckType.submodule);
        this.#accordionCheckButtons(module, RolesAccordionCkeckType.module);
        this.#accordionCheckButtons(accordion, RolesAccordionCkeckType.all);
    }

    #accordionCheckButtons(item, type) {
        let input = type === RolesAccordionCkeckType.all 
            ? document.querySelectorAll("#permissions-check-all") 
            : item.querySelectorAll(`.form-check-${type}`);
        
        input?.forEach(el => {
            el.checked = false;
            el.removeAttribute("some-checked");
        });
    
        let countTrue = 0;
        let countFalse = 0;
        let countTotal = 0;

        item?.querySelectorAll(".form-check-action")?.forEach(element => {
            countTotal++;
            element.checked ? countTrue++ : countFalse++;
        });
    
        if (countTotal === countTrue) {
            input?.forEach(el => el.checked = true);
        } else if (countTrue > 0 && countFalse > 0) {
            input?.forEach(el => el.setAttribute("some-checked", "true"));
        }
    }

    // VIEWS ---------------------------------------------

    updateFormData(updateId = true){
        super.updateFormData(updateId);

        document.querySelectorAll("#permissions input[type='checkbox']").forEach((input) => {
            input.removeAttribute("some-checked");
            input.checked = false;
        });

        if(this.submitKey){
            let permissions = this.data?.[this.submitKey]?.permissions ?? {};
            permissions.forEach((permission) => {  
                let input = document.getElementById(`permission-${permission.permission}`);
                if (input) {
                    input.checked = permission.value;
                    let item = this.#accodionItem(input, RolesAccodionItemType.item);
                    let module = this.#accodionItem(input, RolesAccordionCkeckType.module);
                    this.#accordionCheckButtons(item, RolesAccordionCkeckType.submodule);
                    this.#accordionCheckButtons(module, RolesAccordionCkeckType.module);
                }
            });
        }

        const accordion = document.getElementById("permissions");
        this.#accordionCheckButtons(accordion, RolesAccordionCkeckType.all);
    }

    disabledInputs(formGroup) {
        super.disabledInputs(formGroup);
        this.#enabledAccordion();
    }

    enabledInputs(formGroup){
        super.enabledInputs(formGroup);
        this.#enabledAccordion();
    }

    #enabledAccordion() {
        document.querySelector("#form-group-manage-permissions")?.querySelectorAll(".form-control, .custom-control").forEach((element) => {
            switch (this.submitType) {
                case ManageSubmitType.update:
                    if (this.submitKey) {
                        element.removeAttribute("disabled");
                    } else {
                        element.setAttribute("disabled", "true");
                    } break;
    
                case ManageSubmitType.insert:
                    element.removeAttribute("disabled");
                    break;
                
                case ManageSubmitType.delete:
                    element.setAttribute("disabled", "true");
                    break;
            }
            
            if (element.classList.contains("accordion-button")) {
                const target = element.getAttribute("data-bs-target") || element.getAttribute("aria-controls");
                if (target) {
                    const collapseElement = document.querySelector(target);
                    if (collapseElement) {
                        const bsCollapse = new bootstrap.Collapse(collapseElement, {toggle: false});
                        bsCollapse.hide();
                    }
                }
            }
        });
    }

    #printAccordion() {
        const accordion = document.getElementById("permissions");
        if (accordion) {
            accordion.innerHTML = this.#htmlAccordion();
            setTimeout(() => this.#initAccordion(), 10);
        }
    }

    // HTML ---------------------------------------------

    htmlTableRow(index, key, item){
        return `
        <tr data-index="${index}" data-key="${key}">
            <th class="text-center" style="width:40px;">${index + 1}</th>
            <td style="min-width:100px">${item.id}</td>
            <td style="min-width:100px">${item.name}</td>
            <td style="min-width:300px">${super.htmlTableEmptyText(item.description)}</td>
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    } 
    
    htmlSelectOption(index, key, item) {
        const selected = key === this.submitKey ? 'selected' : '';
        return `<option data-index="${index}" value="${key}" subtitle="${key}" ${selected}>
            ${item.name}
        <option>`;
    }

    // HTML ACCORDION ----------------------------------------

    #htmlAccordion() {
        let html = '';
        Object.entries(this.#dataGrouped).forEach(([keyModule, itemModule]) => {
            let module = this.#htmlAccordionUniqueId('mod');
            html += this.#htmlAccordionModule(keyModule, itemModule, module);
        }); return html;
    }
    
    #htmlAccordionModule(keyModule, itemModule, module) { 
        return `<div class="accordion-item" id="permissions-accordion-item-${module}">
            <p class="accordion-header" id="permissions-accordion-header-${module}">
                <button class="accordion-button collapsed custom-control p-2" type="button" data-bs-toggle="collapse" data-bs-target="#permissions-accordion-collapse-${module}" aria-expanded="false" aria-controls="permissions-accordion-collapse-${module}">
                    <span class="form-check custom-form-check ms-1">
                        <input id="permissions-accordion-check-${module}" type="checkbox" class="form-check-input form-check-module custom-control" for-item="${module}" for-module="${module}">
                    </span>
                    ${this.#htmlAccordionFormatText(this.#dataModules?.[keyModule]?.module ?? keyModule)}
                </button>
            </p>
            <div id="permissions-accordion-collapse-${module}" class="accordion-collapse collapse" aria-labelledby="permissions-accordion-header-${module}" data-bs-parent="#permissions">
                ${this.#htmlAccordionModuleCollapse(itemModule, module)}
            </div>
        </div>`;
    }

    #htmlAccordionModuleCollapse(itemModule, module) { 

        let submodules = itemModule?.submodules ?? {};
        if (Object.keys(submodules).length === 0 && Object.keys(permissions).length > 0) {
            return this.#htmlAccordionChecks(permissions, module, module, '12');
        } 

        return `<div class="accordion-body p-0">
            <div class="accordion accordion-flush custom-accordion" id="permissions-${module}">
                ${this.#htmlAccordionModuleCheckBox(module, itemModule?.permissions)}
                ${this.#htmlAccordionSubmodules(module, itemModule?.submodules)}
            </div>
        </div>`;
    }

    #htmlAccordionModuleCheckBox(module, permissions) {
        let html = '';
        let submodule = this.#htmlAccordionUniqueId('sub');
        if (permissions && Object.keys(permissions).length > 0) {
            html += `<div class="accordion-item" id="permissions-accordion-item-${module}-${submodule}">
                ${this.#htmlAccordionChecks(permissions, `${module}-${submodule}`, module, '12')}
            </div>`;
        } return html;
    }

    #htmlAccordionSubmodules(module, submodules) {
        let html = '';
        if (submodules && Object.keys(submodules).length > 0) {
            Object.entries(submodules).forEach(([keySubmodule, itemSubmodule]) => {
                html += this.#htmlAccordionSubmodule(keySubmodule, itemSubmodule, module);
            });
        } return html;
    }
    
    #htmlAccordionSubmodule(keySubmodule, itemSubmodule, module) {
        let submodule = this.#htmlAccordionUniqueId('sub');
        return `<div class="accordion-item border-1" id="permissions-accordion-item-${module}-${submodule}">
            <p class="accordion-header" id="permissions-accordion-header-${module}-${submodule}">
                <button class="accordion-button collapsed custom-control p-2" type="button" data-bs-toggle="collapse" data-bs-target="#permissions-accordion-collapse-${module}-${submodule}" aria-expanded="false" aria-controls="permissions-accordion-collapse-${module}-${submodule}">
                    <span class="form-check custom-form-check" style="margin-left:20px">
                        <input id="permissions-accordion-check-${module}-${submodule}" type="checkbox" class="form-check-input form-check-submodule custom-control" for-item="${module}-${submodule}" for-module="${module}">
                    </span>
                    ${this.#htmlAccordionFormatText(this.#dataModules?.[itemSubmodule.id]?.submodule ?? itemSubmodule.id)}
                </button>
            </p>
            <div id="permissions-accordion-collapse-${module}-${submodule}" class="accordion-collapse collapse" aria-labelledby="permissions-accordion-header-${module}-${submodule}" data-bs-parent="#permissions-${module}">
                ${this.#htmlAccordionChecks(itemSubmodule?.permissions, `${module}-${submodule}`, module, '30')}
            </div>
        </div>`;
    }

    #htmlAccordionChecks(permissions, refItem, refModule, marg) {
        let html = '';

        if (permissions && Object.values(permissions).length > 0) {
            Object.values(permissions).forEach(item => {
                html += `<div class="form-check custom-form-check py-1 my-0" style="margin-left:${marg}px">
                    <input id="permission-${item.id}" data-id="${item.id}" type="checkbox" 
                        class="form-check-input form-check-action custom-control" 
                        for-item="${refItem}" for-module="${refModule}">
                    <label class="form-check-label" for="permission-${item.id}">
                        ${this.#htmlAccordionFormatText(this.#dataActions?.[item.action]?.name ?? item.action)}
                    </label>
                </div>`;
            });
        }
        
        return `<div class="accordion-body px-3 py-2">
            ${html}
        </div>`;
    }
    
    #htmlAccordionUniqueId(prefix) {
        return prefix +'-'+ Math.random().toString(36).substr(2, 9);
    }
    
    #htmlAccordionFormatText(text) {
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

}