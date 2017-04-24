(function (ng) {
    var app = ng.module('aulinks');

    app.directive('dateTimePicker', function () {
        return {
            require: 'ngModel',
            restrict: 'AE',
            scope: {
                format: '@',
            },
            link: function (scope, elem, attrs, ctrl) {
                if (!scope.format) {
                    scope.format = 'YYYY-MM-DD HH:mm:ss';
                }
                $(elem).datetimepicker({
                    format: scope.format,
                }).on('dp.change', function (e) {
                    ctrl.$setViewValue(e.date.format(scope.format));
                });
            }
        };
    });

    app.directive('colorPicker', function () {
        return {
            require: 'ngModel',
            restrict: 'AE',
            scope: {
                model: '=ngModel'
            },
            link: function (scope, elem, attrs, ctrl) {
                var $el = $(elem);
                $el.spectrum({
                    showInput: true,
                    change: function (color) {
                        ctrl.$setViewValue(color.toHexString());
                    }
                });
                ctrl.$render = function () {
                    if (ctrl.$viewValue == undefined) {
                        return;
                    }
                    $el.spectrum("set", scope.model)
                }
            }
        };
    });

    app.directive("compareTo", function () {
        return {
            require: "ngModel",
            scope: {
                otherModelValue: "=compareTo"
            },
            link: function (scope, element, attributes, ngModel) {

                ngModel.$validators.compareTo = function (modelValue) {
                    return modelValue == scope.otherModelValue;
                };

                scope.$watch("otherModelValue", function () {
                    ngModel.$validate();
                });
            }
        };
    });

    app.directive("alerts", function () {
        return {
            templateUrl: '/pages/alert.html',
            restrict: 'E',
            scope: {
                alerts: "=values"
            },
            link: function (scope, element, attributes, ngModel) {
                scope.alertClose = function (index, alert) {
                    scope.alerts = scope.alerts.slice(0, index).concat(scope.alerts.slice(index + 1))
                };
            }
        };
    });
})(angular)
