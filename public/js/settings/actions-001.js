class SettingsActions extends Manage {

    constructor() {
        super(URL_LANG + "/settings/actions/");
    }
    
    // HTML ---------------------------------------------

    htmlSelectOption(index, key, item) {
        const selected = key === this.submitKey ? 'selected' : '';
        return `<option data-index="${index}" value="${key}" subtitle="${key}" ${selected}>${item.name}<option>`;
    }

    htmlTableRow(index, key, item){
        return `
        <tr data-index="${index}" data-key="${key}">
            <th class="text-center" style="width:40px;">${index + 1}</th>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td style="min-width:250px">${this.htmlTableEmptyText(item.description)}</td>
            ${this.htmlTableUpdateButton()}
            ${this.htmlTableDeleteButton()}
        </tr>`;
    }
}