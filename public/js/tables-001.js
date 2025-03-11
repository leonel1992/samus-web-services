class Tables {

    constructor(){}

    static initTable(){
        $(".custom-table").each(function (index, element) {
            if ($(element).hasClass("table-filter")) {
                Tables.initFilter(element);
            }
            if ($(element).hasClass("table-select")) {
                Tables.initSelectsed(element);
            }
        });
    }

    // TABLE FILTER --------------------------------------------------------------------------

    static initFilter(element){
        Tables.#htmlInputFilter(element);

        $(".filter-clear").click( function() {
            const table = $(this).parents(".filter").attr("for");
            $(table).parents(".custom-table-container").find(".filter-input").val("");
            Tables.#filter(table);
        });

        $(".filter-input").on('cut paste keyup change', function() { 
            const table = $(this).parents(".filter").attr("for");
            Tables.#filter(table);
        });

        $(".filter-search").click( function() {
            
        });
    }

    //html filter
    static #htmlInputFilter(table){
        const id = $(table).attr("id");
        const text = $(table).attr("text-filter");
        $('body').addClass("table-search");
        $(table).parents(".custom-table-container").prepend(`<div class="filter" for="#${id}">
            <span class="filter-icon filter-search">
                <svg fill="currentColor">
                    <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#search"/>
                </svg>
            </span>
            <input type="text" class="filter-input" placeholder="${text}">
            <span class="filter-icon filter-clear">
                <svg fill="currentColor">
                    <use xlink:href="${URL_PATH}/assets/icons/bootstrap.svg#x-lg"/>
                </svg>
            </span>
        </div>`);

        const height = $(table).parents(".custom-table-container").find(".filter").height(); 
        document.documentElement.style.setProperty('--manage-table-filter-height', height +"px");
    }

    //filter functions
    static #filter(table){
        let filter = Tables.#formatFilter( $(table).parents(".custom-table-container").find(".filter-input").val() );
        $(table).find("tbody tr").each(function() {
            
            let show = false;
            $(this).find("th, td").each(function() {
                let text = Tables.#formatFilter( $(this).text() );
                if(text.indexOf(filter) >= 0){
                    show = true;
                }
            });

            if(show){
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    }

    static #formatFilter(text) {

        let accentMap = {
            'á':'a', 'à':'a', 'ä':'a', 'â':'a',
            'é':'e', 'è':'e', 'ë':'e', 'ê':'e',
            'í':'i', 'ì':'i', 'ï':'i', 'î':'i',
            'ó':'o', 'ò':'o', 'ö':'o', 'ô':'o',
            'ú':'u', 'ù':'u', 'ü':'u', 'û':'u',
            'Á':'a', 'À':'a', 'Ä':'a', 'Â':'a',
            'É':'e', 'È':'e', 'Ë':'e', 'Ê':'e',
            'Í':'i', 'Ì':'i', 'ï':'i', 'Î':'i',
            'Ó':'o', 'Ò':'o', 'Ö':'o', 'Ô':'o',
            'Ú':'u', 'Ù':'u', 'Ü':'u', 'Û':'u'
        };

        if(!text) { 
            return ""; 
        } else {
            let ret = '';
            for (let i=0; i < text.length; i++) {
              ret += accentMap[text.charAt(i)] || text.charAt(i);
            } return ret.toLowerCase();
        }
    };

    // TABLE SELECT --------------------------------------------------------------------------

    static initSelectsed(table){
        let pressed = false;
        let pressedCtrl = false;
        let toucheMove = false;
        let touched = 0;
        
        // Key events
        $(document).keydown(function (event) {
            if (event.keyCode == 17) {
                pressedCtrl = true;
            }
        });

        $(document).keyup(function () {
            pressedCtrl = false;
        });

        // Mouse events
        $(table).on( "mouseup", function(){
            pressed = false;
        });

        $(table).on( "mousedown", function(){
            pressed = true;
        });

        $(table).find("tbody tr").on( "mousedown", function(event){
            if( !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) ) {
                if (!$(event.target).closest(".cell-btn").length) {
                    if (!pressedCtrl) {
                        $(table).find("tbody tr").removeClass("selected");
                        $(this).addClass("selected");
                    } else {
                        if ($(this).hasClass("selected")) {
                            $(this).removeClass("selected");
                        } else {
                            $(this).addClass("selected");
                        }
                    }
                }
            }
        });

        $(table).find("tbody tr").hover( function(){
            if(pressed){
                $(this).addClass("selected");
            }
        });

        $(table).find("tbody tr").dblclick( function(event){
            if ($(event.target).closest(".cell-btn").length || pressedCtrl) {
                event.preventDefault();
            }
        });

        $(table).find("thead").click( function(){
            $(table).find("tbody tr").removeClass("selected");
        });

        // Touch events
        $(table).on('touchstart', function (event) {
            if (!$(event.target).closest(".cell-btn").length) {
                if (event.touches.length == 1) {
                    touched = 1;
                } else if (event.touches.length == 2) {
                    touched = 2;
                } else {
                    touched = 3;
                    let touch1 = event.touches[1].target;
                    let touch2 = event.touches[2].target;
                    let row1 = parseInt($(touch1).parents("tr").attr("data-row"));
                    let row2 = parseInt($(touch2).parents("tr").attr("data-row"));
                    if (row1>=0 && row2>=0) {
                        for (let i=Math.min(row1,row2); i<=Math.max(row1,row2); i++) {
                            $(table).find(`tbody tr[data-row="${i}"]`).addClass("selected");
                        }
                    }
                }
            }
        });

        $(table).find("tbody tr").on('touchend', function (event) {
            if (event.touches.length == 0) {
                if (touched == 1 && !toucheMove) { 
                    $(table).find("tbody tr").removeClass("selected");
                    $(this).addClass("selected");
                }
                touched = 0;
                toucheMove = false;
            } else if (event.touches.length == 1) {
                if (touched == 2) { 
                    if ($(this).hasClass("selected")) {
                        $(this).removeClass("selected");
                    } else {
                        $(this).addClass("selected");
                    }
                }
            }
        });

        $(table).on("touchmove", function() {
            toucheMove = true;
        });
    }
}