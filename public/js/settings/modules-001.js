class SettingsModules extends Manage {

    #dataIds = {};
    #dataModules = {};

    constructor() {
        super(URL_LANG + "/settings/modules/");
    }

    // DATA ---------------------------------------------

    async loadData(){
        await this.loadDataList(URL_LANG + "/settings/modules/data-modules").then((data) => {
            this.printSelect("#modules-datalist", data, this.#htmlDatalistModules);
        });

        this.#dataIds = await this.loadDataList(URL_LANG + "/settings/modules/data-routes");
        this.printSelect("#id", this.#dataIds, this.#htmlSelectId);
        super.loadData();
    }

    // INITS ---------------------------------------------

    initForm() {
        super.initForm();
        
        $("#id").on("select2:select", (e) => {
            const value = e.target.value;
            if (value) {
                Object.entries(this.#dataIds[value]).forEach(([lang, link]) => {
                    const input = document.querySelector(`#link-${lang}`);
                    if (input) input.value = link;
                });
            }
        });
    }
    
    // HTML ---------------------------------------------

    htmlSelectOption(index, key, item) {
        return `<option data-index="${index}" value="${key}" subtitle="${key}">
            ${this.#htmlTextModule(item)}
        <option>`;
    }

    htmlTableRow(index, key, item){
        return `
        <tr data-index="${index}" data-key="${key}" >
            <th class="text-center">${index + 1}</th>
            <td style="min-width:200px;">${item.id}</td>
            <td style="min-width:100px;">${this.htmlTableEmptyText(item.module)}</td>
            <td style="min-width:100px;">${this.htmlTableEmptyText(item.submodule)}</td>
            <td style="min-width:150px;">${this.#htmlTableLink(item.link_es, 'es')}</td>
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }

    //--------------------------------------------
    
    #htmlTableLink(link, lang){
        if (!link) return '-';
        return `<a class="custom-text" target="_blank" href="${URL_PATH}/${lang}${link}">
            ${link}
        </a>`;
    }
    
    #htmlDatalistModules(_key, item){
        return `<option value="${item.name}"><option>`;
    }

    #htmlTextModule(item){
        if (item.submodule) {
            return `${item.module} // ${item.submodule}`;
        } return item.module;
    }

    #htmlSelectId(key, item){
        return `<option value="${key}" subtitle="${item[LANG] ?? item.es}">${key}<option>`;
    }
}