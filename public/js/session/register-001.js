class SessionRegister extends Session {

    fields = [
        "account",
        "email",
        "terms",
    ];

    constructor() {
        super('modal-code'); 
        this.#init();
    }

    #init() {
        document.getElementById("register-form").addEventListener("submit", (event) => {
            event.preventDefault();
        });

        document.getElementById("register-submit").addEventListener("click", async () => {
            if (this.validateFormData('register', this.fields)) {
                this.data = this.getFormData('register', this.fields);
                this.sendData(this.data, 'register');
            }
        });

        $(document).on('modal:codeValidated', () => {
            $("#loading").fadeIn("fast");
            const urlForm = document.getElementById("register-form").getAttribute('action');
            loadViewData(urlForm).then((response) => {
                if (response.success) {
                    document.getElementById("content").innerHTML = response.content;
                    document.getElementById("register-user-account").value = this.data.account;
                    document.getElementById("register-user-email").value = this.data.email;
                    document.getElementById("register-user-terms").value = this.data.terms;
                    document.getElementById("register-code-id").value = this.codeID;
                    document.getElementById("register-code").value = this.code;
                    executeViewScripts();

                    if (this.data.account === 'business') {
                        document.getElementById('business-data').classList.remove('d-none');
                    } else {
                        document.getElementById('business-data').remove();
                    } 
                    
                    new SessionRegisterForm();
                } else {
                    showToast(TypeToast.danger, response.errorTitle + '<br>' + response.errorMessage);
                } $("#loading").fadeOut("fast");
            });
        });
    }
}

// ///////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////

class SessionRegisterForm extends Session{

    fieldsCode = [
        "code",
        "code-id",
    ];

    fieldsUserData = [
        "terms",
        "account",
        "email",
        "id-sup",
        "gender",
        "name",
        "last-name",
        "birthdate",
        "document-type",
        "document-number",
        "country",
        "state",
        "city",
        "address",
        "phone",
        "password-1",
        "password-2",
    ];

    fieldsBusinessData = [
        "name",
        "country",
        "state",
        "city",
        "address",
        "type",
        "date",
        "register-type",
        "register-number",
        "phone",
        "email",
        "web",
    ];

    constructor() {
        super();
        this.#init();
        this.#initSelects();
    }

    #initSelects() {

        const changePrefix = (selected, div) => {
            const prefix = selected?.dataset.prefix;
            const element = document.querySelector(div);
            if (element) {
                element.textContent = prefix ?? '- - -';
            }
        };

        const changeSelectData = (selected, select) => {
            const country = selected?.value;
            const element = document.querySelector(select);
            element?.querySelectorAll("option").forEach((option) => {
                option.classList.add('d-none');
                if (option.dataset.country === country) {
                    option.classList.remove('d-none');
                }
            });
        };

        $("#register-user-country").on("select2:select", (e) => {
            const selected = e.target.selectedOptions[0]; 
            changePrefix(selected, '#register-user-phone-prefix');
            changeSelectData(selected, "#register-user-document-type");
        });

        $("#register-business-country").on("select2:select", (e) => {
            const selected = e.target.selectedOptions[0]; 
            changePrefix(selected, '#register-business-phone-prefix');
            changeSelectData(selected, "#register-business-register-type");
            changeSelectData(selected, "#register-business-type");
        });
    }

    #init() {
        document.getElementById("register-form").addEventListener("submit", (event) => {
            event.preventDefault();
        });

        document.getElementById("register-submit").addEventListener("click", async () => {
            let data = this.getFormData('register', this.fieldsCode);
            data.data = {
                business: {},
                user: {},
            };

            if (this.validateFormData('register-user', this.fieldsUserData)) {
                data.data.user = this.getFormData('register-user', this.fieldsUserData);
                if (data.data.user.account === 'business' && this.validateFormData('register-business', this.fieldsBusinessData)) {
                    data.data.business = this.getFormData('register-business', this.fieldsBusinessData);
                } this.#sendData(data);
            }
        });
    }

    #sendData(data) {
        this.sendData(data, 'register').then((resp) => {
            if (resp?.success) {
                let containerSuccess = document.getElementById('register-success');
                if (containerSuccess) {
                    containerSuccess.style.opacity = '0';
                    containerSuccess.style.display = 'block';
                    setDimensContainerMessage();
                    setTimeout(() => {
                        containerSuccess.style.transition = 'opacity 0.5s';
                        containerSuccess.style.opacity = '1';
                    }, 100);
                }
            }
        });
    }
}