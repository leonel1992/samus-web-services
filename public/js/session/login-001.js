class SessionLogin extends Session {

    fields = [
        "email",
        "password",
        "remember"
    ];

    constructor(redirect) {
        super('modal-code'); 

        this.redirect = redirect;
        this.init();
    }

    init() {
        document.getElementById("login-form").addEventListener("submit", (event) => {
            event.preventDefault();
        });

        document.getElementById("login-submit").addEventListener("click", async () => {
            if (this.validateFormData('login', this.fields)) {
                const data = this.getFormData('login', this.fields);
                await this.sendData(data, 'login').then((resp) => {
                    if (resp?.success) {
                        this.#redirect();
                    }
                });
            }
        });

        $(document).on('modal:codeValidated', () => {
            this.#redirect();
        });
    }

    async #redirect() {
        $("#loading").fadeIn();
        setTimeout(() => {
            window.location.href = this.redirect;
        }, 1000);
    }
}
