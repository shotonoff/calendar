(function (ng) {
    var app = ng.module('aulinks'),
        errorSWW = 'Something went wrong';

    function errorResponseHandler($scope, resp) {
        if (!resp.data.error) {
            return;
        }
        var errors = resp.data.error;
        for (var i in errors) {
            for (var j = 0; j < errors[i].length; j++) {
                $scope.addAlert(errors[i][j], 'danger')
            }
        }
    }

    function alertMixin($scope) {
        $scope.alerts = [];
        $scope.alertClose = function (index, alert) {
            console.log(index)
            $scope.alerts = $scope.alerts.slice(0, index).concat($scope.alerts.slice(index + 1))
        };
        $scope.addAlert = function (label, type) {
            if (undefined === type) {
                type = 'info';
            }
            $scope.alerts.push({label: label, type: type})
        }
    }

    app.controller('LoginCtrl', ['$scope', '$http', '$location', '$rootScope', 'AuthService',
        function ($scope, $http, $location, $rootScope, authService) {
            alertMixin($scope)
            if ($rootScope.isAuthenticated) {
                $location.path('/');
                return;
            }

            $scope.submit = function (form) {
                if (form.$invalid) {
                    return;
                }

                authService.login($scope.user.username, $scope.user.password)
                    .then(function (data) {
                        $scope.badCredentials = false;
                        $location.path('/')
                    }, function () {
                        $scope.addAlert('Bad credentials', 'danger');
                    });
            };
        }]);
    app.controller('LogoutCtrl', ['$scope', '$rootScope', 'AuthService', '$location',
        function ($scope, $rootScope, authService, $location) {
            if (!$rootScope.isAuthenticated) {
                $location.path('/login');
                return;
            }
            authService.logout();
            $location.path('/login');
        }]);

    app.controller('MainCtrl', ['$scope', '$location', function ($scope, $location) {
        $location.path('/events');
    }]);

    app.controller('EventsCalendarCtrl', ['$scope', 'EventRepository', '$location',
        function ($scope, eventRepository, $location) {
            alertMixin($scope);
            $scope.eventSources = [
                {
                    events: function (start, end, timezone, callback) {
                        eventRepository.feed({
                            start: start.format('YYYY-MM-DD'),
                            end: end.format('YYYY-MM-DD'),
                        }).then(function (resp) {
                            var events = [];
                            var len = resp.data.length, event;
                            for (var i = 0; i < len; i++) {
                                events.push(resp.data[i]);
                            }
                            callback(events);
                        }, function (resp) {
                            errorResponseHandler($scope, resp);
                        })
                    }
                }
            ];
            $scope.uiConfig = {
                calendar: {
                    editable: true,
                    header: {
                        center: 'title',
                    },
                    eventClick: function (e) {
                        $location.path('/events/' + e.id + '/edit');
                    },
                    eventDrop: function (event) {
                        eventRepository.changeDate(event.id, event.start)
                            .then(null, function (resp) {
                                console.log(resp);
                            });
                    }
                }
            };

        }]);

    function eventBaseController($scope, eventRepository, $location) {
        $scope.allowDelete = function () {
            return false;
        };
        $scope.statuses = [
            {code: 1, label: 'New'},
            {code: 2, label: 'In Progress'},
            {code: 3, label: 'Done'},
        ];
        $scope.deleteEvent = function () {
            eventRepository.delete($scope.event.id)
                .then(function (resp) {
                    $location.path('/calendar');
                }, function (resp) {
                    errorResponseHandler($scope, resp)
                });
        };
    }

    app.controller('EventCreateCtrl', ['$scope', 'EventRepository', '$location',
        function ($scope, eventRepository, $location) {
            eventBaseController($scope, eventRepository, $location);
            $scope.event = {status: 1, colorHex: '#85ffe2', date: moment().format('YYYY-MM-DD hh:mm:ss')};
            $scope.submit = function (form) {
                if (form.$invalid) {
                    return;
                }
                eventRepository.save($scope.event)
                    .then(function (resp) {
                        $location.path('/events')
                    }, function (resp) {
                        errorResponseHandler($scope, resp);
                    });
            };
        }]);

    app.controller('EventEditCtrl', ['$scope', 'EventRepository', '$location', '$routeParams',
        function ($scope, eventRepository, $location, $routeParams) {
            eventBaseController($scope, eventRepository);
            alertMixin($scope);
            eventRepository.get($routeParams.id)
                .then(function (resp) {
                    $scope.event = resp.data;
                }, function (resp) {
                    console.log(resp)
                });
            $scope.allowDelete = function () {
                return true;
            };
            $scope.submit = function () {
                eventRepository.save($scope.event)
                    .then(function (resp) {
                        $scope.addAlert('Saved', 'success')
                    }, function (resp) {
                        errorResponseHandler($scope, resp);
                    });
            }
        }]);

    app.controller('InviteCreateCtrl', ['$scope', 'InviteRepository',
        function ($scope, repository) {
            alertMixin($scope);

            $scope.invite = {};
            $scope.submit = function () {
                repository.save($scope.invite)
                    .then(function (resp) {
                        $scope.addAlert('Invite was success sent to "' + $scope.invite.email + '"')
                    }, function (resp) {
                        console.log(resp);
                    });
            }
        }]);

    app.controller('InviteListCtrl', ['$scope', 'InviteRepository', function ($scope, repository) {
        $scope.invites = [];
        repository.all()
            .then(function (resp) {
                $scope.invites = resp.data;
            }, function (resp) {
                console.log(resp)
            })
    }]);

    app.controller('UserRegistrationCtrl', ['$scope', 'UserRepository', '$routeParams', '$location',
        function ($scope, repository, $routeParams, $location) {
            $scope.user = {
                token: $routeParams.token
            };
            $scope.submit = function () {
                repository.registration($scope.user)
                    .then(function (resp) {
                        $location.path('/login')
                    }, function (resp) {
                        console.log(resp);
                    });
            };
        }
    ]);

    app.controller('UserListCtrl', ['$scope', 'UserRepository', function ($scope, repository) {

        $scope.users = [];
        repository.all()
            .then(function (resp) {
                $scope.users = resp.data;
            }, function (resp) {
                console.log(resp)
            })
    }]);

    function userControllerBase($scope, repo) {
        $scope.submit = function () {
            repo.save($scope.user).success(function (data) {
                // move to category/edit
            });
        };
    }

    app.controller('UserEditCtrl', ['$scope', 'UserRepository', '$routeParams',
        function ($scope, repository, $routeParams) {
            var rolesMap = {
                1: 'Admin'
            };
            alertMixin($scope);
            repository.get($routeParams.id)
                .then(function (resp) {
                    $scope.user = resp.data;
                }, function (resp) {
                    $scope.addAlert(errorSWW, 'danger');
                    console.log(resp);
                });
            $scope.submit = function (form) {
                repository.save($scope.user);
            };
            $scope.codeToStr = function (code) {
                return rolesMap[code];
            }
        }]);

})(angular)