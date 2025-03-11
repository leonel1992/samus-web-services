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
    
    static initInputsUserCodeFormat(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        context.querySelectorAll("input[input-case='user-code']").forEach(input => {
            input.addEventListener("keyup", function() {
                const pattern = /[^0-9]/g;
                this.value = this.value.replace(pattern, "").substr(0, 4);
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

    static initInputsPrefixFormat(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        context.querySelectorAll("input[input-case='prefix']").forEach(input => {
            input.addEventListener("keyup", function() {
                const pattern = /[^0-9+]/g;
                let inputValue = this.value.replace(pattern, "");
                
                if (!inputValue.startsWith("+")) {
                    inputValue = "+" + inputValue.replace(/\+/g, "");
                } else {
                    inputValue = "+" + inputValue.slice(1).replace(/\+/g, "");
                }
        
                this.value = inputValue.substr(0, this.getAttribute('maxlength'));
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

    /////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM PASSWORD --------------------------------------------------------------------------
    /////////////////////////////////////////////////////////////////////////////////////////////

    static initInputsPassword(parent = null) {
        const context = parent ? $(parent) : $(document);

        const htmlHide = `<svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="viewpass password-hide">
            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#eye-slash">
        </svg>`;

        const htmlShow = `<svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="viewpass password-show">
            <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#eye">
        </svg>`;

        context.find(".custom-password-icon").remove();
        context.find(".custom-password").each(function(index, element) {
            const id = $(element).attr("id");
            $(element).addClass("border-end-0");
            $(element).parent().append(`
                <span class="input-group-text custom-password-icon">
                    <a class="custom-password-btn" role="button" show="false" for="${id}">${htmlHide}</a>
                </span>
            `);
        });

        context.find(".custom-password-btn").click(function () { 
            let show = $(this).attr("show");
            let input = $(this).attr("for");
            if (show === 'false') {
                $('#'+ input).attr("type", "text");
                $(this).attr("show","true");
                $(this).html(htmlShow);
            } else {
                $('#'+ input).attr("type", "password");
                $(this).attr("show","false");
                $(this).html(htmlHide);
            }
        });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    // CUSTOM DATE PICKER --------------------------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////

    static initInputsDatepicker(parent = null) {
        const context = parent ? document.querySelector(parent) : document;
        
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

        Object.defineProperty(datepicker, 'value', {
            get: function() {
                let val = getLocaleDate(input.value);
                return val ? `${val.year}/${val.month}/${val.day}` : undefined;
            },
            set: function(newValue) {
                let val = '';
                if (newValue) {
                    let data = newValue.split("/");
                    val = setLocaleDate(data[2], data[1], data[0]);
                } 
                
                this._value = val;
                input.value = val;
            }
        });
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
        let input = calendar.closest('.custom-datepicker').querySelector('input');
        calendar.querySelectorAll('.date-item').forEach(cell => {
            cell.addEventListener('click', function() {
                let selectedDate = this.getAttribute('data-date');
                input.value = selectedDate;
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

    static initInputFile(parent = null) {
        const context = parent ? $(parent) : $(document);
        
        context.find(".custom-file").each(function (index, element) {
            $(this).val("");
            Inputs.htmlInputFile(element);
        });

        context.find(".custom-file").not('.disabled').not('[disabled]').bind('dragover', function(e){
            e.preventDefault();
            $(this).addClass("active");
            $(this).removeClass("is-invalid");
        });

        context.find(".custom-file").not('.disabled').not('[disabled]').bind('dragleave', function(e){
            e.preventDefault();
            $(this).removeClass("active");
        });

        context.find(".custom-file").not('.disabled').not('[disabled]').bind('drop', function(e){
            e.preventDefault();
            let files = e.originalEvent.dataTransfer.files;
            Inputs.fileProcess(this, files);
            $(this).removeClass("active");
            $(this).removeClass("is-invalid");
        });

        context.find(".custom-file-simple").not('.disabled').not('[disabled]').click(function (e) {
            e.preventDefault();
            $(this).parent().find('.custom-file-input').click();
        });

        context.find(".custom-file").not('.disabled').not('[disabled]').find('.custom-file-btn').click(function (e) { 
            e.preventDefault();
            $(this).parents('.custom-file-container').find('.custom-file-input').click();
        });

        context.find(".custom-file").not('.disabled').not('[disabled]').find('.custom-file-delete').click(function (e) { 
            e.preventDefault();
            let input = $(this).parents('.custom-file');
            Inputs.fileDelete(input);
        });
        
        context.find('.custom-file-input').change(function () {
            let files = this.files;
            let input = $(this).parent().find(".custom-file");
            $(input).removeClass("is-invalid");
            Inputs.fileProcess(input, files);
        });
    }

    //proccess
    static fileProcess(input, files){
        $.each(files, function (index, file) {
            let fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onload = function () {
                Inputs.validateFile(input, file, fileReader);
            };
        });
    }

    static fileDelete(input, item=null){
        $(input).parent().find(".custom-file-input").val(undefined);
        $(input).val("");

        if (item === null) {
            $(input).find('.custom-file-container-items').css('opacity', 1);
            $(input).find('.custom-file-container-image').css('opacity', 0);
            setTimeout(() => {
                $(input).find('.custom-file-image').find('img').attr('alt', "");
                $(input).find('.custom-file-image').find('img').attr('src', "");
            }, 200);
        } else {
            $(item).slideUp(200);
            setTimeout(() => {
                $(item).remove();
            }, 200);
        }
    }

    static async filePrint(input, file, fileReader){
        Inputs.htmlInputFileView(input, file, fileReader);
        setTimeout(() => {
            $("#"+ $(input).val().replace('.','')).slideDown(200);
        }, 200);
    }

    //upload
    static async fileUpload(input, file, fileReader){
        Inputs.fileUploadData(input, file).then( (resp) => {
            if (resp) {
                if (resp.success) {
                    Inputs.fileUploadSuccess(input, resp);
                    Inputs.filePrint(input, file, fileReader);
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
        form.append("file", file);
        form.append("type", $(input).attr("input-type"));

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
                    console.log("STATUS: ", jqXHR.status);
                    console.log("ERROR:  ", jqXHR.responseText);
                    response(null);
                }
            });
        });
    }

    static fileUploadSuccess(input, resp){
        $(input).val(resp.file);
        showToast(TypeToast.success, resp.message);
    }

    static fileUploadError(input, message){
        $(input).val("");
        $(input).parent().find(".custom-file-input").val(undefined);
        showToast(TypeToast.danger, message);
    }

    //validate
    static validateFileAlert(input, message){
        $(input).parent().find(".custom-file-input").val(undefined);
        showToast(TypeToast.danger, message);
    }

    static validateFile(input, file, fileReader){
        
        let validateType = $(input).attr("input-type");
        let validateSize = $(input).attr("validate-file-size");
        let validateExt = $(input).attr("input-accept").split(',');
        let regExpExt = new RegExp('('+ validateExt.join('|').replace(/\./g, '\\.') +')$');

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
        
        let validateEqual = $(input).attr("validate-file-equal");
        let validateWidth = $(input).attr("validate-file-width");
        let validateHeight = $(input).attr("validate-file-height");
        
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
        
        const inputType = $(input).attr("input-type");
        const inputIcon = $(input).attr("input-icon");
        const inputText = $(input).attr("input-text");
        const inputButton = $(input).attr("input-button");
        const inputAccept = $(input).attr("input-accept");

        let htmlItems = `<div class="custom-file-container-items">`;
            htmlItems += `
                <span class="custom-file-icon">
                    <svg width="80" height="80" fill="currentColor">
                        <use xlink:href="${URL_BOOTSTRAP_ICONS}#${inputIcon ?? 'camera'}"/>
                    </svg>
                    </span>
                <span class="custom-file-label-text">${inputText ?? LANGUAGE.inputFile.text}</span>
            `;
            if (!$(input).hasClass("custom-file-simple")) {
                htmlItems += `
                    <span class="custom-file-label-o">${LANGUAGE.inputFile.or}</span>
                    <button class="btn custom-file-btn" type="button">
                        <span lcass="custom-file-btn-icon">
                            <svg width="22" height="22" fill="currentColor">
                                <use xlink:href="${URL_BOOTSTRAP_ICONS}#upload"/>
                            </svg>
                        </span>
                        <span lcass="custom-file-btn-text">${inputButton ?? LANGUAGE.inputFile.button}</span>
                    </button>
                `;
            }
        htmlItems += `</div>`;
        
        $(input).append(htmlItems);
        $(input).append(`
            <div class="custom-file-container-image">
                <div class="custom-file-image" >
                    <button class="custom-file-delete" type="button"><i class="bi bi-x"></i></button>
                    <img src="" alt="" />
                </div>
            </div>
        `);

        $(input).replaceWith(`
            <div class="custom-file-container">
                <input class="custom-file-input custom-control" type="file" accept="${inputAccept ?? inputType+'/*'}" hidden />
                ${ $(input).prop('outerHTML') }
            </div>
        `);
    }

    static htmlInputFileView(input, file, fileReader){
        if ( $(input).attr('input-replace-view') == 'true' ) {
            $(input).find('.custom-file-image').find('img').attr('alt', file.name);
            $(input).find('.custom-file-image').find('img').attr('src', fileReader.result);
            setTimeout(() => {
                $(input).find('.custom-file-container-items').css('opacity', 0);
                $(input).find('.custom-file-container-image').css('opacity', 1);
            }, 150);
        } else {
            $(input).parent().find('.custom-file-view').slideUp(200);
            setTimeout(() => {
                $(input).parent().find('.custom-file-view').remove();
                $(input).parent().append(`
                    <div id="${ $(input).val().replace('.','') }" class="custom-file-view form-control" style="display:none;">
                        <span class="custom-file-view-icon"><img src="${fileReader.result}" alt="${file.name}" /></span>
                        <span class="custom-file-view-name">${file.name}</span>
                        <button class="custom-file-delete" type="button"><i class="bi bi-x"></i></button>
                    </div>
                `);

                $(".custom-file-view").not('.disabled').not('[disabled]').find('.custom-file-delete').click(function (e) { 
                    e.preventDefault();
                    let item = $(this).parents('.custom-file-view');
                    let input = $(this).parents('.custom-file-container').find('.custom-file');
                    Inputs.fileDelete(input, item);
                });
            }, 200);
        }
    }

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
                templateResult: Inputs.templateResult,
                templateSelection: Inputs.templateSelection,
                minimumResultsForSearch: showSearch
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
                return Inputs.templateItem(obj, '19', '-1');
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
                return Inputs.templateItem(obj, '26', '-2');
            }
        }
    }
    
    static templateItem(obj, iconSize, marginTop) {
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