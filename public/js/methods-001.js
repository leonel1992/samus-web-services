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