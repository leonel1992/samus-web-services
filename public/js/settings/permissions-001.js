class SettingsPermissions extends Manage {

    #dataActions = {};
    #dataModules = {};
    #dataGrouped = {};

    constructor() {
        super(URL_LANG + "/settings/permissions/");
    }

    // DATA ---------------------------------------------

    async loadData(){
        this.#dataActions = await this.loadDataList(URL_LANG + "/settings/permissions/data-actions");
        this.#dataModules = await this.loadDataList(URL_LANG + "/settings/permissions/data-modules");
        this.#dataGrouped = await this.loadDataList(URL_LANG + "/settings/permissions/data-grouped-modules");
        this.#printSelects();
        super.loadData();
    }

    getSubmitData() {
        let module = document.getElementById('submodule')?.value;
        if (!module || module === '' || module === this.optionNull) {
            module = document.getElementById('module')?.value;
        } 
        
        return {
            action: document.getElementById('action')?.value,
            module: module,
        };
    } 

    // INITS ---------------------------------------------

    initForm() {
        super.initForm();

        $("#module").on("select2:select", (e) => {
            const selectSubmodule = document.querySelector("#submodule");
            if (selectSubmodule) {
                selectSubmodule.value = "";
                selectSubmodule.selectedIndex = -1;
                $(selectSubmodule).trigger("change.select2");
        
                const module = document.querySelector("#module")?.value;

                selectSubmodule.disabled = !module;
                selectSubmodule.querySelectorAll("option").forEach((option) => {
                    if (option.dataset.module !== module && option.value !== this.optionNull) {
                        option.classList.add("d-none");
                    } else {
                        option.classList.remove("d-none");
                    }
                });
            }
        });
    }

    // VIEWS ---------------------------------------------

    #printSelects() {
        const naText = document.getElementById('manage-option-na').dataset.text;
        this.printSelect("#action", this.#dataActions, this.#htmlSelectAction);
        this.printSelect("#module", this.#dataGrouped, this.#htmlSelectModule);
        this.printSelect("#submodule", null, null, naText);

        if (this.#dataGrouped && typeof this.#dataGrouped === "object" && Object.keys(this.#dataGrouped).length > 0) {
            Object.entries(this.#dataGrouped).forEach(([key, item]) => { 
                if (typeof item === "object" && item.submodules && Object.keys(item.submodules).length > 0) {
                    this.printSelect("#submodule", item.submodules, (keySub, itemSub) => 
                        this.#htmlSelectSubmodule(keySub, itemSub, key));
                }
            });
        }
    }

    // HTML ---------------------------------------------

    htmlSelectOption(index, key, item) {
        const selected = key === this.submitKey ? 'selected' : '';
        return `<option data-index="${index}" value="${key}" subtitle="${key}" ${selected}>
            ${this.#htmlTextPermision(item)}
        <option>`;
    }

    htmlTableRow(index, key, item){
        return `
        <tr data-index="${index}" data-key="${key}">
            <th class="text-center">${index + 1}</th>
            <td style="min-width:100px">${this.#dataModules?.[item.module]?.module ?? item.module}</td>
            <td style="min-width:100px">${super.htmlTableEmptyText(this.#dataModules?.[item.module]?.submodule)}</td>
            <td style="min-width:100px">${this.#dataActions?.[item.action]?.name ?? item.action}</td>
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }

    // ---------------------------------------------

    #htmlTextPermision(item){
        const submodule = this.#dataModules?.[item.module]?.submodule;
        const module = this.#dataModules?.[item.module]?.module ?? item.module;
        const action = this.#dataActions?.[item.action]?.name ?? item.action;
        if (submodule) {
            return `${module} // ${submodule} // ${action}`;
        } return `${module} // ${action}`;
    }

    #htmlSelectAction(key, item){
        return `<option value="${key}">${item.name}<option>`;
    }

    #htmlSelectModule(key, item){
        return `<option value="${key}">${item.module}<option>`;
    }

    #htmlSelectSubmodule(key, item, module){
        return `<option value="${key}" data-module="${module}" class="d-none">
            ${item.submodule}
        <option>`;
    }
}