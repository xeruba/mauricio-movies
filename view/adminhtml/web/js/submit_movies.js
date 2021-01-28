require([
        'ko',
        'jquery',
        'Magento_Ui/js/modal/confirm',
        'Magento_Ui/js/modal/alert',
    ],function (ko, $, confirmation, alert){
        let SUB = {
            SELECTOR_PAGINATION: '#pagination',
            SELECTOR_SUBMIT_SEARCH: '.btn_search_movies',
            SELECTOR_SUBMIT_IMPORT: '#import_movies',
            SELECTOR_SEARCH_FORM: 'form#form_movies',
            SELECTOR_CHECKBOX_MOVIES: '.checkbox_movies',
            SELECTOR_INPUTS_MOVIES: '.input_movies',

            load: function (){
                console.log('start select_movies.js');
                SUB.handleSearchForm();
                SUB.handleImportForm();
            },
            handleImportForm: function (){
                $(document.querySelectorAll(SUB.SELECTOR_SUBMIT_IMPORT)).on('click', function (e){
                    SUB.removeUncheckedMovies();
                });

            },
            searchSubmit: function (e){
                console.log("btn_SEARCH");
                e.preventDefault();

                if(SUB.hasMoviesSelected()){
                    SUB.confirmSearch(e);
                }else{
                    SUB.submitWithoutMovies();
                }
            },
            handleSearchForm: function()
            {
                console.log("handleSearchForm");
                let search_btns = document.querySelectorAll(SUB.SELECTOR_SUBMIT_SEARCH);
                for (let i = 0; i < search_btns.length; i++) {
                    $(search_btns[i]).on('click', function (e){
                        SUB.searchSubmit(e);
                    });
                }
            },
            disableMovies: function (movies_array){
                let input_movies = movies_array;
                for(let i = 0; i<input_movies.length; i++){
                    $(input_movies[i]).prop( "disabled", true );
                }
            },
            removeUncheckedMovies: function (){
                SUB.disableMovies(document.querySelectorAll(SUB.SELECTOR_CHECKBOX_MOVIES+":not(:checked)"));
            },
            hasMoviesSelected: function (){
                console.log('hasMoviesSelected');
                let movies_selected = document.querySelectorAll(SUB.SELECTOR_CHECKBOX_MOVIES+":checked");
                return movies_selected.length > 0;

            },
            isAnProductInput: function (name){
                return name.match(/(products\[)\w+(0-1)*(\])/g) ? true : false;
            },
            submitWithoutMovies: function (){
                SUB.disableMovies(document.querySelectorAll(SUB.SELECTOR_INPUTS_MOVIES));
                $(document.querySelector(SUB.SELECTOR_SEARCH_FORM)).submit();
            },
            confirmSearch: function (){
                confirmation({
                    title: $.mage.__('Prevent search'),
                    content: $.mage.__('You will lost all the selected movies, click on "OK" to proceed.'),
                    actions: {
                        confirm: function(){SUB.submitWithoutMovies();}
                        /*always: function(){console.log('always alert');}
                        cancel: function(){}*/
                    }
                });
                /*alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Should be more then one movie selected to import'),
                        actions: {
                            always: function(){console.log('always alert');}
                        }
                    });*/
            }
        }
        SUB.load();
    });


