class Forms {

    // INPUT FORM LABEL --------------------------------------------------------------------------

    static initInputLabel(){
        $(".input-group-label").find(".form-control").on( "focus", function() {
            $(this).parent().addClass("focused");
        }).on( "focusout", function() {
            $(this).parent().removeClass("focused");
        });

        $(".input-group-label").find(".select2-selection").on( "focus focusout", function() {
            setTimeout(() => {
                $(this).parents(".input-group-label").removeClass("focused");
                if ( $(this).parents(".select2-container").hasClass("select2-container--focus") || $(this).parents(".select2-container").hasClass("select2-container--open") ) {
                    $(this).parents(".input-group-label").addClass("focused");
                }
            }, 100);
        });

        $(".input-group-label").find(".form-control").on('input',function () { 
            Forms.changeInputLabel(this);
        }).change(function () { 
            Forms.changeInputLabel(this);
        });

        $(".input-group-label").find(".form-control").each(function () {
            if ( !$(this).val() ) {
                $(this).parent().addClass("empty");
            }
        }); 
    }

    static changeInputLabel(input){
        if ( !$(input).val() ) {
            $(input).parent().addClass("empty");
        } else {
            $(input).parent().removeClass("empty");
        }
    }

    // VALIDATE --------------------------------------------------------------------------

    static initValidateForm() {
        document.querySelectorAll(".validate-form .form-control[required], .validate-form .custom-control[required]").forEach(input => {
            if (input.classList.contains("custom-datepicker")) { 
                input.addEventListener("change", function() {
                    Forms.clean(this);
                });
            }else if (input.tagName === "SELECT") {
                input.addEventListener("change", function() {
                    Forms.clean(this);
                });
                if (input.classList.contains("custom-select")) {
                    $(input).on("select2:select", function() {
                        Forms.clean(this);
                    });
                }
            } else if (input.type === "checkbox" || input.type === "radio") {
                input.addEventListener("change", function() {
                    Forms.clean(this);
                });
            } else {
                input.addEventListener("input", function() {
                    Forms.clean(this);
                });
            }
        });
    }
    
    static clean(element) {
        if (typeof element === "string") {
            element = document.querySelector(element);
            if (!element) return false;
        }
    
        if (!(element instanceof HTMLElement)) {
            return false;
        }
        
        element.classList.remove("is-invalid");
        element.closest('.input-group')?.classList.remove("is-invalid");
        element.closest('.input-group-label')?.classList.remove("is-invalid");
    }
    
    static cleanAll() {
        document.querySelectorAll(".validate-form [required]").forEach(element => {
            Forms.clean(element);
        }); 
    }

    static validateAll() {
        let valid = true;
        document.querySelectorAll(".validate-form [required]").forEach(element => {
            if (!Forms.validate(element)) {
                valid = false;
            }
        }); 
        
        return valid;
    }
    
    static validate(element) {

        if (typeof element === "string") {
            element = document.querySelector(element);
            if (!element) return false;
        }
    
        if (!(element instanceof HTMLElement)) {
            return false;
        }

        let isValid = true;
        if (element.hasAttribute("required") && !element.hasAttribute("disabled")) {
            
            let value = element.value?.trim();
            let validateValue  = element.getAttribute("validate-value");
            let validateCheck  = element.getAttribute("validate-check");
            let validateAge    = element.getAttribute("validate-age");
            let validateNumber = element.getAttribute("validate-number");
            let validateName   = element.getAttribute("validate-name");
            let validateEmail  = element.getAttribute("validate-email");
            let validatePhone  = element.getAttribute("validate-phone");
            let validatePass   = element.getAttribute("validate-password");
            let validateEqual  = element.getAttribute("validate-equal");
            let validateLength = element.getAttribute("validate-length");
    
            let boolValue  = validateValue === null  || validateValue === 'false'  ? true : Forms.validateValue(value);
            let boolCheck      = validateCheck  === null || validateCheck === 'false'  ? true : Forms.validateCheck(element);
            let boolNumber = validateNumber === null || validateNumber === 'false' ? true : Forms.validateNumber(value);
            let boolName   = validateName === null   || validateName === 'false'   ? true : Forms.validateName(value);
            let boolEmail  = validateEmail === null  || validateEmail === 'false'  ? true : Forms.validateEmail(value);
            let boolPhone  = validatePhone === null  || validatePhone === 'false'  ? true : Forms.validatePhone(value);
            let boolPass   = validatePass === null   || validatePass === 'false'   ? true : Forms.validatePassword(value);

            let boolEqual      = validateEqual === null ? true : Forms.validateEqual(value, validateEqual);
            let boolLength     = validateLength === null ? true : Forms.validateLength(value, validateLength);
            let boolAge    = validateAge === null ? true : Forms.validateAge(value, validateAge);

            if (!boolValue || !boolCheck || !boolNumber || !boolName || !boolEmail || !boolPhone || !boolPass || !boolEqual || !boolLength || !boolAge) {
                isValid = false;
                element.value = value;
                element.classList.add("is-invalid");
    
                let parentGroup = element.closest(".input-group");
                if (parentGroup) parentGroup.classList.add("is-invalid");
    
                let parentLabel = element.closest(".input-group-label");
                if (parentLabel) parentLabel.classList.add("is-invalid");
    
                try {
                    let contentDiv = document.querySelector(".scrollable");
                    let elementDiv = document.querySelector(".is-invalid");
    
                    if (contentDiv && elementDiv) {
                        let scrollTop = elementDiv.getBoundingClientRect().top - contentDiv.getBoundingClientRect().top + contentDiv.scrollTop;
                        contentDiv.scrollTo({ top: scrollTop - 20, behavior: "smooth" });
                    }
                } catch (error) {}
            }
        } 
        
        return isValid;
    }
    
    // VALIDATE TYPES --------------------------------------------------------------------------

    static validateValue(value) {
        return value!=="" && value!==undefined && value!==null;
    }

    static validateCheck(element) {
        return element.checked;
    }
    
    static validateAge(value, minAge) {
        if (!value) return false;
        try {
            let now = new Date();
            let data = value.split('/');
            let age = now.getFullYear() - parseInt(data[0]);
            let m = now.getMonth() -  parseInt(data[1]);
            let d = now.getDate() - parseInt(data[2]);
            if (m < 0 || (m === 0 && d < 0)) {
                age--;
            } return (minAge <= age);
        } catch (_) {
            return false;
        }
    }

    static validateNumber(value) {
        let pattern = /^[0-9]$/;
        return pattern.test(value);
    }

    static validatePhone(value) {
        let pattern = /^[0-9]{10,}$/;
        return pattern.test(value);
    }

    static validateName(value) {
        let pattern = /^[a-zA-Z äëïöüáéíóúâêîôûàèìòùñÄËÏÖÜÁÉÍÓÚÂÊÎÔÛÀÈÌÒÙÑ]{2,50}$/;
        return pattern.test(value);
    }

    static validateEmail(value) {
        let pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,253}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,253}[a-zA-Z0-9])?)*$/;
        return pattern.test(value);
    }

    static validatePassword(value) {
        let pattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[ \°\|\¡\!\¿\?\@\#\$\%\&\(\)\{\}\[\]\<\>\\\/\^\*\~\-\+\_\.\,\:\;\=\'\"\`]).{8,20}$/;
        return pattern.test(value);
    }

    static validateEqual(value, element) {
        return value === document.querySelector(element).value?.trim();
    }
    
    static validateLength(value, length) {
        return (parseInt(length) <= value.toString().length);
    }
}