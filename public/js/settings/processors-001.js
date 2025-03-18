class SettingsProcessors extends Manage {

    #dataCurrencies = {};
    #dataCountries = {};
    #dataPayments = {};

    constructor() {
        super(URL_LANG + "/settings/processors/");
        this.paths.icon = URL_PATH +"/image/processors/";
    }

    // DATA ---------------------------------------------

    async loadData(){
        const naText = document.getElementById('manage-option-na').dataset.text;
        this.#dataCurrencies = await this.loadDataList(URL_LANG + "/settings/processors/data-currencies");
        this.#dataCountries = await this.loadDataList(URL_LANG + "/settings/processors/data-countries");
        this.#dataPayments = await this.loadDataList(URL_LANG + "/settings/processors/data-payment-methods");
        this.printSelect("#currency", this.#dataCurrencies, this.#htmlSelectCurrency.bind(this));
        this.printSelect("#country", this.#dataCountries, this.#htmlSelectCountry.bind(this), naText);
        this.printSelect("#payment", this.#dataPayments, this.#htmlSelectPayment.bind(this));
        super.loadData();
    }

    // INITS ---------------------------------------------

    initForm() {
        super.initForm();
        
        $("#country").on("select2:select", (e) => {
            const selectCurrency = document.querySelector("#currency");
            if (selectCurrency) {
                selectCurrency.value = this.#dataCountries?.[e.target.value]?.currency;
                selectCurrency.dispatchEvent(new Event("change", { bubbles: true }));
            }
        });

        $("#payment").on("select2:select", (e) => {
            const divDetails = document.querySelector("#manage-details-country");
            const selectCountry = document.querySelector("#country");
            if (selectCountry && divDetails) {

                let placeholder;
                if (this.#dataPayments?.[e.target.value]?.need_country) {
                    placeholder = divDetails.getAttribute("data-paceholder-true");
                    selectCountry.setAttribute("validate-value", "true");
                    selectCountry.setAttribute("required", "");
                } else {
                    placeholder = divDetails.getAttribute("data-paceholder-false");
                    selectCountry.setAttribute("validate-value", "false");
                    selectCountry.removeAttribute("required");
                } 
                
                const spanPalceholder = selectCountry.parentElement.querySelector(".select2-selection__placeholder");
                if (spanPalceholder) {
                    selectCountry.setAttribute("data-placeholder", placeholder);
                    spanPalceholder.textContent = placeholder;
                }
            }
        });
    }
    
    // HTML ---------------------------------------------

    htmlSelectOption(index, key, item) {
        return `<option value="${key}" data-index="${index}" 
            img-icon="${this.paths.icon}${item.icon}">
            ${item.name}
        <option>`;
    }

    htmlTableRow(index, key, item){

        const statusDetails = document.querySelector("#manage-details-status");
        const statusBuyName = statusDetails?.dataset?.[item.status_buy ? 'true' : 'false'] ?? item.status_buy;
        const statusSellName = statusDetails?.dataset?.[item.status_sell ? 'true' : 'false'] ?? item.status_sell;
        const statusBuyClass = item.status_buy ? 'success' : 'danger';
        const statusSellClass = item.status_sell ? 'success' : 'danger';

        const invertDetails = document.querySelector("#manage-details-invert");
        const invertName = invertDetails?.dataset?.[item.invert ? 'yes' : 'no'] ?? item.invert;
        const invertClass = item.invert ? 'success' : 'default';

        let countryName = '';
        let countryIcon = '-';
        if (item.country && item.country !== '') {
            countryName = this.#dataCountries?.[item.country]?.name ?? item.country;
            countryIcon = `<img src="${this.#dataCountries?.[item.country]?.icon_url}" alt="">`
        }

        const paymentName = this.#dataPayments?.[item.payment]?.name ?? item.payment;
        const paymentIcon = `<img src="${this.#dataPayments?.[item.payment]?.icon_url}" alt="">`;

        const currencyCode = this.#dataCurrencies?.[item.currency]?.code ?? item.currency;
        const currencySymbol = this.htmlTableEmptyText(this.#dataCurrencies?.[item.currency]?.symbol ?? null);
        const currencyDecimals = this.htmlTableEmptyText(this.#dataCurrencies?.[item.currency]?.decimals ?? null);
   
        return `
        <tr data-index="${index}" data-key="${key}">
            <th class="text-center">${index + 1}</th>
            <td class="cell-img">${countryIcon}</td>
            <td class="">${countryName}</td>
            <td class="cell-img">${paymentIcon}</td>
            <td class="">${paymentName}</td>
            <td class="cell-img">
                <img src="${this.paths.icon}${item.icon}" alt="">
            </td>
            <td class="">${item.name}</td>
            <td class="text-center">${currencyCode}</td>
            <td class="text-center">${currencySymbol}</td>
            <td class="text-center">${currencyDecimals}</td>
            ${this.htmlTableLabel(invertClass, invertName)}
            ${this.htmlTableLabel(statusBuyClass, statusBuyName)}
            ${this.htmlTableLabel(statusSellClass, statusSellName)}
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }

    // ---------------------------------------------

    #htmlSelectCountry(key, item){
        return `<option value="${key}"
            img-icon="${item.icon_url}">
            ${item.name}
        <option>`;
    }

    #htmlSelectCurrency(key, item){
        return `<option value="${key}" 
            subtitle="${item.name}">
            ${item.code}
        <option>`;
    }

    #htmlSelectPayment(key, item){
        return `<option value="${key}"
            img-icon="${item.icon_url}">
            ${item.name}
        <option>`;
    }
}