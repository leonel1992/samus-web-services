// LOAD ---------------------------------------------------------------------

window.onload = function () {
    setUserAgent();
    $("#loading").fadeOut('fast');
    window.addEventListener("resize", setUserAgent);
};

function setUserAgent() {
    const agent = navigator.userAgent;
    const isMobile = /Mobile|Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone/i.test(agent);
    document.documentElement.classList.remove("mobile", "desktop");
    document.documentElement.classList.add(isMobile ? "mobile" : "desktop");
}

function getTokenCSRF() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

// APPENDS  ---------------------------------------------------------------------

function appendHeaders(title, description, canonical, url) {
    document.title = title;

    const setMeta = (selector, attr, value) => {
        const element = document.querySelector(selector);
        if (element) element.setAttribute(attr, value);
    };

    setMeta('link[rel="canonical"]', "href", canonical);
    setMeta('meta[name="description"]', "content", description);
    setMeta('meta[property="og:url"]', "content", url);
    setMeta('meta[property="og:title"]', "content", title);
    setMeta('meta[property="og:description"]', "content", description);
    setMeta('meta[name="twitter:title"]', "content", title);
    setMeta('meta[name="twitter:description"]', "content", description);
}

function appendStyle(url) {
    if (!document.querySelector(`link[href="${url}"]`)) {
        const element = document.createElement("link");
        element.rel = "stylesheet";
        element.type = "text/css";
        element.href = url;
        document.head.appendChild(element);
    }
}

function appendScript(url) {
    if (!document.querySelector(`script[src="${url}"]`) && !document.querySelector(`script[href="${url}"]`)) {
        $.ajax({
            url: url,
            dataType: "script",
            async: false,
            success: function() {
                let script = document.createElement("script");
                script.type = "text/javascript";
                script.href = url;
                document.body.appendChild(script);
            },
            error: function() {
                console.log(`ERROR: Don't load ${url}"`);
            }
        });
    }
}

// // HISTORY ---------------------------------------------------------------------

$(window).on("popstate", function(e) {
    if (window.history.state && window.history.state["load"]) {
        loadView(window.history.state.page, false).then(()=>{
            historyMenu( $('.nav-link[href="'+ window.history.state.page +'"]') );
        });
    }
});

function historyMenu(item) {
    $(".submenu").removeClass("show");
    $(".nav-link").removeClass("active");
    $(".nav-link").removeClass("expanded");
    $(".nav-link").removeAttr("aria-expanded");

    $(item).addClass("active");
    $(item).parents(".dropdown").find(".dropdown-toggle").addClass("active");
    if( $(item).parent().parent().hasClass("collapse") ){
        let parents = $(item).parent().parent();
        for (let i=0; i<parents.length; i++) {
            let id = $(parents[i]).attr("id");
            $('#'+id).addClass("show");
            $('a[href="#'+ id +'"]').addClass("expanded");
            $('a[href="#'+ id +'"]').attr("aria-expanded", 'true');
        }
    }
}

// // VIEWS ---------------------------------------------------------------------

$(".load-lang").click(function (e) { 
    e.preventDefault;
    loadLang($(this));
});

function loadLang(item){
    let lang = $(item).attr("lang");
    let module = $("body").attr("module");
    if (lang && module) {
        let vars = "?lang="+ lang +"&module="+ module;
        window.location.href = URL_PATH +"/system/route/url"+ vars;
    }
}

/*----------------------------------*/

document.querySelectorAll(".reload-view").forEach(function(element) {
    element.addEventListener("click", function(e) {
        e.preventDefault();
        window.location.reload();
    });
});

async function reloadView(url){
    $("#loading").fadeIn("fast");
    loadView(url, false);
}

/*----------------------------------*/

document.querySelectorAll(".load-view").forEach(function(element) {
    element.addEventListener("click", function(e) {
        e.preventDefault();

        let module = this.getAttribute("module");
        let urlFinal = this.getAttribute("href");
        let urlCurrent = window.location.pathname;

        if (this.closest(".offcanvas")) {
            document.querySelector('.navbar-toggler[data-bs-target="#offcanvas"]').click();
        }

        if (urlFinal !== urlCurrent) {
            $("#loading").fadeIn("fast");
            document.body.setAttribute("module", module);
            loadView(urlFinal);
            historyMenu(this);
        }
    });
});

