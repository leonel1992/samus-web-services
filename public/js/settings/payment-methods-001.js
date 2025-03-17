class SettingsPaymentMethods extends Manage {

    constructor() {
        super(URL_LANG + "/settings/payment-methods/");
        this.paths.icon = URL_PATH +"/image/payment-methods/";
    }

    // DATA ---------------------------------------------

    updateFormData(updateId = true) {
        super.updateFormData(updateId);
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
        const statusName = statusDetails?.dataset?.[item.status ? 'true' : 'false'] ?? item.status;
        const statusClass = item.status ? 'success' : 'danger';

        const countryDetails = document.querySelector("#manage-details-country");
        const countryName = countryDetails?.dataset?.[item.need_country ? 'yes' : 'no'] ?? item.need_country;
        const countryClass = item.need_country ? 'success' : 'default';
        
        return `
        <tr data-index="${index}" data-key="${key}">
            <th class="text-center">${index + 1}</th>
            <td class="">${item.id}</td>
            <td class="cell-img">
                <img src="${this.paths.icon}${item.icon}" alt="">
            </td>
            <td class="border-start-0">${item.name}</td>
            <td class="">${item.description}</td>
            <td class="text-center">
                <div class="table-label table-label-${countryClass} px50">
                    ${countryName}
                </div>
            </td>
            <td class="text-center">
                <div class="table-label table-label-${statusClass}">
                    ${statusName}
                </div>
            </td>
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }
}