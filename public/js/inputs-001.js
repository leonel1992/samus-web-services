class Inputs {

    static initAll(parent = null) {
        this.initInputsUpperCase(parent);
        this.initInputsLowerCase(parent);
        this.initInputsCodeFormat(parent);
        this.initInputsKeyFormat(parent);
        this.initFormatNumber(parent);
        this.initSelects(parent);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    // FORMAT --------------------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////

    static initInputsUpperCase(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        context.querySelectorAll("input[input-case='upper']").forEach(input => {
            input.addEventListener("input", () => {
                input.value = input.value.toUpperCase();
            });
        });
    }

    static initInputsLowerCase(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        context.querySelectorAll("input[input-case='lower']").forEach(input => {
            input.addEventListener("input", () => {
                input.value = input.value.toLowerCase();
            });
        });
    }

    static initInputsCodeFormat(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        context.querySelectorAll("input[input-case='code']").forEach(input => {
            input.addEventListener("input", () => {
                input.value = input.value.replace(/[^A-Za-z0-9]/g, "").substr(0, input.maxLength).toUpperCase();
            });
        });
    }

    static initInputsKeyFormat(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        context.querySelectorAll("input[input-case='key']").forEach(input => {
            input.addEventListener("input", function() {
                const pattern = /[^A-Za-z0-9_.-]/g;
                this.value = this.value.replaceAll(" ", "-").replace(pattern, "").toLowerCase();
            });
        });
    }

    static initFormatNumber(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        context.querySelectorAll("input[format-number], input[format-percent]").forEach(input => {
            input.addEventListener('keydown', function(event) {
    
                let dec;
                let type;
    
                if (input.hasAttribute("format-number")) {
                    dec = input.getAttribute("format-number") ?? 2;
                    type = "number";
                } else {
                    dec = input.getAttribute("format-percent") ?? 2;
                    type = "percent";
                }
    
                let string = input.value;
                let posCur = Inputs.cursorPosition(input);
                let countCur = 0;
                let countPos = 0;
                let countDots = 0;
    
                // Input cursor position
                for(let i=0; i<posCur; i++) {
                    switch (type) {
                        case "percent":
                            if(string.charAt(i) !== ',' && string.charAt(i) !== '.' && string.charAt(i) !== ' ' && string.charAt(i) !== '%') {
                                countCur++;
                            } break;
    
                        default:
                            if(string.charAt(i) !== ',' && string.charAt(i) !== '.') {
                                countCur++;
                            } break;
                    }
                }
    
                // Reassign real number
                if (event.key === '.' || event.key === ',' || event.key === 'Decimal') {
                    let cad1 = string.substring(0, posCur);
                    let cad2 = string.substring(posCur, string.length);
                    cad1 = cad1.replaceAll('.', '').replaceAll(',', '');
                    cad2 = cad2.replaceAll('.', '').replaceAll(',', '');
                
                    if (cad1.length > 0 && cad2.length > 0) {
                        string = cad1.concat(',', cad2);
                    } else if (cad1.length > 0) {
                        string = cad1.concat(',');
                    } else {
                        string = '0'.concat(',', cad2);
                        countCur += 2;
                    }
                }
    
                // Convert string to currency
                string = numberFormat(string, dec);
    
                // Output value
                if(input.value.length == 1 && !(/^[0-9.,]+$/.test(input.value))) {
                    input.value = '';
                } else if (parseFloat(input.value) !== 0 && string == '0') {
                    input.value = '';
                } else {
                    if (type === 'percent') {
                        string += " %";
                    } 
                    input.value = string;
                }
    
                // Output cursor
                for(let i=0; i<posCur; i++) {
                    if((string.charAt(i) == ',' || string.charAt(i) == '.') && countCur >= countPos){
                        countDots++;
                    } else if (countCur >= countPos){
                        countPos++;
                    }
                }
    
                // Cursor selection
                if (!["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight", "Shift"].includes(event.key)) {
                    Inputs.cursorSelection(input, (countCur + countDots), (countCur + countDots));
                }
            });
    
            input.addEventListener('input', function(event) {
                let dec;
                let type;
    
                if (input.hasAttribute("format-number")) {
                    dec = input.getAttribute("format-number") ?? 2;
                    type = "number";
                } else {
                    dec = input.getAttribute("format-percent") ?? 2;
                    type = "percent";
                }
    
                let string = input.value;
                let posCur = Inputs.cursorPosition(input);
                let countCur = 0;
                let countPos = 0;
                let countDots = 0;
    
                // Input cursor position
                for(let i=0; i<posCur; i++) {
                    switch (type) {
                        case "percent":
                            if(string.charAt(i) !== ',' && string.charAt(i) !== '.' && string.charAt(i) !== ' ' && string.charAt(i) !== '%') {
                                countCur++;
                            } break;
    
                        default:
                            if(string.charAt(i) !== ',' && string.charAt(i) !== '.') {
                                countCur++;
                            } break;
                    }
                }
    
                // Convert string to currency
                string = numberFormat(string, dec);
    
                // Output value
                if(input.value.length == 1 && !(/^[0-9.,]+$/.test(input.value))) {
                    input.value = '';
                } else if (parseFloat(input.value) !== 0 && string == '0') {
                    input.value = '';
                } else {
                    if (type === 'percent') {
                        string += " %";
                    } 
                    input.value = string;
                }
    
                // Output cursor
                for(let i=0; i<posCur; i++) {
                    if((string.charAt(i) == ',' || string.charAt(i) == '.') && countCur >= countPos){
                        countDots++;
                    } else if (countCur >= countPos){
                        countPos++;
                    }
                }
    
                // Cursor selection
                if (!["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight", "Shift"].includes(event.key)) {
                    Inputs.cursorSelection(input, (countCur + countDots), (countCur + countDots));
                }
            });
        });
    }
    
    //////////////////////////////////////////////////////////////////////////////////
    // CURSOR ------------------------------------------------------------------------
    //////////////////////////////////////////////////////////////////////////////////

    static cursorPosition(input) {
        if(document.selection && typeof input.selectionStart == 'undefined') {
            let str = document.selection.createRange();

            stored_range = str.duplicate();
            stored_range.moveToElementText(input);
            stored_range.setEndPoint( 'EndToEnd', str );

            input.selectionStart = stored_range.text.length - str.text.length;
            input.selectionEnd = input.selectionStart + str.text.length;

            return input.selectionStart;
        } else {
            return input.selectionStart;
        }
    }

    static cursorSelection(input, start, end) {
        if(document.selection) {
            text = input.value;
            input.value = '';
            input.focus();

            let str = document.selection.createRange();
            input.value = text;

            str.move('character', start);
            str.moveEnd("character", end-start);
            str.select();
        } else if (typeof input.selectionStart != 'undefined') {
            input.setSelectionRange(start,end);
            input.focus();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM FILES --------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////

//     static initInputFile() {
        
//         $(".custom-file").each(function (index, element) {
//             $(this).val("");
//             Inputs.#htmlInputFile(element);
//         });

//         $(".custom-file").not('.disabled').not('[disabled]').bind('dragover', function(e){
//             e.preventDefault();
//             $(this).addClass("active");
//             $(this).removeClass("is-invalid");
//         });

//         $(".custom-file").not('.disabled').not('[disabled]').bind('dragleave', function(e){
//             e.preventDefault();
//             $(this).removeClass("active");
//         });

//         $(".custom-file").not('.disabled').not('[disabled]').bind('drop', function(e){
//             e.preventDefault();
//             let files = e.originalEvent.dataTransfer.files;
//             Inputs.#fileProcess(this, files);
//             $(this).removeClass("active");
//             $(this).removeClass("is-invalid");
//         });

//         $(".custom-file-simple").not('.disabled').not('[disabled]').click(function (e) {
//             e.preventDefault();
//             $(this).parent().find('.custom-file-input').click();
//         });

//         $(".custom-file").not('.disabled').not('[disabled]').find('.custom-file-btn').click(function (e) { 
//             e.preventDefault();
//             $(this).parents('.custom-file-container').find('.custom-file-input').click();
//         });

//         $(".custom-file").not('.disabled').not('[disabled]').find('.custom-file-delete').click(function (e) { 
//             e.preventDefault();
//             let input = $(this).parents('.custom-file');
//             Inputs.#fileDelete(input);
//         });
        
//         $('.custom-file-input').change(function () {
//             let files = this.files;
//             let input = $(this).parent().find(".custom-file");
//             $(input).removeClass("is-invalid");
//             Inputs.#fileProcess(input, files);
//         });

//     }

//     //proccess
//     static #fileProcess(input, files){
//         $.each(files, function (index, file) {
//             let fileReader = new FileReader();
//             fileReader.readAsDataURL(file);
//             fileReader.onload = function () {
//                 Inputs.#validateFile(input, file, fileReader);
//             };
//         });
//     }

//     static #fileDelete(input, item=null){
//         $(input).parent().find(".custom-file-input").val(undefined);
//         $(input).val("");

//         if (item === null) {
//             $(input).find('.custom-file-container-items').css('opacity', 1);
//             $(input).find('.custom-file-container-image').css('opacity', 0);
//             setTimeout(() => {
//                 $(input).find('.custom-file-image').find('img').attr('alt', "");
//                 $(input).find('.custom-file-image').find('img').attr('src', "");
//             }, 200);
//         } else {
//             $(item).slideUp(200);
//             setTimeout(() => {
//                 $(item).remove();
//             }, 200);
//         }
//     }

//     static async #filePrint(input, file, fileReader){
//         Inputs.#htmlInputFileView(input, file, fileReader);
//         setTimeout(() => {
//             $("#"+ $(input).val().replace('.','')).slideDown(200);
//         }, 200);
//     }

//     //upload
//     static async #fileUpload(input, file, fileReader){
//         Inputs.#fileUploadData(input, file).then( (resp) => {
//             if (resp) {
//                 if (resp.success) {
//                     Inputs.#fileUploadSuccess(input, resp);
//                     Inputs.#filePrint(input, file, fileReader);
//                 } else {
//                     Inputs.#fileUploadError(input, resp.message);
//                 }
//             } else {
//                 let message = LANGUAGE.inputFile.error.default.resp;
//                 Inputs.#fileUploadError(input, message);
//             }
//         });
//     }

//     static #fileUploadData(input, file){

//         let form = new FormData();
//         form.append("file", file);
//         form.append("type", $(input).attr("input-type"));

//         return new Promise(response => {
//             $.ajax({
//                 url: URL_LANG + "/server/files/upload",
//                 type: "POST",
//                 data: form,
//                 dataType: "json",
//                 contentType: false,
//                 processData: false,
//                 timeout: 30000,
//                 async: true,
//                 success: function (resp) {
//                     response(resp);
//                 },
//                 error(jqXHR){
//                     console.log("STATUS: ", jqXHR.status);
//                     console.log("ERROR:  ", jqXHR.responseText);
//                     response(null);
//                 }
//             });
//         });
//     }

//     static #fileUploadSuccess(input, resp){
//         $(input).val(resp.file);
//         showToast(TypeToast.success, resp.message);
//     }

//     static #fileUploadError(input, message){
//         $(input).val("");
//         $(input).parent().find(".custom-file-input").val(undefined);
//         showToast(TypeToast.danger, message);
//     }

//     //validate
//     static #validateFileAlert(input, message){
//         $(input).parent().find(".custom-file-input").val(undefined);
//         showToast(TypeToast.danger, message);
//     }

//     static #validateFile(input, file, fileReader){
        
//         let validateType = $(input).attr("input-type");
//         let validateSize = $(input).attr("validate-file-size");
//         let validateExt = $(input).attr("input-accept").split(',');
//         let regExpExt = new RegExp('('+ validateExt.join('|').replace(/\./g, '\\.') +')$');

//         if (regExpExt.test(file.name)) {
//             if (validateSize === undefined || 1000 * parseFloat(validateSize) >= file.size) {
//                 switch (validateType) {
//                     case 'image': Inputs.#validateFileImage(input, file, fileReader); break;
//                     default: Inputs.#fileUpload(input, file, fileReader);
//                 }
//             }else{
//                 let message = LANGUAGE.inputFile.error[validateType].size ?? LANGUAGE.inputFile.error.default.size;
//                 Inputs.#validateFileAlert(input, message.replace("[[SIZE]]", validateSize));
//             }
//         } else {
//             let message = LANGUAGE.inputFile.error[validateType].type ?? LANGUAGE.inputFile.error.default.type;
//             Inputs.#validateFileAlert(input, message);
//         }
//     }

//     static #validateFileImage(input, file, fileReader){
        
//         let validateEqual = $(input).attr("validate-file-equal");
//         let validateWidth = $(input).attr("validate-file-width");
//         let validateHeight = $(input).attr("validate-file-height");
        
//         let img = new Image();
//         img.src = fileReader.result;
//         img.onload = function () {
//             let boolWidth  = validateWidth!==undefined  && parseFloat(validateWidth)>=this.width ? false : true;
//             let boolHeight = validateHeight!==undefined && parseFloat(validateHeight)>=this.height ? false : true;
//             let boolEqual  = validateEqual!==undefined  && validateEqual==="true" && this.width!==this.height ? false : true;
//             if( boolWidth && boolHeight ){
//                 if(boolEqual){
//                     Inputs.#fileUpload(input, file, fileReader);
//                 }else{
//                     let message = LANGUAGE.inputFile.error.image.equal;
//                     Inputs.#validateFileAlert(input, message);
//                 }
//             }else{
//                 let message = LANGUAGE.inputFile.error.image.pixels
//                     .replace("[[WIDTH]]", validateWidth)
//                     .replace("[[HEIGHT]]", validateHeight);
//                 Inputs.#validateFileAlert(input, message);      
//             }
//         };
//     }

//     //html
//     static #htmlInputFile(input){
        
//         const inputType = $(input).attr("input-type");
//         const inputIcon = $(input).attr("input-icon");
//         const inputText = $(input).attr("input-text");
//         const inputButton = $(input).attr("input-button");
//         const inputAccept = $(input).attr("input-accept");

//         let htmlItems = `<div class="custom-file-container-items">`;
//             htmlItems += `
//                 <span class="custom-file-icon">
//                     <svg width="80" height="80" fill="currentColor">
//                         <use xlink:href="${URL_BOOTSTRAP_ICONS}#${inputIcon ?? 'camera'}"/>
//                     </svg>
//                     </span>
//                 <span class="custom-file-label-text">${inputText ?? LANGUAGE.inputFile.text}</span>
//             `;
//             if (!$(input).hasClass("custom-file-simple")) {
//                 htmlItems += `
//                     <span class="custom-file-label-o">${LANGUAGE.inputFile.or}</span>
//                     <button class="btn custom-file-btn" type="button">
//                         <span lcass="custom-file-btn-icon">
//                             <svg width="22" height="22" fill="currentColor">
//                                 <use xlink:href="${URL_BOOTSTRAP_ICONS}#upload"/>
//                             </svg>
//                         </span>
//                         <span lcass="custom-file-btn-text">${inputButton ?? LANGUAGE.inputFile.button}</span>
//                     </button>
//                 `;
//             }
//         htmlItems += `</div>`;
        
//         $(input).append(htmlItems);
//         $(input).append(`
//             <div class="custom-file-container-image">
//                 <div class="custom-file-image" >
//                     <button class="custom-file-delete" type="button"><i class="bi bi-x"></i></button>
//                     <img src="" alt="" />
//                 </div>
//             </div>
//         `);

//         $(input).replaceWith(`
//             <div class="custom-file-container">
//                 <input class="custom-file-input custom-control" type="file" accept="${inputAccept ?? inputType+'/*'}" hidden />
//                 ${ $(input).prop('outerHTML') }
//             </div>
//         `);
//     }

//     static #htmlInputFileView(input, file, fileReader){
//         if ( $(input).attr('input-replace-view') == 'true' ) {
//             $(input).find('.custom-file-image').find('img').attr('alt', file.name);
//             $(input).find('.custom-file-image').find('img').attr('src', fileReader.result);
//             setTimeout(() => {
//                 $(input).find('.custom-file-container-items').css('opacity', 0);
//                 $(input).find('.custom-file-container-image').css('opacity', 1);
//             }, 150);
//         } else {
//             $(input).parent().find('.custom-file-view').slideUp(200);
//             setTimeout(() => {
//                 $(input).parent().find('.custom-file-view').remove();
//                 $(input).parent().append(`
//                     <div id="${ $(input).val().replace('.','') }" class="custom-file-view form-control" style="display:none;">
//                         <span class="custom-file-view-icon"><img src="${fileReader.result}" alt="${file.name}" /></span>
//                         <span class="custom-file-view-name">${file.name}</span>
//                         <button class="custom-file-delete" type="button"><i class="bi bi-x"></i></button>
//                     </div>
//                 `);

//                 $(".custom-file-view").not('.disabled').not('[disabled]').find('.custom-file-delete').click(function (e) { 
//                     e.preventDefault();
//                     let item = $(this).parents('.custom-file-view');
//                     let input = $(this).parents('.custom-file-container').find('.custom-file');
//                     Inputs.#fileDelete(input, item);
//                 });
//             }, 200);
//         }
//     }

    ////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM SELECTS --------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////

    static initSelects(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        const selects = context.querySelectorAll(".custom-select");

        selects.forEach(select => {
            let optionCount = select.options.length;
            let showSearch = optionCount > 10 ? 0 : Infinity;
            
            $(select).select2({
                theme: "bootstrap-5",
                templateResult: Inputs.#templateResult,
                templateSelection: Inputs.#templateSelection,
                minimumResultsForSearch: showSearch
            });
    
            Inputs.#changeSelectWidth(select);
        });
    }
    
    static #changeSelectWidth(select) {
        setTimeout(() => {
            if (select.classList.contains("select2-hidden-accessible")) {
                document.querySelectorAll(".select2-container--bootstrap-5").forEach(el => {
                    el.style.width = "100%";
                });
            } else {
                selectWidth(select);
            }
        }, 100);
    }

    static #templateSelection(obj) { 
        if (obj.element && !obj.element.classList.contains("d-none")) {
            let text = obj.element.textContent;
            if (text) {
                return Inputs.#templateItem(obj, '19', '-1');
            }
        } else {
            if (obj.id === '' && obj.text) {
                let span = document.createElement("span");
                span.className = "select2-selection__placeholder";
                span.textContent = obj.text;
                return span;
            }
        }
    }
    
    static #templateResult(obj) {
        if (obj.element && !obj.element.classList.contains("d-none")) {
            let text = obj.element.textContent;
            if (text) {
                return Inputs.#templateItem(obj, '26', '-2');
            }
        }
    }
    
    static #templateItem(obj, iconSize, marginTop) {
        let text = obj.element.textContent;
        let imgAvatar = obj.element.getAttribute("img-avatar");
        let imgIcon = obj.element.getAttribute("img-icon");
        let svgIcon = obj.element.getAttribute("svg-icon");
    
        if (imgIcon) {
            let img = document.createElement("img");
            img.alt = "";
            img.src = imgIcon;
            img.width = iconSize;
            img.height = iconSize;
            img.style.marginRight = "8px";
            img.style.marginTop = `${marginTop}px`;
    
            let span = document.createElement("span");
            span.textContent = text;
    
            let fragment = document.createDocumentFragment();
            fragment.appendChild(img);
            fragment.appendChild(span);
            return fragment;
    
        } else if (svgIcon) {
            let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute("class", "custom-icon");
            svg.setAttribute("width", iconSize);
            svg.setAttribute("height", iconSize);
            svg.style.marginRight = "8px";
            svg.style.marginTop = `${marginTop}px`;
    
            let use = document.createElementNS("http://www.w3.org/2000/svg", "use");
            use.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", svgIcon);
    
            svg.appendChild(use);
    
            let span = document.createElement("span");
            span.textContent = text;
    
            let fragment = document.createDocumentFragment();
            fragment.appendChild(svg);
            fragment.appendChild(span);
            return fragment;
    
        } else if (imgAvatar) {
            if (obj.element.getAttribute("data-avatar")) {
                let img = document.createElement("img");
                img.classList.add("rounded-circle");
                img.src = imgAvatar;
                img.alt = "";
                img.width = iconSize;
                img.height = iconSize;
                img.style.marginRight = "8px";
                img.style.marginTop = `${marginTop}px`;
    
                let span = document.createElement("span");
                span.textContent = text;
    
                let fragment = document.createDocumentFragment();
                fragment.appendChild(img);
                fragment.appendChild(span);
                return fragment;
    
            } else {
                let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("class", "bi text-secondary opacity-75");
                svg.setAttribute("width", iconSize);
                svg.setAttribute("height", iconSize);
                svg.setAttribute("fill", "currentColor");
                svg.style.marginRight = "8px";
                svg.style.marginTop = `${marginTop}px`;
    
                let use = document.createElementNS("http://www.w3.org/2000/svg", "use");
                use.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", `${URL_PATH}/assets/icons/bootstrap.svg#person-circle`);
    
                svg.appendChild(use);
    
                let span = document.createElement("span");
                span.classList.add("avatar");
                span.textContent = text;
    
                let fragment = document.createDocumentFragment();
                fragment.appendChild(svg);
                fragment.appendChild(span);
                return fragment;
            }
        } else {
            let span = document.createElement("span");
            span.textContent = text;
            return span;
        }
    }
    
}