async function loadView(url, history=true, view=true){
    await loadViewData(url, view).then((response) => {
        if (view) {
            $("#loading").fadeOut("slow");
            if (response.success) {
                document.getElementById("content").innerHTML = response.content;
            } else {
                document.getElementById("content").innerHTML = htmlViewError(response);
                document.title = response.errorTitle;
            }
        } else {
            if (response.success) {
                $("#loading").fadeOut("slow")
                document.documentElement.innerHTML = '';
                document.write('<meta http-equiv="refresh" content="0">');
            } else {
                window.location.href = this.action;
            }
        }

        if (history) {
            window.history.pushState({ 
                load: true, 
                page: url 
            }, '', url);
        }
    }); 
}

function loadViewData(url, view=true){
    return new Promise(response => {
        const data = {
            view: view
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: "html",
            timeout: 5000,
            async: true,
            success: function (resp) {
                response({
                    "success": true,
                    "content": resp
                });
            },
            error(xhr){
                console.error('load view error: ', xhr.status);
                let errorResponse = {
                    "success": false,
                    "errorCode": xhr.status > 0 ? xhr.status : "000",
                    "errorTitle": LANGUAGE.error.title.replace('[[CODE]]', xhr.status > 0 ? xhr.status : "000"),
                    "errorMessage": LANGUAGE.error[xhr.status] ?? LANGUAGE.error.default,
                };
                if (xhr.status === 401) {
                    const errorTitle = decodeURIComponent(escape(xhr.getResponseHeader('Error-Title')));
                    const errorMessage = decodeURIComponent(escape(xhr.getResponseHeader('Error-Message')));
                    const errorRedirect = decodeURIComponent(escape(xhr.getResponseHeader('Error-Redirect')));
                    if (errorTitle && errorMessage) {
                        showToast(TypeToast.danger, errorTitle, errorMessage);
                        if (errorRedirect) {
                            $("#loading").fadeOut("slow");
                            setTimeout(() => window.location.href = errorRedirect, 2000);
                        } else {
                            response(errorResponse);
                        }
                    } else {
                        response(errorResponse);
                    }
                } else {
                    response(errorResponse);
                }
            }
        });
    });
}

// // HTML VIEW ERROR  ---------------------------------------------------------------------

function htmlViewError(response){
    return `<div class="position-fixed top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
        <span class="my-2 text-danger">
            <i class="bi-exclamation-triangle-fill" style="font-size:70px;"></i>
        </span>
        <p class="fw-bold fs-1">${response.errorTitle}</p>
        <p class="text-center">${response.errorMessage}</p>
    </div>`;
}

// HTML TOASTS ---------------------------------------------------------------------

class TypeToast {
	static info = "info";
	static danger = "danger";
	static success = "success";
	static warning = "warning";
}

function htmlToastContainer($toasts){
    return `<div id="toastContainer" class="toast-container position-absolute top-0 end-0">
        ${$toasts}
    </div>`;
}

function htmlToast(type, message){
    return `<div class="toast custom-toast hide rounded ${type}" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-transparent">
            <strong class="title"><i class="bi"></i>${LANGUAGE.toast[type]}</strong>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">${message}</div>
    </div>`;
}

function showToast(type, message) {
    let toast = htmlToast(type, message);
    let toastContainer = document.getElementById('toastContainer');

    if (toastContainer) {
        toastContainer.insertAdjacentHTML('beforeend', toast);
    } else {
        document.body.insertAdjacentHTML('beforeend', htmlToastContainer(toast));
        document.querySelectorAll('.custom-toast').forEach(toastEl => {
            toastEl.addEventListener('hidden.bs.toast', function () {
                toastEl.remove();
            });
        });
    }

    let lastToast = document.querySelector('.custom-toast:last-of-type');
    if (lastToast) {
        let bsToast = new bootstrap.Toast(lastToast);
        bsToast.show();
    }
}

// HTML MODALS ---------------------------------------------------------------------

function hideModal(modal) {
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) {
        bootstrapModal.hide();
    }
}

function showModal(modal) {
    const bootstrapModal = bootstrap.Modal.getInstance(modal) ?? new bootstrap.Modal(modal);
    if (bootstrapModal) {
        bootstrapModal.show();
    } 
}

//--------------------------------------

class TypeModal {
	static alert = "alert";
	static error = "error";
	static success = "success";
	static question = "question";
}

