class SessionRecover extends Session {

    fields = [
        "email"
    ];

    constructor() {
        super('modal-code'); 
        this.init();
    }

    init() {
        document.getElementById("recover-form").addEventListener("submit", (event) => {
            event.preventDefault();
        });

        document.getElementById("recover-submit").addEventListener("click", async () => {
            if (this.validateFormData('recover', this.fields)) {
                const data = this.getFormData('recover', this.fields);
                this.sendData(data, 'recover');
            }
        });

        $(document).on('modal:codeValidated', () => {
            $("#loading").fadeIn("fast");
            const urlForm = document.getElementById("recover-form").getAttribute('action');
            loadViewData(urlForm).then((response) => {
                if (response.success) {
                    document.getElementById("content").innerHTML = response.content;
                    document.getElementById("recover-code-id").value = this.codeID;
                    document.getElementById("recover-code").value = this.code;
                    new SessionRecoverPass();
                } else {
                    showToast(TypeToast.danger, response.errorTitle + '<br>' + response.errorMessage);
                } $("#loading").fadeOut("fast");
            });
        });
    }
}


///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////


class SessionRecoverPass extends Session{

    fieldsCode = [
        "code",
        "code-id",
    ];

    fieldsData = [
        "password",
        "password-confirm"
    ];

    constructor() {
        super();
        this.init();
    }

    init() {
        document.getElementById("recover-form").addEventListener("submit", (event) => {
            event.preventDefault();
        });

        document.getElementById("recover-submit").addEventListener("click", async () => {
            if (this.validateFormData('recover', this.fieldsData)) {
                let data = this.getFormData('recover', this.fieldsCode);
                data.data = this.getFormData('recover', this.fieldsData);
                this.sendData(data, 'recover').then((resp) => {
                    if (resp?.success) {
                        $('#recover-success').fadeIn();
                    }
                });
            }
        });
    }
}