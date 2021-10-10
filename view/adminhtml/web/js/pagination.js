require([
    'jquery',
], function () {
    let PAG = {
        SELECTOR_PAGINATION: "#pagination",
        SELECTOR_SEARCH_FORM: "form#form_movies",
        SELECTOR_CURRENT_PAGE: "input[name='search[page]']",
        SELECTOR_BTN_NEXT: '#btn_next',
        SELECTOR_BTN_PREV: '#btn_prev',
        SELECTOR_BTN_SEARCH: '#search_movies',
        SELECTOR_AREA_BTN_INNER_PAGES: '#inner_pages',
        CLASS_BTN_SPECIFIC_PAGES: 'btn_to_page',
        CURRENT_PAGE: 1,
        FIRST_PAGE: 1,
        LAST_PAGE: 1,
        load: function () {
            PAG.determineLastPage();
            PAG.determineCurrentPage();
            PAG.createBtnToPages();
            PAG.paginate();
            PAG.loadPaginateButtons();
        },
        createBtnToPages: function () {
            let initial_index = (parseInt(PAG.CURRENT_PAGE) - 1) >= 1 ? (parseInt(PAG.CURRENT_PAGE) - 1) : parseInt(PAG.CURRENT_PAGE);
            let end_index = (parseInt(PAG.CURRENT_PAGE) + 2) <= PAG.LAST_PAGE ? (parseInt(PAG.CURRENT_PAGE) + 2) : PAG.LAST_PAGE;
            let dataHtml = '';
            for (let i = initial_index; i <= end_index; i++) {
                dataHtml += '<button class="btn_to_page btn_search_movies" data-page="' + i + '"';
                if (i == parseInt(PAG.CURRENT_PAGE)) {
                    dataHtml += ' disabled';
                }
                dataHtml += '>' + i + '</button>';
            }
            document.querySelector(PAG.SELECTOR_AREA_BTN_INNER_PAGES).innerHTML = document.querySelector(PAG.SELECTOR_AREA_BTN_INNER_PAGES).innerHTML + dataHtml;
        },
        determineCurrentPage: function () {
            PAG.CURRENT_PAGE = document.querySelector(PAG.SELECTOR_CURRENT_PAGE).value;
        },
        determineLastPage: function () {
            let pagination = document.querySelector(PAG.SELECTOR_PAGINATION);
            if (pagination) {
                PAG.LAST_PAGE = pagination.dataset.last_page;
            }
        },
        paginate: function () {
            console.log('paginate');
        },
        canGoToPage: function (page) {
            return (page <= parseInt(PAG.LAST_PAGE)) && (page > 0);
        },
        updateCurrentPage: function (newPage) {
            document.querySelector(PAG.SELECTOR_CURRENT_PAGE).value = newPage;
        },
        loadPaginateButtons: function () {
            let btnSearch = document.querySelector(PAG.SELECTOR_BTN_SEARCH);
            let btnNextPage = document.querySelector(PAG.SELECTOR_BTN_NEXT);
            let btnPrevPage = document.querySelector(PAG.SELECTOR_BTN_PREV);
            let btnsToSpecificPages = document.getElementsByClassName(PAG.CLASS_BTN_SPECIFIC_PAGES);
            btnSearch.addEventListener('click', function () {
                PAG.CURRENT_PAGE = 1;
                PAG.updateCurrentPage(PAG.CURRENT_PAGE);
            });
            btnNextPage.addEventListener('click', function () {
                if (PAG.canGoToPage(parseInt(PAG.CURRENT_PAGE) + 1)) {
                    PAG.CURRENT_PAGE = parseInt(PAG.CURRENT_PAGE) + 1;
                    PAG.updateCurrentPage(PAG.CURRENT_PAGE);
                }
            });
            btnPrevPage.addEventListener('click', function () {
                if (PAG.canGoToPage(parseInt(PAG.CURRENT_PAGE) - 1)) {
                    PAG.CURRENT_PAGE = parseInt(PAG.CURRENT_PAGE) - 1;
                    PAG.updateCurrentPage(PAG.CURRENT_PAGE);
                }
            });
            for (let i = 0; i < btnsToSpecificPages.length; i++) {
                btnsToSpecificPages[i].addEventListener('click', function () {
                    let to_page = btnsToSpecificPages[i].dataset.page;
                    if (to_page != parseInt(PAG.CURRENT_PAGE)) {
                        if (PAG.canGoToPage(to_page)) {
                            PAG.CURRENT_PAGE = to_page;
                            PAG.updateCurrentPage(PAG.CURRENT_PAGE);
                        }
                    }
                });
            }
        },
    }
    PAG.load();
});


