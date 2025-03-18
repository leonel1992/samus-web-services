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
            } else if (input.tagName === "SELECT") {
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

        let current = element;
        while (current) {
            current.classList.remove('is-invalid');
            if ([...current.classList].some(cls => cls === 'input-group' || cls.startsWith('input-group-'))) {
                break;
            } current = current.parentElement;
        }
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
            
            const value = element.value?.trim();
            const validateValue  = element.getAttribute("validate-value");
            const validateCheck  = element.getAttribute("validate-check");
            const validateAge    = element.getAttribute("validate-age");
            const validateNumber = element.getAttribute("validate-number");
            const validateName   = element.getAttribute("validate-name");
            const validateEmail  = element.getAttribute("validate-email");
            const validatePhone  = element.getAttribute("validate-phone");
            const validatePass   = element.getAttribute("validate-password");
            const validateFile   = element.getAttribute("validate-file");
            const validatePrefix = element.getAttribute("validate-prefix");

            const validateEqual  = element.getAttribute("validate-equal");
            const validateLength = element.getAttribute("validate-length");
    
            const boolValue  = validateValue === null  || validateValue === 'false'  ? true : Forms.validateValue(value);
            const boolCheck      = validateCheck  === null || validateCheck === 'false'  ? true : Forms.validateCheck(element);
            const boolNumber = validateNumber === null || validateNumber === 'false' ? true : Forms.validateNumber(value);
            const boolName   = validateName === null   || validateName === 'false'   ? true : Forms.validateName(value);
            const boolEmail  = validateEmail === null  || validateEmail === 'false'  ? true : Forms.validateEmail(value);
            const boolPhone  = validatePhone === null  || validatePhone === 'false'  ? true : Forms.validatePhone(value);
            const boolPass   = validatePass === null   || validatePass === 'false'   ? true : Forms.validatePassword(value);
            const boolFile   = validateFile === null   || validateFile === 'false'   ? true : Forms.validateFile(element);
            const boolPrefix = validatePrefix === null || validatePrefix === 'false' ? true : Forms.validatePrefix(value);

            const boolEqual  = validateEqual === null ? true : Forms.validateEqual(value, validateEqual);
            const boolLength = validateLength === null ? true : Forms.validateLength(value, validateLength);
            const boolAge    = validateAge === null ? true : Forms.validateAge(value, validateAge);

            if (!boolValue || !boolCheck || !boolNumber || !boolName || !boolEmail || !boolPhone || !boolPass || !boolFile || !boolPrefix || !boolEqual || !boolLength || !boolAge) {
                isValid = false;
                element.value = value;
    
                let current = element;
                while (current) {
                    current.classList.add('is-invalid');
                    if ([...current.classList].some(cls => cls === 'input-group' || cls.startsWith('input-group-'))) {
                        break;
                    } current = current.parentElement;
                }

                try {
                    const contentDiv = document.querySelector(".scrollable");
                    const input = document.querySelector(".is-invalid");
                    if (contentDiv && input) {
                        const inputRect = input.getBoundingClientRect();
                        const contentRect = contentDiv.getBoundingClientRect();
                        const offset = inputRect.top - contentRect.top + contentDiv.scrollTop;
                        contentDiv.scrollTo({
                            top: offset - 60,
                            behavior: "smooth"
                        });
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

    static validateFile(element) {
        let value = element?.dataset.value;
        return value !== '' && value !== null && value !== undefined;
    }

    static validateEqual(value, element) {
        return value === document.querySelector(element).value?.trim();
    }
    
    static validateLength(value, length) {
        return (parseInt(length) <= value.toString().length);
    }

    static validatePrefix(value) {
        return (parseInt(value.replace('+', '')) > 0);
    }
}