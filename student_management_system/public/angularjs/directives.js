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
        if (attr.ngModel) response.model = attr.ngModel;
        else if (attr.model) response.model = attr.model;
        else response.model = '';
        response.id = (attr.id) ? attr.id : 'id';

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

        response.disabledText = '';
        if (attr.disabled) response.disabledText = 'ng-disabled="'+attr.disabled+'"';
        response.disabled = attr.disabled;

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
                '<input type="text" class="form-control" ng-model="'+params.model+'" placeholder="'+params.placeholder+'" select-date>'+
                '</div>'+
                '</div>'+
                '</div>';
        }
    };
});


app.directive('selectDateThreeMonths', function () {
    return {
        require: '?ngModel',
        link: function (scope, elm, attr, ngModel) {
            if (!ngModel) {
                console.warn('ng-model is required', elm);
                return;
            }
            var format = "YYYY-MM-DD";
            var date = moment().add(3, 'M')
            date = moment(date).format("YYYY-MM-DD")
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
                minDate: date
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


app.directive('inputDateThreeMonths', function (dir) {
    //                                     *                    *
    // <div input-date class="row" model="job.deadline"></div>
    return {
        template: function(elem, attr) {
            var params = dir.getParams(elem, attr);
            return  '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                '<div class="col-sm-9">'+
                '<div class="form-group bmd-form-group">'+
                '<div class="form-group">'+
                '<input type="text" class="form-control" ng-model="'+params.model+'" placeholder="'+params.placeholder+'" select-date-three-months>'+
                '</div>'+
                '</div>'+
                '</div>';
        }
    };
});
// CKEditor
app.directive('ckeditor', function () {
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
            let lang = 'en';
            if (attr.lang) lang = attr.lang;
            let ckeditor = CKEDITOR.replace(elm[0], {
                language: lang,
                extraPlugins: 'embed,autoembed,image2',
                embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
                toolbarGroups: [{
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
                removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor',
                image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
                image2_disableResizer: true
            });
            ckeditor.on('instanceReady', function () {
                ckeditor.setData(ngModel.$viewValue);
            });

            function updateModel() {
                if(!scope.$$phase) {
                    scope.$apply(function () {
                        ngModel.$setViewValue(ckeditor.getData());
                    });
                }
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
            let change = attr.change ? ' ng-change="'+attr.change+'" ' : '';
            return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                '<div class="col-sm-9">'+
                '<div class="form-group bmd-form-group">'+
                '<input type="text" class="form-control" ng-model="'+params.model+'" placeholder="'+params.placeholder+'" ng-change="'+params.change+'" '+params.focusText+'>'+
                '</div>'+
                '</div>';
        }
    };
});

app.directive('inputPhone', function (dir) {
    return {
        template: function(elem, attr) {
            let params = dir.getParams(elem, attr);
            let change = attr.change ? ' ng-change="'+attr.change+'" ' : '';
            return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                    '<div class="col-sm-9">'+
                        '<div class="form-group bmd-form-group">'+
                            '<input type="text" class="form-control" ng-model="'+params.model+'" placeholder="'+params.placeholder+'" '+params.focusText+' '+change+' ng-intl-tel-input>'+
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
                '<span ng-repeat="error_message in '+model+'">{{ error_message.replaceAll("extra.", "") }}</span>'+
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

            let select2 = $(elm).select2({
                // maximumSelectionLength: 1
            }).on('select2:select', function (e) {
                // console.log('selected',e.params.data);
                // let data = ngModel.$viewValue ? ngModel.$viewValue : [];
                // data.push(e.params.data.id);
                // ngModel.$setViewValue(data);
            }).on('select2:unselect', function (e) {
                // console.log('unselected',e.params.data);
                // let data = ngModel.$viewValue ? ngModel.$viewValue : [];
                // data.splice(data.indexOf(e.params.data.id), 1);
                // ngModel.$setViewValue(data);
            }).on("select2:open", function (e) {})
                .on("select2:close", function (e) {});

            ngModel.$render = function (value) {
                select2.val(ngModel.$viewValue).trigger('change.select2');
            };
        },

        template: function(elem, attr) {
            let params = dir.getParams(elem, attr);
            // option-attr for input-select-model
            let optionAttr = (attr.optionAttr) ? attr.optionAttr : 'name';
            // console.log('attr', attr);
            return '<option ng-repeat="object in '+attr.options+'" value="{{ object.'+params.id+' }}">{{ object.'+optionAttr+' }}</option>';
        }
    };
});

// Eg: <select select2-text ng-model="work.wait_for" options="options" class="form-control" multiple="multiple"></select>
app.directive('select2Text', function (dir, $timeout) {
	return {
		require: '?ngModel',
		priority: 10,
		link: function (scope, elm, attr, ngModel) {
			if (!ngModel) {
				console.warn('ng-model is required', elm);
				return;
			}

            let select2 = $(elm).select2({
                // maximumSelectionLength: 1
            }).on('select2:select', function (e) {
                // console.log('selected',e.params.data);
                // let data = ngModel.$viewValue ? ngModel.$viewValue : [];
                // data.push(e.params.data.id);
                // ngModel.$setViewValue(data);
            }).on('select2:unselect', function (e) {
                // console.log('unselected',e.params.data);
                // let data = ngModel.$viewValue ? ngModel.$viewValue : [];
                // data.splice(data.indexOf(e.params.data.id), 1);
                // ngModel.$setViewValue(data);
            }).on("select2:open", function (e) {})
                .on("select2:close", function (e) {});

			ngModel.$render = function (value) {
				select2.val(ngModel.$viewValue).trigger('change.select2');
			};
		},

		template: function(elem, attr) {
			let params = dir.getParams(elem, attr);
			// option-attr for input-select-model
			let optionAttr = (attr.optionAttr) ? attr.optionAttr : 'name';
			// console.log('attr', attr);
			return '<option ng-repeat="option in '+attr.options+' | orderBy"  value="{{ option }}">{{ option }}</option>';
		}
	};
});

app.directive('inputSelectModel', function (dir) {
    //                                     *                    *
    // <div input-select-text class="row" model="job.company" options="data.companies" option-attr="name" aria-label="Company" placeholder="Choose Company" ></div>
    return {
        template: function(elem, attr) {
            var params = dir.getParams(elem, attr);
            var optionAttr = (attr.optionAttr) ? attr.optionAttr : 'name';
            if (attr.class == 'min') {
                return '<select ng-model="'+params.model+'" ng-change="'+params.change+'">'+
                    '<option value="">'+params.placeholder+'</option>'+
                    '<option ng-repeat="object in '+attr.options+'" value="{{ object.id }}">{{ object.'+optionAttr+' }}</option>'+
                    '</select>';
            }
            return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                '<div class="col-sm-9">'+
                '<div class="form-group bmd-form-group">'+
                '<select class="form-control" ng-model="'+params.model+'" '+params.changeText+' '+params.disabledText+'>'+
                '<option value="">'+params.placeholder+'</option>'+
                '<option ng-repeat="object in '+attr.options+'" value="{{ object.id }}">{{ object.'+optionAttr+' }}</option>'+
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
                return '<select ng-model="'+params.model+'" ng-change="'+params.change+'" '+params.changeText+' '+params.disabledText+'>'+
                    '<option value="">'+params.placeholder+'</option>'+
                    '<option ng-repeat="option in '+attr.options+' | orderBy" value="{{ option }}">{{ option }}</option>'+
                    '</select>';
            }
            return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
                '<div class="col-sm-9">'+
                '<div class="form-group bmd-form-group">'+
                '<select class="form-control" ng-model="'+params.model+'" '+params.changeText+' '+params.disabledText+'>'+
                '<option value="">'+params.placeholder+'</option>'+
                '<option ng-repeat="option in '+attr.options+' | orderBy" value="{{ option }}">{{ option }}</option>'+
                '</select>'+
                '</div>'+
                '</div>';
        }
    };
});

// app.directive('inputSelectTextChange', function (dir) {
//     //                                     *                    *
//     // <div input-select-text class="row" model="job.company" options="data.companies" option-attr="name" aria-label="Company" placeholder="Choose Company" ></div>
//     return {
//         template: function(elem, attr) {
//             var params = dir.getParams(elem, attr);
//             if (attr.class == 'min') {
//                 return '<select ng-model="'+params.model+'" ng-change="'+params.change+'" '+params.disabledText+'>'+
//                     '<option value="">'+params.placeholder+'</option>'+
//                     '<option ng-repeat="option in '+attr.options+' | orderBy" value="{{ option }}">{{ option }}</option>'+
//                     '</select>';
//             }
//             return '<label class="col-sm-3 col-form-label">'+params.label+'</label>'+
//                 '<div class="col-sm-9">'+
//                 '<div class="form-group bmd-form-group">'+
//                 '<select class="form-control" ng-model="'+params.model+'" ng-change="'+params.change+'" '+params.disabledText+'>'+
//                 '<option value="">'+params.placeholder+'</option>'+
//                 '<option ng-repeat="option in '+attr.options+' | orderBy" value="{{ option }}">{{ option }}</option>'+
//                 '</select>'+
//                 '</div>'+
//                 '</div>';
//         }
//     };
// });

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

/**
 * <button ng-popover> Click
 *     <div class="popover">
 *         <span ng-repeat="(key, value) in data">@{{key}} : @{{value}}<br></span>
 *     </div>
 * </button>
 */
app.directive('ngPopover', function(){
    return {
        restrict: 'A',
        link: function(scope, element, attrs){
            $(element).hover(function(){
                $(element).popover({
                    trigger: 'focus',
                    html: true,
                    content: $(element).children('.popover').html()
                });
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
                '<option ng-repeat="option in '+attr.options+' | orderBy" value="{{ option }}">'+
                '</datalist>';
        }
    };
});
// https://vitalets.github.io/checklist-model/
app.directive('checklistModel', ['$parse', '$compile', function($parse, $compile) {
    // contains
    function contains(arr, item, comparator) {
        if (angular.isArray(arr)) {
            for (var i = arr.length; i--;) {
                if (comparator(arr[i], item)) {
                    return true;
                }
            }
        }
        return false;
    }

    // add
    function add(arr, item, comparator) {
        arr = angular.isArray(arr) ? arr : [];
        if(!contains(arr, item, comparator)) {
            arr.push(item);
        }
        return arr;
    }

    // remove
    function remove(arr, item, comparator) {
        if (angular.isArray(arr)) {
            for (var i = arr.length; i--;) {
                if (comparator(arr[i], item)) {
                    arr.splice(i, 1);
                    break;
                }
            }
        }
        return arr;
    }

    // http://stackoverflow.com/a/19228302/1458162
    function postLinkFn(scope, elem, attrs) {
        // exclude recursion, but still keep the model
        var checklistModel = attrs.checklistModel;
        attrs.$set("checklistModel", null);
        // compile with `ng-model` pointing to `checked`
        $compile(elem)(scope);
        attrs.$set("checklistModel", checklistModel);

        // getter / setter for original model
        var getter = $parse(checklistModel);
        var setter = getter.assign;
        var checklistChange = $parse(attrs.checklistChange);
        var checklistBeforeChange = $parse(attrs.checklistBeforeChange);

        // value added to list
        var value = attrs.checklistValue ? $parse(attrs.checklistValue)(scope.$parent) : attrs.value;


        var comparator = angular.equals;

        if (attrs.hasOwnProperty('checklistComparator')){
            if (attrs.checklistComparator[0] == '.') {
                var comparatorExpression = attrs.checklistComparator.substring(1);
                comparator = function (a, b) {
                    return a[comparatorExpression] === b[comparatorExpression];
                };

            } else {
                comparator = $parse(attrs.checklistComparator)(scope.$parent);
            }
        }

        // watch UI checked change
        scope.$watch(attrs.ngModel, function(newValue, oldValue) {
            if (newValue === oldValue) {
                return;
            }

            if (checklistBeforeChange && (checklistBeforeChange(scope) === false)) {
                scope[attrs.ngModel] = contains(getter(scope.$parent), value, comparator);
                return;
            }

            setValueInChecklistModel(value, newValue);

            if (checklistChange) {
                checklistChange(scope);
            }
        });

        function setValueInChecklistModel(value, checked) {
            var current = getter(scope.$parent);
            if (angular.isFunction(setter)) {
                if (checked === true) {
                    setter(scope.$parent, add(current, value, comparator));
                } else {
                    setter(scope.$parent, remove(current, value, comparator));
                }
            }

        }

        // declare one function to be used for both $watch functions
        function setChecked(newArr, oldArr) {
            if (checklistBeforeChange && (checklistBeforeChange(scope) === false)) {
                setValueInChecklistModel(value, scope[attrs.ngModel]);
                return;
            }
            scope[attrs.ngModel] = contains(newArr, value, comparator);
        }

        // watch original model change
        // use the faster $watchCollection method if it's available
        if (angular.isFunction(scope.$parent.$watchCollection)) {
            scope.$parent.$watchCollection(checklistModel, setChecked);
        } else {
            scope.$parent.$watch(checklistModel, setChecked, true);
        }
    }

    return {
        restrict: 'A',
        priority: 1000,
        terminal: true,
        scope: true,
        compile: function(tElement, tAttrs) {
            if ((tElement[0].tagName !== 'INPUT' || tAttrs.type !== 'checkbox') && (tElement[0].tagName !== 'MD-CHECKBOX') && (!tAttrs.btnCheckbox)) {
                throw 'checklist-model should be applied to `input[type="checkbox"]` or `md-checkbox`.';
            }

            if (!tAttrs.checklistValue && !tAttrs.value) {
                throw 'You should provide `value` or `checklist-value`.';
            }

            // by default ngModel is 'checked', so we set it if not specified
            if (!tAttrs.ngModel) {
                // local scope var storing individual checkbox model
                tAttrs.$set("ngModel", "checked");
            }

            return postLinkFn;
        }
    };
}]);

/**
 * @example
 * <div class="col-md-6" ng-input-audio-comment ng-model="job.comment" parent-id="job.id" model="Job"></div>
 */
app.directive('ngInputAudioComment', function(dir, $http){
    let recorder;
    let last_start_time;

    function updateWaveImage(element) {
        let elem = $(element).children('.input-audio').children('div.wave').children('div');
        if (recorder && recorder.state === 'recording')
            elem.css('background-image', "url('assets/img/audio-wave.gif')")
        else elem.css('background-image', "url('assets/img/audio-wave.png')")
    }
    function startTimer(scope) {
        (function looper() {
            if(!recorder || recorder.state === 'destroyed' || recorder.state === 'stopped') { return; }
            scope.$apply(() => {
                scope.realtime_duration = recorder.state === 'paused' ? scope.total_duration :
                    scope.total_duration + (new Date().getTime() - last_start_time);
            });
            setTimeout(looper, 1000);
        })();
    }
    function bindStartButton(element, scope){
        $(element).children('.d-flex.input-text').children('a.mic').on("click", async function () {
            recorder = await getRecorder();
            if (recorder) scope.$apply(() => {
                scope.is_audio = true;
                scope.is_paused = false;
                scope.total_duration = 0;// except currently recording slice
            });
            recorder.startRecording();
            last_start_time = new Date().getTime();
            updateWaveImage(element);
            recorder.onStateChanged = function(state) { //  state can be: recording, paused, stopped or inactive, destroyed.
                console.log('Recorder state: ', state);
                updateWaveImage(element);
                if (state === 'recording') last_start_time = new Date().getTime();
                else if (state === 'paused' || state === 'stopped') scope.total_duration += new Date().getTime() - last_start_time;
            };
            startTimer(scope);
        });
    }
    function bindStopButton(element, scope, attrs) {
        $(element).children('.input-audio').children('.audio-controls').children('a.stop-rec').on("click", async function () {
            recorder.stopRecording(function () {
                console.log('url', recorder.toURL());
                recorder.microphone.stop();
                // scope.$apply(() => { scope.ngModel = recorder.toURL(); });

                console.log('recorder', recorder);

                let formData = new FormData();
                formData.append('file', recorder.getBlob());
                formData.append('parent_id', scope.parentId);
                formData.append('model', attrs.model);
                formData.append('duration', scope.total_duration);

                $http({
                    method: 'POST',
                    url: 'api/voices',
                    data: formData,
                    headers: { 'Content-Type': undefined },
                    uploadEventHandlers: {
                        progress: function(e) {
                            let progress = Math.round((e.loaded/e.total)*100);
                            console.log('uploading: '+progress+'%');
                        }
                    }
                }).then(function (response) {
                    console.log('success', response)
                    scope.ngModel = response.data.name;
                }, function (response) {
                    console.log('error', response)
                });
            });
        });
    }
    function bindPauseResumeButton(element, scope) {
        $(element).children('.input-audio').children('.audio-controls').children('a.pause-resume').on("click", async function () {
            if (recorder.state === 'recording') recorder.pauseRecording();
            else recorder.resumeRecording();
            scope.$apply(() => { scope.is_paused = recorder.state === 'paused'; });
        });
    }
    function bindDeleteButton(element, scope) {
        $(element).children('.input-audio').children('.audio-controls').children('a.delete').on("click", async function () {
            if (recorder) {
                recorder.microphone.stop();
                recorder.destroy();
            }
            $http({
                method: 'DELETE',
                url: 'api/voices/delete_by_name?name='+scope.ngModel,
            });
            scope.$apply(() => {
                scope.is_audio = false;
                scope.ngModel = null;
            });
        });
    }
    function isAudio(text) {
        return text && text.startsWith('voices/') && text.endsWith('.wav');
    }
    return {
        require: ['ngModel'],
        scope: {
            ngModel: '=',
            parentId: '=',
            model: '='
        },
        link: function(scope, element, attrs, ngModel){
            scope.is_audio = false;
            bindStartButton(element, scope);
            bindStopButton(element, scope,attrs);
            bindPauseResumeButton(element, scope);
            bindDeleteButton(element, scope);
            scope.$watch(() => { return scope.ngModel; }, (modelValue) => {
                if (scope.is_audio !== isAudio(modelValue)) {
                    scope.is_audio = isAudio(modelValue);
                    updateWaveImage();
                }
            });
        },
        template: function(elem, attr) {
            let params = dir.getParams(elem, attr);
            return  '<div class="row input-audio" ng-show="is_audio">'+
                        '<div class="col-12 d-flex wave">'+
                            '<h5 style="margin: 10px;" ng-bind="realtime_duration | timeToHuman"></h5>'+
                            '<div style="background-position: center;background-size: 40px; flex-grow: 100;"></div>'+
                        '</div>'+
                        '<div class="col-12 d-flex justify-content-between audio-controls">'+
                            '<a href="javascript:;" class="text-gray delete">'+
                                '<i class="material-icons" style="font-size: 40px">delete</i>'+
                            '</a>'+
                            '<a href="javascript:;" class="text-danger pause-resume">'+
                                '<i class="material-icons" style="font-size: 40px" ng-hide="is_paused">pause_circle_outline</i>'+
                                '<i class="material-icons" style="font-size: 40px" ng-show="is_paused">mic</i>'+
                            '</a>'+
                            '<a href="javascript:;" class="text-danger stop-rec">'+
                                '<i class="material-icons" style="font-size: 40px">stop_circle</i>'+
                            '</a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="d-flex input-text" ng-hide="is_audio">'+
                        '<div class="form-group bmd-form-group" style="flex-grow: 100">'+
                            '<input type="text" class="form-control" ng-model="ngModel" placeholder="'+params.placeholder+'">'+
                        '</div>'+
                        '<a href="javascript:;" class="text-gray mic">'+
                            '<i class="material-icons" style="font-size: 40px">mic_none</i>'+
                        '</a>'+
                    '</div>';
        }
    };
});
