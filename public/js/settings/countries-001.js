class SettingsCountries extends Manage {

    #dataCurrencies = {};
    #dataTimezones = {};

    constructor() {
        super(URL_LANG + "/settings/countries/");
        this.paths.icon = URL_PATH +"/image/countries/";
    }

    // DATA ---------------------------------------------

    async loadData(){
        this.#dataCurrencies = await this.loadDataList(URL_LANG + "/settings/countries/data-currencies");
        this.#dataTimezones = await this.loadDataList(URL_LANG + "/settings/countries/data-timezones");
        this.printSelect("#currency", this.#dataCurrencies, this.#htmlSelectCurrency.bind(this));
        this.printSelect("#timezone", this.#dataTimezones, this.#htmlSelectTimezone.bind(this));
        super.loadData();
    }
    
    // HTML ---------------------------------------------

    htmlSelectOption(index, key, item) {
        return `<option data-index="${index}" value="${key}" img-icon="${this.paths.icon}${item.icon}">
            ${item.name}
        <option>`;
    }

    htmlTableRow(index, key, item){

        const statusDetails = document.querySelector("#manage-details-status");
        const statusRegName = statusDetails?.dataset?.[item.status_reg ? 'true' : 'false'] ?? item.status_reg;
        const statusCalcName = statusDetails?.dataset?.[item.status_calc ? 'true' : 'false'] ?? item.status_calc;
        const statusRegClass = item.status_reg ? 'success' : 'danger';
        const statusCalcClass = item.status_calc ? 'success' : 'danger';

        return `
        <tr data-index="${index}" data-key="${key}">
            <th class="text-center">${index + 1}</th>
            <td class="text-center">${item.prefix}</td>
            <td class="text-center">${item.iso_2}</td>
            <td class="text-center">${item.iso_3}</td>
            <td class="text-center">${item.currency}</td>
            <td class="text-center">${item.currency}</td>
            <td class="text-center">${item.emoji}</td>
            <td class="cell-img">
                <img src="${this.paths.icon}${item.icon}" alt="">
            </td>
            <td class="">${item.name}</td>
            <td class="">${item.timezone}</td>
            ${this.htmlTableLabel(statusRegClass, statusRegName)}
            ${this.htmlTableLabel(statusCalcClass, statusCalcName)}
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }

    //--------------------------------------

    #htmlSelectCurrency(key, item){
        return `<option value="${key}" 
            subtitle="${item.name}">
            ${item.code}
        <option>`;
    }

    #htmlSelectTimezone(key, _item){
        return `<option value="${key}">
            ${key}
        <option>`;
    }
}