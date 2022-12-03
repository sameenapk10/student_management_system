app.directive('ngIntlTelInput', ['ngIntlTelInput', '$log', function (ngIntlTelInput, $log) {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, elm, attr, ctrl) {
            // Warning for bad directive usage.
            if (attr.type !== 'text' || elm[0].tagName !== 'INPUT') {
                $log.warn('ng-intl-tel-input can only be applied to a *text* input');
                return;
            }
            // Override default country.
            if (attr.defaultCountry) {
                ngIntlTelInput.set({defaultCountry: attr.defaultCountry});
            }
            // Initialize.
            ngIntlTelInput.init(elm);
            // Validation.
            ctrl.$validators.ngIntlTelInput = function (value) {
                // return elm.intlTelInput("isValidNumber");
                return true;
            };
            // Set model value to valid, formatted version.
            ctrl.$parsers.push(function (value) {
                // return elm.intlTelInput('getNumber').replace(/[^\d]/, '');

                let phone = elm.intlTelInput('getNumber').replace(/[^\d]/, '');
                phone = phone.startsWith('+') ? phone : '+'+phone;
                if (phone === '+') phone = null;
                return phone;
            });
            // Set input value to model value and trigger evaluation.
            ctrl.$formatters.push(function (value) {
                if (value) {
                    if (value.startsWith('+')) value = value.replace('+', '');
                    value = value.charAt(0) === '+' || '+' + value;
                    elm.intlTelInput('setNumber', value);
                }
                return value;
            });
        }
    };
}]);
