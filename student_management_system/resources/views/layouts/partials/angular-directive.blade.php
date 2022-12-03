<script>
    app.service('dir', function () {
        var dir = this;

        /**
        * Store a newly created resource in storage.
        *
        * @param  \model="user.firstname" --default="name"
        * @param  \area-label="First name" || label="First name"
        * @param  \area-placeholder="Enter first name" || placeholder="Enter first name"
        * @param  \values="Male,Female" --- used for radio
        * @return \ { model:'user.first_name', label:'First name', placeholder:'Enter first name' }
        */
        this.getParams = function (elem, attr){
            // console.log('elem', elem);
            // console.log('attr', attr);

            //Capitalized Element name
            // var tagName = elem[0].tagName;

            // update model
            var response = {};
            response.model = 'name';
            (attr.model) ? (response.model = attr.model) : null;

            // update label
            var res = response.model.split(".");
            var label_small = res[res.length-1];
            label_small = label_small.replace('_id', '');
            while (label_small.includes('_')) label_small = label_small.replace('_', ' ');
            response.label = label_small.charAt(0).toUpperCase() + label_small.slice(1);
            (attr.ariaLabel) ? (response.label = attr.ariaLabel) : null;
            (attr.label) ? (response.label = attr.label) : null;

            // placeholder
            response.placeholder = 'Enter ' + response.label.toLowerCase();
            if (attr.inputSelectText != undefined || attr.inputSelectModel != undefined)
                response.placeholder = 'Choose ' + response.label.toLowerCase();
            (attr.ariaPlaceholder) ? (response.placeholder = attr.ariaPlaceholder) : null;
            (attr.placeholder) ? (response.placeholder = attr.placeholder) : null;
            if ((attr.placeholder) &&  (attr.placeholder == 'null')) response.placeholder = '';

            response.changeText = '';
            if (attr.change) response.changeText = 'ng-change="'+attr.change+'"';
            response.change = attr.change;

            response.focusText = '';
            if (attr.focus) response.focusText = 'ng-focus="'+attr.focus+'"';

            // values for radio eg: values="Male,Female"
            (attr.values) ? (response.values = attr.values.split(',')) : null;


            return response;
        }
    })

    app.directive('ngEnter', function () { //a directive to 'enter key press' in elements with the "ng-enter" attribute
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    console.log('event', event);

                    scope.$apply(function () {
                        scope.$eval(attrs.ngEnter);
                    });
                    event.preventDefault();
                }
            });
        };
    });

    // Datepicker
    app.directive('selectDate', function () {
        return {
            require: '?ngModel',
            link: function (scope, elm, attr, ngModel) {
                if (!ngModel) {
                    console.warn('ng-model is required', elm);
                    return;
                }
                var format = "YYYY-MM-DD";
                if (attr.format) format = attr.format;
                // console.log('date-format', format);

                var datepicker = $(elm).datetimepicker({
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
                    format: format,
                }).on('dp.hide', function (e) {
                    scope.$apply(function() {
                        ngModel.$setViewValue(e.date.format(format));
                    });
                }).on('dp.change', function (e) {
                    scope.$apply(function() {
                        ngModel.$setViewValue(e.date.format(format));
                    });
                });
                ngModel.$render = function (value) {
                    datepicker.val(ngModel.$viewValue);
                };
            }
        };
    });

    app.directive('inputDate', function (dir) {
        //                                     *                    *
        // <div input-date class="row" model="job.deadline"></div>
        return {
            template: function(elem, attr) {
                var params = dir.getParams(elem, attr);
                return  '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                            '<div class="col-sm-9">'+
                                '<div class="form-group bmd-form-group">'+
                                    '<div class="form-group">'+
                                        '<input type="text" class="form-control date" ng-model="'+params.model+'" placeholder="'+params.placeholder+'">'+
                                        '<input class="date-holder" type="text" ng-model="'+params.model+'" ng-change="'+attr.change+'">'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
            }
        };
    });

    // CKEditor
    app.directive('ckeditor', function ($timeout) {
        return {
            require: '?ngModel',
            link: function (scope, elm, attr, ngModel) {
                if (!attr.id){
                    console.error('id attribute is required for ckeditor directive');
                    return;
                } else if (!ngModel){
                    console.error('ng-model required for ckeditor directive');
                    return ;
                }
                @if(config('settings.ckeditor_disabled')) return; @endif
                let lang = 'en';
                if (attr.lang) lang = attr.lang;
                let ckeditor = CKEDITOR.replace(document.getElementById(attr.id), {
                    language: lang,
                    extraPlugins: 'embed,autoembed,image2',
                    embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
                    toolbarGroups: [
                        {
                            "name": "basicstyles",
                            "groups": ["basicstyles"]
                        },
                        {
                            "name": "links",
                            "groups": ["links"]
                        },
                        {
                            "name": "paragraph",
                            "groups": ["list", "blocks"]
                        },
                        {
                            "name": "document",
                            "groups": ["mode"]
                        },
                        {
                            "name": "insert",
                            "groups": ["insert"]
                        },
                        {
                            "name":"colors",
                            "groups":['TextColor','BGColor']
                        },
                        {
                            "name": 'align',
                            "groups": ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                        },
                        {
                            "name": "styles",
                            "groups": ["styles"]
                        },
                        // {
                        //     "name": "about",
                        //     "groups": ["about"]
                        // }
                    ],
                    removeButtons: 'Strike,Subscript,Superscript,Anchor',
                    image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
                    image2_disableResizer: true
                });
                ckeditor.on('instanceReady', function () {
                    ckeditor.setData(ngModel.$viewValue);
                });

                function updateModel() {
                    $timeout(function() {
                        ngModel.$setViewValue(ckeditor.getData());
                    }, 0);
                    // scope.$apply(function () {
                    //     ngModel.$setViewValue(ckeditor.getData());
                    // });
                }
                ckeditor.on('change', updateModel);
                ckeditor.on('key', updateModel);
                ckeditor.on('dataReady', updateModel);

                ngModel.$render = function (value) {
                    ckeditor.setData(ngModel.$viewValue);
                };
            }
        };
    });

    app.directive('inputText', function (dir) {
        return {
            template: function(elem, attr) {
                var params = dir.getParams(elem, attr);
                return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                            '<div class="col-sm-9">'+
                                '<div class="form-group bmd-form-group">'+
                                    '<input type="text" class="form-control" ng-model="'+params.model+'" placeholder="'+params.placeholder+'" '+params.focusText+'>'+
                                '</div>'+
                            '</div>';
            }
        };
    });
    app.directive('errors', function (dir) {
        // <div errors="error_messages"></div>
        // <div errors></div>
        return {
            template: function(elem, attr) {
                let model = (attr.errors) ? (attr.errors) : "error_messages";
                return '<div class="alert alert-danger alert-dismissible" ng-show="'+model+'">'+
                            '<span ng-repeat="error_message in '+model+'">@{{ error_message.replace("extra.", "") }}</span>'+
                            '<button type="button" class="close" ng-click="'+model+'=null" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '</div>';
            }
        };
    });

    /**
     * Usage:  <div input-radio class="row" label="Gender" model="customer.gender" values="Male,Female"></div>
     */
    app.directive('inputRadio', function (dir) {
        return {
            template: function(elem, attr) {
                var params = dir.getParams(elem, attr);
                var radios = '';
                let change = attr.change ? ' ng-change="'+attr.change+'" ' : '';
                $.each(params.values, function (key, value) {
                    radios +=   '<div class="form-check form-check-inline">'+
                        '<label class="form-check-label">'+
                        '<input class="form-check-input" type="radio" ng-model="'+params.model+'" value="'+value+'" '+change+'> '+value+
                        '<span class="circle"><span class="check"></span></span>'+
                        '</label>'+
                        '</div>';
                })
                if (attr.class == 'min') {
                    return '<div class="col-sm-12 checkbox-radios pt-2">'+radios+'</div>';
                }
                return '<label class="col-sm-3 col-form-label label-checkbox">'+params.label+'</label>'+
                    '<div class="col-sm-9 checkbox-radios pt-2">'+radios+'</div>';
            }
        };
    });

    // Eg: <select select2 ng-model="work.wait_for" options="options" class="form-control" multiple="multiple"></select>
    app.directive('select2', function (dir) {
        return {
            require: '?ngModel',
            priority: 10,
            link: function (scope, elm, attr, ngModel) {
                if (!ngModel) {
                    console.warn('ng-model is required', elm);
                    return;
                }

                let select2 = $(elm).select2().on('select2:select', function (e) {
                    // console.log('selected',e.params.data);
                    let data = ngModel.$viewValue ? ngModel.$viewValue : [];
                    data.push(e.params.data.id);
                    ngModel.$setViewValue(data);
                }).on('select2:unselect', function (e) {
                    // console.log('unselected',e.params.data);
                    let data = ngModel.$viewValue ? ngModel.$viewValue : [];
                    data.splice(data.indexOf(e.params.data.id), 1);
                    ngModel.$setViewValue(data);
                }).on("select2:open", function (e) {})
                    .on("select2:close", function (e) {});

                ngModel.$render = function (value) {
                    select2.val(ngModel.$viewValue).trigger('change');
                };
            },

            template: function(elem, attr) {
                let params = dir.getParams(elem, attr);
                // option-attr for input-select-model
                let optionAttr = (attr.optionAttr) ? attr.optionAttr : 'name';
                // console.log('attr', attr);
                return '<option ng-repeat="object in '+attr.options+'" value="@{{ object.id }}">@{{ object.'+optionAttr+' }}</option>';
            }
        };
    });
    app.directive('inputSelectModel', function (dir) {
        //                                     *                    *
        // <div input-select-model class="row" model="job.company" options="data.companies" option-attr="name" aria-label="Company" placeholder="Choose Company" ></div>
        return {
            template: function(elem, attr) {
                var params = dir.getParams(elem, attr);
                // option-attr for input-select-model
                var optionAttr = (attr.optionAttr) ? attr.optionAttr : 'name';
                // console.log('attr', attr);
                if (attr.class == 'min') {
                    return '<select ng-model="'+params.model+'">'+
                                '<option value="">'+params.placeholder+'</option>'+
                                '<option ng-repeat="object in '+attr.options+'" value="@{{ object.id }}">@{{ object.'+optionAttr+' }}</option>'+
                            '</select>';
                }
                return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                            '<div class="col-sm-9">'+
                                '<div class="form-group bmd-form-group">'+
                                    '<select class="form-control" ng-model="'+params.model+'" '+params.changeText+'>'+
                                        '<option value="">'+params.placeholder+'</option>'+
                                        '<option ng-repeat="object in '+attr.options+'" value="@{{ object.id }}">@{{ object.'+optionAttr+' }}</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>';
            }
        };
    });
    app.directive('inputSelectText', function (dir) {
        //                                     *                    *
        // <div input-select-text class="row" model="job.company" options="data.companies" option-attr="name" aria-label="Company" placeholder="Choose Company" ></div>
        return {
            template: function(elem, attr) {
                var params = dir.getParams(elem, attr);
                if (attr.class == 'min') {
                    return '<select ng-model="'+params.model+'">'+
                                '<option value="">'+params.placeholder+'</option>'+
                                '<option ng-repeat="option in '+attr.options+' | orderBy" value="@{{ option }}">@{{ option }}</option>'+
                            '</select>';
                }
                return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                            '<div class="col-sm-9">'+
                                '<div class="form-group bmd-form-group">'+
                                    '<select class="form-control" ng-model="'+params.model+'">'+
                                        '<option value="">'+params.placeholder+'</option>'+
                                        '<option ng-repeat="option in '+attr.options+' | orderBy" value="@{{ option }}">@{{ option }}</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>';
            }
        };
    });

    app.directive('title', function(){
        return {
            restrict: 'A',
            link: function(scope, element, attrs){
                $(element).hover(function(){
                    // on mouseenter
                    $(element).tooltip({ placement:'bottom' });
                    setTimeout(function () {
                        $(element).tooltip('hide'); //close the tooltip
                    }, 5000);
                    $(element).tooltip('show');
                }, function(){
                    // on mouseleave
                    $(element).tooltip('hide');
                });
            }
        };
    });

    // Not completed
    app.directive('checkBox', function (dir) {
        return {
            template: function(elem, attr) {
                let params = dir.getParams(elem, attr);
                return  '<div class="form-check">' +
                        '    <label class="form-check-label">' +
                        '        <input class="form-check-input" type="checkbox" value="" checked="">' +
                        '        '+ params.label +
                        '        <span class="form-check-sign inline"><span class="check"></span></span>' +
                        '    </label>' +
                        '</div>';
            }
        };
    });

    // Eg: <div input-list model="user.name" options="data.names" class="form-group"></div>
    app.directive('inputList', function (dir) {
        return {
            template: function(elem, attr) {
                let params = dir.getParams(elem, attr);
                let id = 'd-list-'+Math.ceil(Math.random()*100000);
                return '<input list="'+id+'" ng-model="'+params.model+'" class="form-control">'+
                    '<datalist id="'+id+'">'+
                    '<option ng-repeat="option in '+attr.options+' | orderBy" value="@{{ option }}">'+
                    '</datalist>';
            }
        };
    });
</script>
