class Inputs {

    static initAll(parent = null) {
        this.initInputsUpperCase(parent);
        this.initInputsLowerCase(parent);
        this.initInputsCodeFormat(parent);
        this.initInputsKeyFormat(parent);
        this.initInputsPrefixFormat(parent);
        this.initInputsUserCodeFormat(parent);
        this.initInputsFormatNumber(parent);

        this.initInputsPassword(parent);
        this.initInputsDatepicker(parent);
        this.initInputsFile(parent);
        this.initSelects(parent);
    }  

    static getContext(parent = null) {
        if (typeof parent === 'string') {
            return document.querySelector(parent);
        } else if (parent instanceof Element) {
            return parent;
        } else {
            return document;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    // FORMAT --------------------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////

    static initInputsUpperCase(parent = null) {
        const context = Inputs.getContext(parent);
        context.querySelectorAll("input[input-case='upper']").forEach(input => {
            input.addEventListener("input", () => {
                input.value = input.value.toUpperCase();
            });
        });
    }

    static initInputsLowerCase(parent = null) {
        const context = Inputs.getContext(parent);
        context.querySelectorAll("input[input-case='lower']").forEach(input => {
            input.addEventListener("input", () => {
                input.value = input.value.toLowerCase();
            });
        });
    }

    static initInputsCodeFormat(parent = null) {
        const context = Inputs.getContext(parent);
        context.querySelectorAll("input[input-case='code']").forEach(input => {
            input.addEventListener("input", () => {
                input.value = input.value.replace(/[^A-Za-z0-9]/g, "").substr(0, input.maxLength).toUpperCase();
            });
        });
    }

    static initInputsKeyFormat(parent = null) {
        const context = Inputs.getContext(parent);
        context.querySelectorAll("input[input-case='key']").forEach(input => {
            input.addEventListener("input", function() {
                const pattern = /[^A-Za-z0-9_.-]/g;
                input.value = input.value.replaceAll(" ", "-").replace(pattern, "").toLowerCase();
            });
        });
    }    
    
    static initInputsPrefixFormat(parent = null) {
        const context = Inputs.getContext(parent);
        context.querySelectorAll("input[input-case='prefix']").forEach(input => {
            input.addEventListener("keyup", function() {
                const pattern = /[^0-9+]/g;
                let inputValue = input.value.replace(pattern, "");
                
                if (!inputValue.startsWith("+")) {
                    inputValue = "+" + inputValue.replace(/\+/g, "");
                } else {
                    inputValue = "+" + inputValue.slice(1).replace(/\+/g, "");
                }
        
                input.value = inputValue.substr(0, input.getAttribute('maxlength'));
            });
        });
    }
    
    static initInputsUserCodeFormat(parent = null) {
        const context = Inputs.getContext(parent);
        context.querySelectorAll("input[input-case='user-code']").forEach(input => {
            input.addEventListener("keyup", function() {
                input.value = input.value.replace(/[^0-9]/g, "").substr(0, 4);
            });
        });
    }

    static initInputsFormatNumber(parent = null) {
        const context = Inputs.getContext(parent);
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

    /////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM PASSWORD --------------------------------------------------------------------------
    /////////////////////////////////////////////////////////////////////////////////////////////

    static initInputsPassword(parent = null) {
        const context = Inputs.getContext(parent);

        const htmlHide = `<svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="viewpass password-hide">
            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#eye-slash">
        </svg>`;

        const htmlShow = `<svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="viewpass password-show">
            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#eye">
        </svg>`;

        context.querySelectorAll(".custom-password-icon").forEach(icon => {
            icon.remove();
        });

        context.querySelectorAll(".custom-password").forEach(element => {

            const id = element.getAttribute("id");
            element.classList.add("border-end-0");

            const a = document.createElement("a");
            a.classList.add("custom-password-btn");
            a.setAttribute("role", "button");
            a.setAttribute("show", "false");
            a.setAttribute("for", id);
            a.innerHTML = htmlHide;

            const span = document.createElement("span");
            span.classList.add("input-group-text", "custom-password-icon");
            span.appendChild(a);
        
            element.parentNode.appendChild(span);
        });

        context.querySelectorAll(".custom-password-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                const show = btn.getAttribute("show");
                const inputId = btn.getAttribute("for");
                const input = document.getElementById(inputId);

                if (show === 'false') {
                    input.setAttribute("type", "text");
                    btn.setAttribute("show", "true");
                    btn.innerHTML = htmlShow;
                } else {
                    input.setAttribute("type", "password");
                    btn.setAttribute("show", "false");
                    btn.innerHTML = htmlHide;
                }
            });
        });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM DATE PICKER --------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////

    static initInputsDatepicker(parent = null) {
        const context = Inputs.getContext(parent);
        
        document.addEventListener('click', function(event) {
            document.querySelectorAll('.datepicker-popup').forEach(calendar => {
                if (!calendar.parentElement.contains(event.target)) {
                    $(calendar).fadeOut(200, function() {
                        calendar.remove();
                    });
                }
            });
        });
        
        context.querySelectorAll('.custom-datepicker').forEach(datepicker => {
            if (datepicker.querySelector('input')) return; 

            let input = document.createElement('input');
            input.type = 'text';
            input.placeholder = datepicker.getAttribute('placeholder') || '';
            input.addEventListener('input', () => Inputs.formatDatepicker(input));

            let icon = document.createElement('span');
            icon.innerHTML = '<i class="bi bi-calendar2"></i>';
            icon.classList.add('datepicker-icon');
            icon.addEventListener('click', (event) => {
                event.stopPropagation();
                let calendar = Inputs.appendNewCalendar(datepicker);
                Inputs.generateCalendarDates(calendar);
            });

            datepicker.appendChild(input);
            datepicker.appendChild(icon);
            Inputs.createDatepickerMethods(datepicker);
        });
    }

    static createDatepickerMethods(datepicker) {
        let input = datepicker.querySelector('input');
        if (!Object.getOwnPropertyDescriptor(datepicker, 'value')) {
            Object.defineProperty(datepicker, 'value', {
                get: function() {
                    let val = getLocaleDate(input.value);
                    return val ? `${val.year}/${val.month + 1}/${val.day}` : undefined;
                },
                set: function(newValue) {
                    let val = '';
                    if (newValue) {
                        let data = newValue.split("/");
                        val = setLocaleDate(data[2], data[1] - 1, data[0]);
                    }
                    
                    this._value = val;
                    input.value = val;
                }
            });
        }
    }

    static formatDatepicker(input) {
        let value = input.value?.replace(/[^0-9/]/g, '')?.replace(/\/+/g, '/');
        if (value) {
            switch (LANG) {
                case 'en': // Formato MM/DD/YYYY
                case 'es': // Formato DD/MM/YYYY
                    if (value.length >= 2 && value.charAt(2) !== '/') {
                        value = value.substring(0, 2) + '/' + value.substring(2);
                    }
                    if (value.length >= 5 && value.charAt(5) !== '/') {
                        value = value.substring(0, 5) + '/' + value.substring(5, 9);
                    } break;
                
                default: // Formato YYYY/MM/DD
                    if (value.length >= 4 && value.charAt(4) !== '/') {
                        value = value.substring(0, 4) + '/' + value.substring(4);
                    }
                    if (value.length >= 7 && value.charAt(7) !== '/') {
                        value = value.substring(0, 7) + '/' + value.substring(7, 10);
                    } break;
            } 
            
            if (value.length > 10) {
                value = value.substring(0, 10);
            } input.value = value;
        }
    }

    static getDatepickerLimit(datepicker, limit) {
        let attr = datepicker.getAttribute('date-'+ limit)  // formato YYYY/MM/DD;
        let date = attr ? new Date(attr.replace(/\//g, '-')) : null;
        return date;
    }

    static appendNewCalendar(datepicker) {
        let calendar = document.createElement('div');
        calendar.classList.add('datepicker-popup');
        datepicker.appendChild(calendar);
        return calendar;
    }
    
    // ---------------------------------------------------------------------

    static generateCalendarDates(calendar, currentDate = null) {
  
        // Límites del calendario
        let datepicker = calendar.closest('.custom-datepicker');
        let minDate = Inputs.getDatepickerLimit(datepicker, 'min');
        let maxDate = Inputs.getDatepickerLimit(datepicker, 'max');

        let inputValue = datepicker.querySelector('input').value;
        let inputDate = getLocaleDate(inputValue);
        let selectedDate = inputDate ? new Date(inputDate.year, inputDate.month, inputDate.day) : null;
        let todayDate = new Date();

        // Mes del calendario
        let currentYear;
        let currentMonth;
        if (currentDate !== null) {
            currentYear = currentDate.getFullYear();
            currentMonth = currentDate.getMonth();
        } else if (selectedDate !== null) {
            currentYear = selectedDate.getFullYear();
            currentMonth = selectedDate.getMonth();
        } else {
            let today = new Date();
            currentYear = today.getFullYear();
            currentMonth = today.getMonth();
        }

        // Generar calendario
        let formattedMonth = new Date(0, currentMonth).toLocaleString(LANG, { month: 'long' });
        formattedMonth = formattedMonth.charAt(0).toUpperCase() + formattedMonth.slice(1).toLowerCase();
        
        let html = `<div class='calendar-navigation'>
            <i class='bi bi-chevron-left datepicker-prev-month'></i>
            <div class='datepicker-select datepicker-select-month'>
                <span class='datepicker-month-label' data-month="${currentMonth}">${formattedMonth}</span> - 
                <span class='datepicker-year-label' data-year="${currentYear}">${currentYear}</span>
            </div>
            <i class='bi bi-chevron-right datepicker-next-month'></i>
        </div>`;
        
        // Determinar dias del mes
        let days = LANGUAGE.calendar.days;
        let monthDays = new Date(currentYear, currentMonth + 1, 0).getDate();
        let firstDay = new Date(currentYear, currentMonth, 1).getDay();
        let prevDays = new Date(currentYear, currentMonth, 0).getDate();
        
        // Abrir dias del calendario
        html += `<table class='dates-grid'><tr>${days.map(day => `<th>${day}</th>`).join('')}</tr><tr>`;
        
        // Días del mes anterior
        for (let day = firstDay - 1; day >= 0; day--) {
            let date = new Date(currentYear, currentMonth - 1, prevDays - day);
            html += Inputs.htmlItemCalendarDates(date, todayDate, minDate, maxDate, selectedDate, true);
        }
        
        // Días del mes actual
        for (let day = 1; day <= monthDays; day++) {
            let date = new Date(currentYear, currentMonth, day);
            html += Inputs.htmlItemCalendarDates(date, todayDate, minDate, maxDate, selectedDate, false);
            if ((day + firstDay) % 7 === 0) {
                html += `</tr><tr>`;
            }
        }
        
        // Días del mes siguiente
        let totalCells = monthDays + firstDay;
        let remainingCells = 42 - totalCells; 
        if (remainingCells > 0) {
            for (let day = 1; day <= remainingCells; day++) {
                let date = new Date(currentYear, currentMonth + 1, day);
                html += Inputs.htmlItemCalendarDates(date, todayDate, minDate, maxDate, selectedDate, true);
                if ((totalCells + day) % 7 === 0) {
                    html += `</tr><tr>`;
                }
            }
        }
        
        // Cerrar dias del mes
        html += `</tr></table>`;

        // Iniciar calendario
        calendar.innerHTML = html;
        Inputs.selectionCalendarDatesEvents(calendar);
        Inputs.navigationCalendarDatesEvents(calendar);
        $(calendar).fadeIn(200);
    }

    static htmlItemCalendarDates(date, todayDate, minDate, maxDate, selectedDate, isFaded) {

        const isSameDate = (d1, d2) => 
            d1.getFullYear() === d2.getFullYear() &&
            d1.getMonth() === d2.getMonth() &&
            d1.getDate() === d2.getDate();

        let formattedDate = setLocaleDate(date.getDate(), date.getMonth() + 1, date.getFullYear());
        let classDisabled = (minDate && date < minDate) || (maxDate && date > maxDate) ? 'disabled-date' : 'selectable-date';
        let classSelected = selectedDate && isSameDate(selectedDate, date) ? 'selected-date ' : '';
        let classToday = todayDate && isSameDate(todayDate, date) ? 'today-date ' : '';
        let classFaded = isFaded ? 'faded-date ' : '';

        return `<td class='date-item ${classFaded}${classToday}${classSelected}${classDisabled}' data-date='${formattedDate}'>
            <label>${date.getDate()}</label>
        </td>`;
    }

    static selectionCalendarDatesEvents(calendar) {
        let parent = calendar.closest('.custom-datepicker');
        let input = parent.querySelector('input');
        calendar.querySelectorAll('.date-item').forEach(cell => {
            cell.addEventListener('click', function() {
                let selectedDate = this.getAttribute('data-date');
                input.value = selectedDate;
                
                let eventChange = new Event('change', { bubbles: true });
                input.dispatchEvent(eventChange);

                $(calendar).fadeOut(200, function() {
                    calendar.remove();
                });
            });
        });
    }

    static navigationCalendarDatesEvents(calendar) {
        calendar.querySelector('.datepicker-prev-month').addEventListener('click', (e) => {
            e.stopPropagation();
            Inputs.navigationCalendarDates(calendar, 'prev');
        });
    
        calendar.querySelector('.datepicker-next-month').addEventListener('click', (e) => {
            e.stopPropagation();
            Inputs.navigationCalendarDates(calendar, 'next');
        });

        calendar.querySelector('.datepicker-select-month').addEventListener('click', (e) => {
            e.stopPropagation();
            let datepicker = calendar.closest('.custom-datepicker');
            let labelYear = calendar.querySelector('.datepicker-year-label');
            let currentYear = parseInt(labelYear.getAttribute('data-year'));
            let newCalendar = Inputs.appendNewCalendar(datepicker);
            Inputs.generateCalendarMonths(newCalendar, currentYear);
            $(calendar).fadeOut(200);
        });
    }

    static navigationCalendarDates(calendar, direction) {
        
        // Obtener el mes y año actual
        let monthLabel = calendar.querySelector('.datepicker-month-label');
        let labelYear = calendar.querySelector('.datepicker-year-label');

        let currentMonth = parseInt(monthLabel.getAttribute('data-month'));
        let currentYear = parseInt(labelYear.getAttribute('data-year'));

        // Calcular el nuevo mes y año
        let newMonth, newYear;
        if (direction === 'prev') {
            newMonth = currentMonth - 1;
            if (newMonth < 0) {
                newMonth = 11;
                newYear = currentYear - 1;
            } else {
                newYear = currentYear;
            }
        } else if (direction === 'next') {
            newMonth = currentMonth + 1;
            if (newMonth > 11) {
                newMonth = 0;
                newYear = currentYear + 1;
            } else {
                newYear = currentYear;
            }
        }
    
        // Regenerar el calendario con el nuevo mes y año
        Inputs.generateCalendarDates(calendar, new Date(newYear, newMonth));
    }

    // ---------------------------------------------------------------------

    static generateCalendarMonths(calendar, currentYear) {

        // Límites del calendario
        let now = new Date();
        let nowMonth = now.getMonth();
        let nowYear = now.getFullYear();

        let datepicker = calendar.closest('.custom-datepicker');
        let minDate = Inputs.getDatepickerLimit(datepicker, 'min');
        let maxDate = Inputs.getDatepickerLimit(datepicker, 'max');
        let months = LANGUAGE.calendar.months;

        // Crear html del calendario
        let html = `<div class='calendar-navigation'>
            <i class='bi bi-chevron-left datepicker-prev-year'></i>
            <div class='datepicker-select datepicker-select-year'>
                <span class='datepicker-year-label' data-year="${currentYear}">${currentYear}</span>
            </div>
            <i class='bi bi-chevron-right datepicker-next-year'></i>
        </div>`;
        
        // Añadir los meses del calendario
        html += `<table class='months-grid'><tr>`;
        months.forEach((month, index) => {
            let date = new Date(currentYear, index);

            let disbledMin = minDate && date < new Date(minDate.getFullYear(), minDate.getMonth());
            let disbledMax = maxDate && date > new Date(maxDate.getFullYear(), maxDate.getMonth());
            let classDisabled = disbledMin || disbledMax ? 'disabled-date' : 'selectable-date';
            
            let isFadedMonth = date.getFullYear() === nowYear && index > nowMonth;
            let isFadedYear = date.getFullYear() > nowYear;
            let classFaded = isFadedMonth || isFadedYear ? 'faded-date' : '';

            html += `<td class='month-item ${classFaded} ${classDisabled}' data-month='${index}'><label>${month}</label></td>`;
            if ((index + 1) % 3 === 0 && index !== 11) {
                html += `</tr><tr>`;
            }
        });
        html += `</tr></table>`;
        
        // Generar calendario
        calendar.innerHTML = html;
        Inputs.selectionCalendarMonthsEvents(calendar);
        Inputs.navigationCalendarMonthsEvents(calendar);
        $(calendar).fadeIn(200);
    }

    static selectionCalendarMonthsEvents(calendar) {
        calendar.querySelectorAll('.month-item').forEach(cell => {
            cell.addEventListener('click', function() {
                let labelYear = calendar.querySelector('.datepicker-year-label');
                let currentYear = parseInt(labelYear.getAttribute('data-year'));
                let selectedMonth = this.getAttribute('data-month');
                let datepicker = calendar.closest('.custom-datepicker');
                let dateCalendar = datepicker.querySelectorAll('.datepicker-popup')[0];
                Inputs.generateCalendarDates(dateCalendar, new Date(currentYear, selectedMonth));
                $(calendar).fadeOut(200, function() {
                    calendar.remove();
                });
            });
        });
    }

    static navigationCalendarMonthsEvents(calendar) {
        calendar.querySelector('.datepicker-prev-year').addEventListener('click', (e) => {
            e.stopPropagation();
            Inputs.navigationCalendarMonths(calendar, 'prev');
        });
    
        calendar.querySelector('.datepicker-next-year').addEventListener('click', (e) => {
            e.stopPropagation();
            Inputs.navigationCalendarMonths(calendar, 'next');
        });

        calendar.querySelector('.datepicker-select-year').addEventListener('click', (e) => {
            e.stopPropagation();
            let datepicker = calendar.closest('.custom-datepicker');
            let newCalendar = Inputs.appendNewCalendar(datepicker);
            let labelYear = calendar.querySelector('.datepicker-year-label');
            let currentYear = parseInt(labelYear.getAttribute('data-year'));
            let startYear = currentYear - (currentYear % 16) + 1;
            Inputs.generateCalendarYears(newCalendar, startYear);
            $(calendar).fadeOut(200);
        });
    }

    static navigationCalendarMonths(calendar, direction) {
        let labelYear = calendar.querySelector('.datepicker-year-label');
        let currentYear = parseInt(labelYear.getAttribute('data-year'));
        if (direction === 'prev') {
            currentYear--;
        } else if (direction === 'next') {
            currentYear++;
        } Inputs.generateCalendarMonths(calendar, currentYear);
    }

    // ---------------------------------------------------------------------

    static generateCalendarYears(calendar, startYear) {

        // Límites del calendario
        let now = new Date();
        let nowYear = now.getFullYear();
        let endYear = startYear + 15;

        let datepicker = calendar.closest('.custom-datepicker');
        let minDate = Inputs.getDatepickerLimit(datepicker, 'min');
        let maxDate = Inputs.getDatepickerLimit(datepicker, 'max');
      
        // Crear html del calendario
        let html = `<div class='calendar-navigation'>
            <i class='bi bi-chevron-left datepicker-prev-years'></i>
            <div class='datepicker-select datepicker-select-years disabled'>
                <span class='datepicker-years-label' start-year="${startYear}">${startYear} - ${endYear}</span>
            </div>
            <i class='bi bi-chevron-right datepicker-next-years'></i>
        </div>`;
        
        // Añadir los años del calendario
        html += `<table class='years-grid'><tr>`;
        for (let index = 0; index < 16; index++) {
            let year = startYear + index;
            let disbledMin = minDate && year < minDate.getFullYear();
            let disbledMax = maxDate && year > maxDate.getFullYear();
            let classDisabled = disbledMin || disbledMax ? 'disabled-date' : 'selectable-date';
            let classFaded = year > nowYear ? 'faded-date' : '';
            html += `<td class='year-item ${classFaded} ${classDisabled}' data-year='${year}'><label>${year}</label></td>`;
            if (year % 4 === 0) {
                html += `</tr><tr>`;
            }
        }
        html += `</tr></table>`;
        
        // Generar calendario
        calendar.innerHTML = html;
        Inputs.navigationCalendarYearsEvents(calendar);
        Inputs.selectionCalendarYearsEvents(calendar);
        $(calendar).fadeIn(200);
    }

    static selectionCalendarYearsEvents(calendar) {
        calendar.querySelectorAll('.year-item').forEach(cell => {
            cell.addEventListener('click', function() {
                let selectedYear = this.getAttribute('data-year');
                let datepicker = calendar.closest('.custom-datepicker');
                let monthsCalendar = datepicker.querySelectorAll('.datepicker-popup')[1];
                Inputs.generateCalendarMonths(monthsCalendar, selectedYear);
                $(calendar).fadeOut(200, function() {
                    calendar.remove();
                });
            });
        });
    }

    static navigationCalendarYearsEvents(calendar) {
        calendar.querySelector('.datepicker-prev-years').addEventListener('click', (e) => {
            e.stopPropagation();
            Inputs.navigationCalendarYears(calendar, 'prev');
        });
    
        calendar.querySelector('.datepicker-next-years').addEventListener('click', (e) => {
            e.stopPropagation();
            Inputs.navigationCalendarYears(calendar, 'next');
        });
    }

    static navigationCalendarYears(calendar, direction) {
        let labelYear = calendar.querySelector('.datepicker-years-label');
        let startYear = parseInt(labelYear.getAttribute('start-year'));
        if (direction === 'prev') {
            startYear -= 16;
        } else if (direction === 'next') {
            startYear += 16;
        } Inputs.generateCalendarYears(calendar, startYear);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM FILES --------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////
    
    static initInputsFile(parent = null) {
        const context = Inputs.getContext(parent);

        context.querySelectorAll(".custom-file").forEach((element) => {
            Inputs.htmlInputFile(element);
        });
    
        context.querySelectorAll(".custom-file:not(.disabled):not([disabled])").forEach((element) => {
            element.addEventListener("dragover", (e) => {
                e.preventDefault();
                element.classList.add("active"); 
                try {Forms.clean(customFile);} 
                catch (_) {}
            });
    
            element.addEventListener("dragleave", (e) => {
                e.preventDefault();
                element.classList.remove("active");
            });
    
            element.addEventListener("drop", (e) => {
                e.preventDefault();
                let files = e.dataTransfer.files;
                element.classList.remove("active");
                Inputs.fileProcess(element, files);
                try {Forms.clean(customFile);} 
                catch (_) {}
            });
        });
    
        context.querySelectorAll(".custom-file-simple:not(.disabled):not([disabled])").forEach((element) => {
            element.addEventListener("click", (e) => {
                e.preventDefault();
                let input = element.parentNode.querySelector('.custom-file-input');
                if (input) input.click();
            });
        });
    
        context.querySelectorAll(".custom-file:not(.disabled):not([disabled]) .custom-file-btn").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                let container = btn.closest('.custom-file-container');
                if (container) {
                    let input = container.querySelector('.custom-file-input');
                    if (input) input.click();
                }
            });
        });
    
        context.querySelectorAll(".custom-file:not(.disabled):not([disabled]) .custom-file-delete").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                let input = btn.closest('.custom-file');
                if (input) Inputs.fileDelete(input);
            });
        });
    
        context.querySelectorAll('.custom-file-input').forEach((inputElement) => {
            inputElement.addEventListener("change", (e) => {
                let files = inputElement.files;
                let customFile = inputElement.parentNode.querySelector(".custom-file");
                Inputs.fileProcess(customFile, files);
                try {Forms.clean(customFile);} 
                catch (_) {}
            });
        });
    }

    //getters - setters
    static fileGetValue(input) { 
        return input.attr('data-value');     
    }

    static fileSetValue(input, url) {
        if (url && url !== '') {
            const name = url.split('/').pop();
            input.setAttribute("data-value", name);
            Inputs.filePrint(input, {name: name},{result: url});
        } else {
            Inputs.fileDelete(input);
        }
    }

    //proccess
    static fileProcess(input, files) { 
        Array.from(files).forEach(file => {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onload = function () {
                Inputs.validateFile(input, file, fileReader);
            };
        });        
    }
    
    static fileDelete(input, item = null) {
        const fileInput = input.parentNode.querySelector(".custom-file-input");
        if (fileInput) fileInput.value = "";
        input.setAttribute("data-value", "");
    
        if (item === null) {
            const container = input.querySelector('.custom-file-container-image');
            const items = input.querySelector('.custom-file-container-items');
            const image = input.querySelector('.custom-file-image img');
            if (container) container.style.opacity = 0;
            if (items) items.style.opacity = 1;
            setTimeout(() => {
                if (image) {
                    image.setAttribute('alt', "");
                    image.setAttribute('src', "");
                }
            }, 200);
        } else {
            item.style.transition = "all 0.2s ease";
            item.style.maxHeight = "0px";
            item.style.opacity = "0";
            setTimeout(() => {
                if (item.parentNode) item.parentNode.removeChild(item);
            }, 200);
        }
    }

    static async filePrint(input, file, fileReader) {
        Inputs.htmlInputFileView(input, file, fileReader);
        setTimeout(() => {
            const targetId = file.name.replace('.', '');
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.style.transition = "all 0.2s ease";
                targetElement.style.maxHeight = targetElement.scrollHeight + "px";
                targetElement.style.opacity = "1";
            }
        }, 200);
    }
    
    //upload
    static async fileUpload(input, file, fileReader){
        Inputs.fileUploadData(input, file).then( (resp) => {
            if (resp) {
                if (resp.success) {
                    Inputs.filePrint(input, file, fileReader);
                    Inputs.fileUploadSuccess(input, resp);
                } else {
                    Inputs.fileUploadError(input, resp.message);
                }
            } else {
                let message = LANGUAGE.inputFile.error.default.resp;
                Inputs.fileUploadError(input, message);
            }
        });
    }

    static fileUploadData(input, file){

        let form = new FormData();
        form.append("type", input.getAttribute("input-type"));
        form.append("file", file);

        return new Promise(response => {
            $.ajax({
                url: URL_LANG + "/system/files/upload",
                type: "POST",
                data: form,
                dataType: "json",
                contentType: false,
                processData: false,
                timeout: 30000,
                async: true,
                success: function (resp) {
                    response(resp);
                },
                error(jqXHR){
                    console.error("File upload status: ", jqXHR.status);
                    console.error("File upload error: ", jqXHR.responseText);
                    response(null);
                }
            });
        });
    }

    static fileUploadSuccess(input, resp) {
        input.setAttribute("data-value", resp.file);
        showToast(TypeToast.success, resp.message);
    }    

    static fileUploadError(input, message) {
        const parent = input.parentElement;
        const customFileInput = parent.querySelector(".custom-file-input");
        if (customFileInput) {
            customFileInput.value = "";
        } showToast(TypeToast.danger, message);
    }

    //validate
    static validateFileAlert(input, message) {
        const parent = input.parentElement;
        const customFileInput = parent.querySelector(".custom-file-input");
        if (customFileInput) {
            customFileInput.value = "";
        } showToast(TypeToast.danger, message);
    }

    static validateFile(input, file, fileReader){
        
        const validateType = input.getAttribute("input-type");
        const validateSize = input.getAttribute("validate-file-size");
        const validateExt = input.getAttribute("input-accept").split(',');
        const regExpExt = new RegExp('(' + validateExt.join('|').replace(/\./g, '\\.') + ')$');

        if (regExpExt.test(file.name)) {
            if (validateSize === undefined || 1000 * parseFloat(validateSize) >= file.size) {
                switch (validateType) {
                    case 'image': Inputs.validateFileImage(input, file, fileReader); break;
                    default: Inputs.fileUpload(input, file, fileReader);
                }
            }else{
                let message = LANGUAGE.inputFile.error[validateType].size ?? LANGUAGE.inputFile.error.default.size;
                Inputs.validateFileAlert(input, message.replace("[[SIZE]]", validateSize));
            }
        } else {
            let message = LANGUAGE.inputFile.error[validateType].type ?? LANGUAGE.inputFile.error.default.type;
            Inputs.validateFileAlert(input, message);
        }
    }

    static validateFileImage(input, file, fileReader){
        
        const validateEqual = input.getAttribute("validate-file-equal");
        const validateWidth = input.getAttribute("validate-file-width");
        const validateHeight = input.getAttribute("validate-file-height");

        let img = new Image();
        img.src = fileReader.result;
        img.onload = function () {
            let boolWidth  = validateWidth!==undefined  && parseFloat(validateWidth)>=this.width ? false : true;
            let boolHeight = validateHeight!==undefined && parseFloat(validateHeight)>=this.height ? false : true;
            let boolEqual  = validateEqual!==undefined  && validateEqual==="true" && this.width!==this.height ? false : true;
            if( boolWidth && boolHeight ){
                if(boolEqual){
                    Inputs.fileUpload(input, file, fileReader);
                }else{
                    let message = LANGUAGE.inputFile.error.image.equal;
                    Inputs.validateFileAlert(input, message);
                }
            }else{
                let message = LANGUAGE.inputFile.error.image.pixels
                    .replace("[[WIDTH]]", validateWidth)
                    .replace("[[HEIGHT]]", validateHeight);
                Inputs.validateFileAlert(input, message);      
            }
        };
    }

    //html
    static htmlInputFile(input){
        
        const inputType = input.getAttribute("input-type");
        const inputIcon = input.getAttribute("input-icon");
        const inputText = input.getAttribute("input-text");
        const inputButton = input.getAttribute("input-button");
        const inputAccept = input.getAttribute("input-accept");
        const inputInfoLink = input.getAttribute("input-info-link");
        
        let htmlItems = `<div class="custom-file-container-items">`;

            htmlItems += `
                <span class="custom-file-icon">
                    <svg width="80" height="80" fill="currentColor">
                        <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#${inputIcon || 'camera'}"/>
                    </svg>
                </span>
                <span class="custom-file-label-text">${inputText || LANGUAGE.inputFile.text}</span>
            `;

            if (!input.classList.contains("custom-file-simple")) {
                htmlItems += `
                    <span class="custom-file-label-o">${LANGUAGE.inputFile.or}</span>
                    <button class="btn custom-file-btn z-1" type="button">
                        <span class="custom-file-btn-icon">
                            <svg width="22" height="22" fill="currentColor">
                                <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#upload"/>
                            </svg>
                        </span>
                        <span class="custom-file-btn-text">${inputButton || LANGUAGE.inputFile.button}</span>
                    </button>
                `;
            }

            if (inputInfoLink) {
                htmlItems += `
                    <div class="custom-file-info-link z-1">
                        <a href="${inputInfoLink}" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-info-circle-fill"></i>
                        </a>
                    </div>
                `;
            }

        htmlItems += `</div>`;
        
        input.innerHTML = htmlItems;
        input.insertAdjacentHTML('beforeend', `
            <div class="custom-file-container-image">
                <div class="custom-file-image">
                    <button class="custom-file-delete" type="button"><i class="bi bi-x"></i></button>
                    <img src="" alt="" />
                </div>
            </div>
        `);
        
        input.outerHTML = `
            <div class="custom-file-container">
                <input class="custom-file-input custom-control" type="file" accept="${inputAccept || inputType + '/*'}" hidden />
                ${input.outerHTML}
            </div>
        `;
    }

    static htmlInputFileView(input, file, fileReader) {
        if (input.getAttribute('input-replace-view') === 'true') {
            const image = input.querySelector('.custom-file-image img');
            image?.setAttribute('src', fileReader.result);
            image?.setAttribute('alt', file.name);
            setTimeout(() => {
                input.querySelector('.custom-file-container-items').style.opacity = 0;
                input.querySelector('.custom-file-container-image').style.opacity = 1;
            }, 150);
        } else {
            const container = input.parentElement;
            const oldView = container.querySelector('.custom-file-view');
            if (oldView) {
                oldView.style.display = 'none';
                setTimeout(() => {
                    oldView.remove();
                    container.insertAdjacentHTML('beforeend', `
                        <div id="${ $(input).val().replace('.','') }" class="custom-file-view form-control" style="display:none;">
                            <span class="custom-file-view-icon"><img src="${fileReader.result}" alt="${file.name}" /></span>
                            <span class="custom-file-view-name">${file.name}</span>
                            <button class="custom-file-delete" type="button"><i class="bi bi-x"></i></button>
                        </div>
                    `);

                    container.querySelectorAll('.custom-file-view:not(.disabled):not([disabled])').forEach(view => {
                        view.querySelector('.custom-file-delete')?.addEventListener('click', function (e) {
                            e.preventDefault();
                            Inputs.fileDelete(input, view);
                        });
                    });
                }, 200);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM SELECTS --------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////

    static initSelects(parent = null) {
        const context = Inputs.getContext(parent);
        context.querySelectorAll(".custom-select").forEach(select => {
            let visibleOptions = Array.from(select.options).filter(option => !option.classList.contains("d-none"));
            let optionCount = visibleOptions.length;
            let showSearch = optionCount > 10 ? 0 : Infinity;

            $(select).select2({
                theme: "bootstrap-5",
                templateResult: Inputs.templateResult,
                templateSelection: Inputs.templateSelection,
                minimumResultsForSearch: showSearch,
                allowClear: true
            });
    
            Inputs.changeSelectWidth(select);
        });
    }
    
    static changeSelectWidth(select) {
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

    static templateSelection(obj) { 
        if (obj.element && !obj.element.classList.contains("d-none")) {
            let text = obj.element.textContent;
            if (text) {
                return Inputs.templateItem(obj, 'selection', '19', '-1');
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
    
    static templateResult(obj) {
        if (obj.element && !obj.element.classList.contains("d-none")) {
            let text = obj.element.textContent;
            if (text) {
                return Inputs.templateItem(obj, 'result', '26', '-2');
            }
        }
    }
    
    static templateItem(obj, type, iconSize, marginTop) {

        let element = obj.element;
        let text = element.textContent;
        let subtitle = element.getAttribute('subtitle');
        let imgAvatar = element.getAttribute('img-avatar');
        let imgIcon = element.getAttribute('img-icon');
        let svgIcon = element.getAttribute('svg-icon');

        // html icon
        let iconHtml = '';
        if (imgIcon) {
            iconHtml = `<img src="${imgIcon}" alt="" width="${iconSize}" height="${iconSize}" style="margin-right:8px; margin-top:${marginTop}px;"/>`;
        } else if (svgIcon) {
            let svgIconFill = element.getAttribute('svg-icon-fill');
            svgIconFill = svgIconFill ? `fill:${svgIconFill};` : '';
            iconHtml = `<svg class="custom-icon" width="${iconSize}" height="${iconSize}" style="margin-right:8px; margin-top:${marginTop}px; ${svgIconFill}">
                <use style="${svgIconFill}" xlink:href="${svgIcon}"></use>
            </svg>`;
        } else if (imgAvatar) {
            if (element.getAttribute('data-avatar')) {
                iconHtml = `<img class="rounded-circle" src="${avatar}" width="${iconSize}" height="${iconSize}" style="margin-right: 8px; margin-top:${marginTop}px;"/>`;
            } else {
                iconHtml = `<svg class="bi text-secondary opacity-75" width="${iconSize}" height="${iconSize}" fill="currentColor" style="margin-right: 8px; margin-top:${marginTop}px;">
                    <use xlink:href="${URL_PATH}/assets/icons/bootstrap-icons.svg#person-circle"></use>
                </svg>`;
            }
        }

        // contenedor general
        let wrapper = document.createElement('div');
        wrapper.style.display = 'flex';
        wrapper.style.alignItems = 'center';

        // contenedor icon
        if (iconHtml) {
            let iconWrapper = document.createElement('div');
            iconWrapper.innerHTML = iconHtml;
            wrapper.appendChild(iconWrapper);
        }

        // Contenedor texto
        let textWrapper = document.createElement('div');
        textWrapper.style.display = 'flex';
        textWrapper.style.flexDirection = 'column';
        textWrapper.style.justifyContent = 'center';

        // Texto principal
        let textSpan = document.createElement('span');
        textSpan.textContent = text;
        textWrapper.appendChild(textSpan);

        // Texto subtitulo
        if (subtitle && type === 'result') {
            let subtitleSpan = document.createElement('small');
            subtitleSpan.className = 'select2-results__subtitle';
            subtitleSpan.textContent = subtitle;
            textWrapper.appendChild(subtitleSpan);
        }

        wrapper.appendChild(textWrapper);
        return wrapper;
    }
    
}