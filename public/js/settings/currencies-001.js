class SettingsCurrencies extends Manage {

    #dataTypes = {};

    constructor() {
        super(URL_LANG + "/settings/currencies/");
    }

    // DATA ---------------------------------------------

    async loadData(){
        this.#dataTypes = await this.loadDataList(URL_LANG + "/settings/currencies/data-types");
        this.printSelect("#type", this.#dataTypes, this.#htmlSelectType);
        super.loadData();
    }

    getSubmitFormData() {  
        let data = this.getSubmitData();
        data.id = data.code.toLocaleLowerCase();
        return data;
    }

    // INITS ---------------------------------------------

    initForm() {
        super.initForm();

        $("#type").on("select2:select", (e) => {
            const type = e.target.value;
            
            const placeholderCode = this.#getDataText('code-placeholder', type);
            const placeholderName = this.#getDataText('name-placeholder', type);
            const placeholderSymb = this.#getDataText('symbol-placeholder', type);
            const invalidFeedbackCode = this.#getDataText('code-invalid-feedback', type);
            const invalidFeedbackName = this.#getDataText('name-invalid-feedback', type);
            const invalidFeedbackSymb = this.#getDataText('symbol-invalid-feedback', type);

            const elementCode = document.querySelector("#code");
            const elementName = document.querySelector("#name");
            const elementSymb = document.querySelector("#symbol");

            if (elementCode && elementName && elementSymb) {
                switch (type) {
                    case 'currency':
                        elementCode.setAttribute("maxlength", 3);
                        elementCode.setAttribute("validate-length", 3);
                        elementSymb.setAttribute("validate-value", true);
                        elementSymb.setAttribute("required", "");
                        break;
                
                    default:
                        elementCode.setAttribute("maxlength", 20);
                        elementCode.setAttribute("validate-length", 1);
                        elementSymb.setAttribute("validate-value", false);
                        elementSymb.removeAttribute("required");
                        Forms.clean("#symbol");
                        break;
                }

                elementCode.setAttribute("placeholder", placeholderCode);
                elementName.setAttribute("placeholder", placeholderName);
                elementSymb.setAttribute("placeholder", placeholderSymb);

                const elementFeedbackCode = document.querySelector("#input-group-code .invalid-feedback");
                const elementFeedbackName = document.querySelector("#input-group-name .invalid-feedback");
                const elementFeedbackSymb = document.querySelector("#input-group-symbol .invalid-feedback");
                if (elementFeedbackCode) elementFeedbackCode.textContent = invalidFeedbackCode;
                if (elementFeedbackName) elementFeedbackName.textContent = invalidFeedbackName;
                if (elementFeedbackSymb) elementFeedbackSymb.textContent = invalidFeedbackSymb;
            }
        });
    }

    #getDataText(typeText, typeCurrency) {
        return (document.querySelector(`#manage-${typeText}-${typeCurrency}`) 
            ?? document.querySelector(`#manage-${typeText}-default`))?.dataset.text;
    }
    
    // HTML ---------------------------------------------

    htmlSelectOption(index, key, item) {
        const selected = key === this.submitKey ? 'selected' : '';
        return `<option data-index="${index}" value="${key}" subtitle="${item.name}" ${selected}>
            ${this.#dataTypes?.[item.type]?.name ?? item.type} // ${item.code}
        <option>`;
    }

    htmlTableRow(index, key, item){
        return `
        <tr data-index="${index}" data-key="${key}">
            <th class="text-center">${index + 1}</th>
            <td class="text-center">${this.#dataTypes?.[item.type]?.name ?? item.type}</td>
            <td class="text-center">${item.code}</td>
            <td class="text-center">${this.htmlTableEmptyText(item.symbol)}</td>
            <td class="">${item.name}</td>
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }

    // --------------------------------------------

    #htmlSelectType(key, item){
        return `<option value="${key}">${item.name}<option>`;
    }
}