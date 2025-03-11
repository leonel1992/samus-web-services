class Data {

    constructor(url, type, dataType, timeout=5000) {
        this.url = url;
        this.type = type;
        this.data = dataType;
        this.timeout = timeout;
    }

    async load(data, method) {
        return new Promise(response => {
            $.ajax({
                url: this.url + method,
                type: this.type,
                data: data,
                dataType: this.dataType,
                timeout: this.timeout,
                async: true,
                success: function (resp) {
                    response(resp);
                },
                error: xhr => {
                    response({
                        "success": false,
                        "message": LANGUAGE.error[xhr.status] ?? LANGUAGE.error.default,
                        "title": LANGUAGE.error.title.replace('[[CODE]]', xhr.status > 0 ? xhr.status : "000")
                    });
                }
            });
        });
    }
}