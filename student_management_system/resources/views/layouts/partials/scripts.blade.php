<script>
    app.config(function ($httpProvider) {
        {{--$httpProvider.defaults.headers.common['BranchId'] = "{{ session('branchId') }}";--}}
    });
    // TODO: Close drawer
    // document.getElementsByClassName('close-layer')[0].click();

    $( document ).ready(function() {
        $('.main-panel').perfectScrollbar('destroy');
    });

    $('[title]').data("placement", "bottom").tooltip();

    let notifySettings = {
        type: 'info',
        timer: 3000,
        z_index: 6000,
        placement: { from: 'top', align: 'right' }
    };
    toast = {
        // type = ['', 'info', 'danger', 'success', 'warning', 'rose', 'primary'];
        success: function (message) {
            $.notify({ message: message }, {...notifySettings, ...{type: 'success'}});
        },
        error: function (message) {
            $.notify({ message: message }, {...notifySettings, ...{type: 'danger'}});
        }
    }

    sweet = {
        delete:{
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Delete it!',
            buttonsStyling: false
        }
    }

    function initDates() {
        $('.date').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            },
            format: "{{ config('settings.date_format_js') }}",
        }).on('dp.hide', function (e) {
            $(this).siblings('.date-holder').val(this.value);
            angular.element($('.date-holder')).triggerHandler('input');
        });
    }
    initDates();

    function animateRefresh(selector) {
        $(selector).hide('slow', function () {
            updateSrc(selector);
            $(selector).show('slow');
        })
    }

    function updateSrc(selector) {
        $(selector).each(function () {
            $(this).attr('src', setUrlParam($(this).attr('src'), 'time', Date.now()))
        });
    }
    function setUrlParam(url, key, value) {
        var key = encodeURIComponent(key),
            value = encodeURIComponent(value);

        var baseUrl = url.split('?')[0],
            newParam = key + '=' + value,
            params = '?' + newParam;

        if (url.split('?')[1] === undefined){ // if there are no query strings, make urlQueryString empty
            urlQueryString = '';
        } else {
            urlQueryString = '?' + url.split('?')[1];
        }

        // If the "search" string exists, then build params from it
        if (urlQueryString) {
            var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
            var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

            if (value === undefined || value === null || value === '') { // Remove param if value is empty
                params = urlQueryString.replace(removeRegex, "$1");
                params = params.replace(/[&;]$/, "");

            } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it
                params = urlQueryString.replace(updateRegex, "$1" + newParam);

            } else if (urlQueryString == '') { // If there are no query strings
                params = '?' + newParam;
            } else { // Otherwise, add it to end of query string
                params = urlQueryString + '&' + newParam;
            }
        }

        // no parameter was set so we don't need the question mark
        params = params === '?' ? '' : params;

        return baseUrl + params;
    }
</script>
