// COOKIES -------------------------------------------------

function getCookie(name) {
    let cookies = document.cookie.split(';');
    for(let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.indexOf(name + '=') === 0) {
            return cookie.substring(name.length + 1);
        }
    } return null;
}

function setCookie(name, value, days) {
    let date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    let expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// DATE

function getLocaleDate(date, separator = '/') {
    if (!date || typeof date !== 'string' || !date.includes(separator)) return null;

    let split = date.split(separator);
    if (split.length !== 3) return null;

    let day, month, year;
    if (LANG === 'es') {
        day = parseInt(split[0], 10);
        month = parseInt(split[1], 10) - 1;
        year = parseInt(split[2], 10);
    } else {
        month = parseInt(split[0], 10) - 1;
        day = parseInt(split[1], 10);
        year = parseInt(split[2], 10);
    }

    if (isNaN(day) || isNaN(month) || isNaN(year) || year < 1000 || year > 2100) {
        return null;
    } return { day, month, year };
}

function setLocaleDate(day, month, year, separator = '/') {
    if (!day || !month || !year) return '';

    let d = String(day).padStart(2, '0');
    let m = String(month).padStart(2, '0');
    let y = String(year);

    if (LANG === 'es') {
        return `${d}${separator}${m}${separator}${y}`;
    } else {
        return `${m}${separator}${d}${separator}${y}`;
    }
}

// COPY TEXT -------------------------------------------------

function copyText(event, text) {
    navigator.clipboard.writeText(text).then(() => {
        copyTextToast(event.pageX, event.pageY, 'Texto copiado al portapapeles!');
    }).catch(err => {
        copyTextToast(event.pageX, event.pageY, 'Error al copiar: ', err);
    });
}

function copyTextToast(x, y, message) {
    const toast = document.createElement('div');

    toast.textContent = message;
    Object.assign(toast.style, {
        position: 'absolute',
        left: '-9999px',
        top: '-9999px',
        backgroundColor: '#333',
        color: '#fff',
        padding: '6px 10px',
        borderRadius: '5px',
        fontSize: '12px',
        opacity: '0',
        pointerEvents: 'none',
        transition: 'opacity 0.3s ease',
        zIndex: '1000'
    });

    document.body.appendChild(toast);
    const rect = toast.getBoundingClientRect();
    
    let leftPos = x + 14;
    if (leftPos + rect.width > window.innerWidth) {
        leftPos = x - rect.width - 14;
    }

    toast.style.left = leftPos + 'px';
    toast.style.top = (y - 5) + 'px';

    requestAnimationFrame(() => {
        toast.style.opacity = '1';
    });

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 1500);
    
}

// NORMALIZE TEXT -------------------------------------------------

function normalizeText(text) {
    if (!text)  return text
    return text
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9\s]/g, '');
}

// ROUND CUERRENCY -------------------------------------------------

function numberDecimals(num) {
    let dec = 0;
    if(num == 0 || num >= 10)   dec = 2;
    else if(num >= 0.1)         dec = 4;
    else if(num >= 0.001)       dec = 6;
    else if(num >= 0.00001)     dec = 8;
    else if(num >= 0.0000001)   dec = 10;
    else                        dec = 12;
        
    return dec;
}

// CURRENCY TO NUMBER -------------------------------------------------

function numberConvert(string) {
    let out = '';
    let filter = '1234567890';
    
    for (let i=0; i<string.length; i++) {
        if (filter.indexOf(string.charAt(i)) != -1) {
            out += string.charAt(i);
        } else if (string.charAt(i) == ',') {
            out += '.';
        }
    }
    
    return parseFloat(out);
}

// STRING TO CURRENCY -------------------------------------------------

function numberFormat(string, dec, minDec=0) {   
    switch (typeof string) {
        case 'string': break;
        case 'number': string = string.toFixed(dec).replaceAll('.',','); break;
        default:       string = ''; break;
    }

    let filter;
    let integer = '';
    let decimal = '';
    
    let countDecimal = 0;
    let countInteger = 0;
    let comma = false;
    
    if(dec > 0) {
        filter = '1234567890,';
    }else{ 
        filter = '1234567890';
    }

    // Integer & Real
    for (let i=0; i<string.length; i++) {
        if (filter.indexOf(string.charAt(i)) != -1) {
            if (!comma && string.charAt(i) != ',') {
                if(parseInt(integer) > 0 || string.charAt(i) != '0'){
                    integer += string.charAt(i);
                }
            } else if (comma && string.charAt(i) != ',' && countDecimal < dec) {
                decimal += string.charAt(i);
                countDecimal++;
            }
            if(string.charAt(i) == ',' && !comma) {
                decimal += string.charAt(i);
                comma = true;
            }
        }
        if(!comma){ 
            countInteger++;
        }
    }
    
    //Assign thousands points
    if (countInteger > 3) {
        let output = '';
        let count = integer.length;
        
        for(let i=0; i<integer.length; i++) {
            if((count % 3) == 0 && i != 0) {
                output += '.';
                output += integer.charAt(i); 
                count--;
            } else {
                output += integer.charAt(i);
                count--;
            }  
        }
        
        integer = output;
    }
    
    // Output
    if (integer == '') {
        integer = '0';
    }

    if (decimal.length < minDec) {
        if(!decimal.includes(',')){
            decimal += ',';
            minDec++;
        }
        for(let i=decimal.length; i<minDec; i++) {
            decimal += '0';
        }
    }
    
    return integer.concat(decimal);
}