function newModal(type, message, action = null) {
    let idModal, htmlModal;
    
    switch (type) {
        case TypeModal.alert: 
            idModal = 'alertModal';
            htmlModal = htmlModalAlert(message); 
            break;

        case TypeModal.error: 
            idModal = 'errorModal';
            htmlModal = htmlModalError(message); 
            break;

        case TypeModal.success: 
            idModal = 'successModal';
            htmlModal = htmlModalSuccess(message); 
            break;

        case TypeModal.question: 
            idModal = 'questionModal';
            htmlModal = htmlModalQuestion(message); 
            break;

        default:
            console.warn("Invalid tipe modal: ", type);
            return;
    } 
    
    document.body.insertAdjacentHTML("beforeend", htmlModal);

    if (typeof action === "function") {
        const actionButton = document.querySelector(`#${idModal} button.button-modal-action`);
        if (actionButton) {
            actionButton.addEventListener("click", () => {
                try {
                    action();
                } catch (error) {
                    console.error("Action modal error: ", error);
                }
            });
        }
    }

    const modal = document.getElementById(idModal);
    modal.addEventListener("hidden.bs.modal", (e) => {
        e.preventDefault();
        modal.remove();
    });

    setTimeout(() => {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }, 100);
}

function htmlModalAlert(message){
    return `
    <div id="alertModal" class="modal fade alert-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center px-3 pb-4 pt-3">
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <button type="button" class="form-control submit border-0 shadow-none p-0" data-bs-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor">
                            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#x-lg"/>
                        </svg>
                    </button>
                </div>
                <div class="display-2 text-warning opacity-75">
                    <i class="bi-exclamation-triangle"></i>
                </div>
                <div class="text fw-bold text-secondary mt-1">${message}</div>
                <div class="w100 border-secondary border-top opacity-25 my-3"></div>
                <div class="buttons">
                    <button type="button" class="button-modal-dismiss btn btn-sm btn-secondary opacity-75" data-bs-dismiss="modal" style="width:90px;">${LANGUAGE.modal.buttonClose}</button>
                </div>
            </div>
        </div>
    </div>
    `;
}

function htmlModalError(message){
    return `
    <div id="errorModal" class="modal fade error-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center px-3 pb-4 pt-3">
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <button type="button" class="form-control submit border-0 shadow-none p-0" data-bs-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor">
                            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#x-lg"/>
                        </svg>
                    </button>
                </div>
                <div class="display-4 text-danger">
                    <i class="bi-exclamation-triangle-fill"></i>
                </div>
                <div class="text fw-bold text-secondary mt-1">${message}</div>
                <div class="w100 border-danger border-top opacity-25 my-3"></div>
                <div class="buttons">
                    <button type="button" class="button-modal-dismiss btn btn-sm btn-secondary opacity-75 me-2" data-bs-dismiss="modal" style="width:90px;">${LANGUAGE.modal.buttonClose}</button>
                    <button type="button" class="button-modal-action btn btn-sm btn-danger" data-bs-dismiss="modal" style="width:90px;">${LANGUAGE.modal.buttonRetry}</button>
                </div>
            </div>
        </div>
    </div>
    `;
}

function htmlModalSuccess(message){
    return `
    <div id="successModal" class="modal fade success-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center px-3 pb-4 pt-3">
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <button type="button" class="form-control submit border-0 shadow-none p-0" data-bs-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor">
                            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#x-lg"/>
                        </svg>
                    </button>
                </div>
                <div class="display-4 custom-text">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="text fw-bold text-secondary mt-1">${message}</div>
                <div class="w100 border border-top opacity-25 my-3"></div>
                <div class="buttons">
                    <button type="button" class="button-modal-action btn btn-sm custom-btn" data-bs-dismiss="modal" style="width:80px;">${LANGUAGE.modal.buttonAccept}</button>
                </div>
            </div>
        </div>
    </div>
    `;
}

function htmlModalQuestion(question){
    return `
    <div id="questionModal" class="modal fade question-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center px-3 pb-4 pt-3">
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <button type="button" class="form-control submit border-0 shadow-none p-0" data-bs-dismiss="modal">
                        <svg width="20" height="20" fill="currentColor">
                            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#x-lg"/>
                        </svg>
                    </button>
                </div>
                <div class="display-4 text-danger opacity-75">
                <i class="bi bi-question-circle"></i>
                </div>
                <div class="text fw-bold text-secondary mt-1">${question}</div>
                <div class="w100 border border-top opacity-25 my-3"></div>
                <div class="buttons">
                <button type="button" class="button-modal-dismiss btn btn-sm btn-secondary opacity-75 me-3" data-bs-dismiss="modal" style="width:60px;">${LANGUAGE.modal.buttonNo}</button>
                    <button type="button" class="button-modal-action btn btn-sm btn-danger" data-bs-dismiss="modal" style="width:60px;">${LANGUAGE.modal.buttonYes}</button>
                </div>
            </div>
        </div>
    </div>
    `;
}