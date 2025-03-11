async function logoutSession() {
    const redirect = document.getElementById("logout-form")?.action ?? '/';
    $("#loading").fadeIn("fast");

    new Data(
        URL_LANG + `/session/`, "POST", "json"
    ).load({
        logout: true,
        csrf_token: getTokenCSRF(),
    }, 'logout').then((resp) => {
        if (resp?.success) {
            showToast(TypeToast.success, resp.message);
            setTimeout(() => {
                window.location.href = redirect;
            }, 1000);
        } else {
            $("#loading").fadeOut("fast");
            showToast(TypeToast.danger, resp.message);
        } 
    });  
}

document.getElementById("logout-form")?.addEventListener("submit", async function(e) {
    e.preventDefault();
    logoutSession();
});

document.addEventListener("DOMContentLoaded", function () {
    const csrfData = {
        csrf_token: getTokenCSRF(),
    };

    document.querySelector("#modal-session-expire .btn-session-logout")?.addEventListener("click", () => {
        logoutSession();
    });

    document.querySelector("#modal-session-expire .btn-session-ping")?.addEventListener("click", () => {
        $.ajax({
            url: URL_PATH +'/session/ping',
            data: csrfData,
            dataType: 'json',
            method: 'POST',
            timeout: 5000,
            async: true,
        });
    });

    setInterval(refreshSessionData, 60000);
    function refreshSessionData() {
        $.ajax({
            url: URL_PATH +'/session/refresh',
            data: csrfData,
            dataType: 'json',
            method: 'POST',
            timeout: 1000,
            async: true,
            success: function(response) {
                if (response.success) {
                    if (response.showDialog) {
                        showModal("#modal-session-expire");
                    }
                } else {
                    $("#loading").fadeOut("slow");
                    showToast(TypeToast.danger, response.title, response.message);
                    setTimeout(() => window.location.href = response.redirect, 1000);
                }
            },
            error(xhr){
                console.log('Refresh error: ', xhr.status);
            }
        });
    }
});