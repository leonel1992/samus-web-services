class SessionRegister extends Session {

    fields = [
        "email",
        "terms",
    ];

    constructor() {
        super('modal-code'); 
        this.init();
    }

    init() {
        document.getElementById("register-form").addEventListener("submit", (event) => {
            event.preventDefault();
        });

        document.getElementById("register-submit").addEventListener("click", async () => {
            if (this.validateFormData('register', this.fields)) {
                const data = this.getFormData('register', this.fields);
                this.email = data.email;
                this.sendData(data, 'register');
            }
        });

        $(document).on('modal:codeValidated', () => {
            $("#loading").fadeIn("fast");
            const urlForm = document.getElementById("register-form").getAttribute('action');
            loadViewData(urlForm).then((response) => {
                if (response.success) {
                    document.getElementById("content").innerHTML = response.content;
                    document.getElementById("register-code-id").value = this.codeID;
                    document.getElementById("register-code").value = this.code;
                    document.getElementById("register-email").value = this.email;
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

    fieldsData = [
        "name",
        "last-name",
        "country",
        "phone",
        "password",
        "password-confirm"
    ];

    constructor() {
        super();
        this.init();
    }

    init() {
        document.getElementById("register-form").addEventListener("submit", (event) => {
            event.preventDefault();
        });

        document.getElementById("register-submit").addEventListener("click", async () => {
            if (this.validateFormData('register', this.fieldsData)) {
                let data = this.getFormData('register', this.fieldsCode);
                data.data = this.getFormData('register', this.fieldsData);
                this.sendData(data, 'register').then((resp) => {
                    if (resp?.success) {
                        $('#register-success').fadeIn();
                    }
                });
            }
        });
    }
}