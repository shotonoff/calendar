(function (ng) {
    ng.module('aulinks', ['ngRoute', 'angular-jwt', 'ui.calendar'])
        .config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
        })
        .config(function Config($httpProvider, jwtOptionsProvider) {
            jwtOptionsProvider.config({
                tokenGetter: [function () {
                    return localStorage.getItem('id_token');
                }],
            });

            $httpProvider.interceptors.push('jwtInterceptor');
        })
        .config(function ($routeProvider) {
            $routeProvider
                .when('/', {
                    template: '',
                    controller: 'MainCtrl'
                })
                .when('/login', {
                    templateUrl: 'pages/user/login.html',
                    controller: 'LoginCtrl'
                })
                .when('/logout', {
                    template: '',
                    controller: 'LogoutCtrl'
                })
                .when('/events', {
                    templateUrl: 'pages/event/calendar.html',
                    controller: 'EventsCalendarCtrl'
                })
                .when('/events/create', {
                    templateUrl: 'pages/event/form.html',
                    controller: 'EventCreateCtrl'
                })
                .when('/events/:id/edit', {
                    templateUrl: 'pages/event/form.html',
                    controller: 'EventEditCtrl'
                })
                .when('/registration', {
                    templateUrl: 'pages/user/registration.html',
                    controller: 'UserRegistrationCtrl'
                })
                .when('/users', {
                    templateUrl: 'pages/user/list.html',
                    controller: 'UserListCtrl'
                })
                .when('/users/:id/edit', {
                    templateUrl: 'pages/user/form.html',
                    controller: 'UserEditCtrl'
                })
                .when('/invite/create', {
                    templateUrl: 'pages/invite/form.html',
                    controller: 'InviteCreateCtrl'
                })
                .when('/invites', {
                    templateUrl: 'pages/invite/list.html',
                    controller: 'InviteListCtrl'
                })
                .otherwise({redirectTo: '/'});
        })
        .factory('EventRepository', ['$http', function ($http) {
            return {
                save: function (data) {
                    if (undefined !== data.id) {
                        return $http.patch('/_api/v1/events/' + data.id, data);
                    }
                    return $http.post('/_api/v1/events', data);
                },
                all: function () {
                    return $http.get('/_api/v1/events');
                },
                feed: function (period) {
                    if (undefined === period.start || undefined === period.end) {
                        throw 'Missing required fields in query'
                    }
                    return $http.get('/_api/v1/events/feed?' + $.param(period));
                },
                get: function (id) {
                    return $http.get('/_api/v1/events/' + id);
                },
                delete: function (id) {
                    return $http.delete('/_api/v1/events/' + id);
                }
            };
        }])
        .factory('AuthService', ['$http', '$q', 'authManager', function ($http, $q, authManager) {
            var permissions;

            function loadPermissions() {
                permissions = localStorage.getItem('permissions');
                if (permissions === null) {
                    permissions = [];
                    return
                }
                permissions = permissions.split(',');

            }

            loadPermissions();

            function save(data) {
                localStorage.setItem('id_token', data.token);
                localStorage.setItem('id_token_expired', data.expired);
                localStorage.setItem('permissions', data.permissions);
            }

            function clear() {
                localStorage.removeItem('id_token');
                localStorage.removeItem('id_token_expired');
                localStorage.removeItem('permissions');
            }

            return {
                login: function (username, password) {
                    var deferred = $q.defer();
                    $http({
                        method: 'POST',
                        url: '/_api/v1/token',
                        withCredentials: true,
                        headers: {
                            'Content-Type': 'application/json; charset=utf-8',
                            'Authorization': 'Basic ' + btoa(username + ':' + password)
                        }
                    }).then(function (resp) {
                        save(resp.data);
                        loadPermissions();
                        deferred.resolve(resp.data)
                    }, function () {
                        deferred.reject();
                    });
                    return deferred.promise;
                },
                logout: function () {
                    clear();
                    authManager.unauthenticate()
                },
                isGranted: function (perms) {
                    for (var i = 0; i < perms.length; i++) {
                        if (-1 !== permissions.indexOf(perms[i])) {
                            return true;
                        }
                    }
                    return false;
                }
            }
        }])
        .factory('UserRepository', ['$http', function ($http) {
            return {
                registration: function (data) {
                    return $http.post('/registration', data);
                },
                save: function (data) {
                    if (undefined !== data.id) {
                        return $http.put('/_api/v1/users/' + data.id, data);
                    }
                    return $http.post('/_api/v1/users', data);
                },
                all: function () {
                    return $http.get('/_api/v1/users');
                },
                get: function (id) {
                    return $http.get('/_api/v1/users/' + id);
                }
            };
        }])
        .factory('InviteRepository', ['$http', function ($http) {
            return {
                save: function (data) {
                    if (undefined !== data.id) {
                        return $http.patch('/_api/v1/invites/' + data.id, data);
                    }
                    return $http.post('/_api/v1/invites', data);
                },
                all: function () {
                    return $http.get('/_api/v1/invites');
                },
                get: function (id) {
                    return $http.get('/_api/v1/invites/' + id);
                }
            };
        }])
        .run(function (authManager, AuthService, $rootScope, $location) {
            authManager.checkAuthOnRefresh();
            $rootScope.$on('$routeChangeStart', function (event, next, current) {
                if (!$rootScope.isAuthenticated
                    && next.templateUrl != 'pages/user/login.html'
                    && next.originalPath != "/registration") {
                    $location.path('/login');
                }
            });
            $rootScope.isGranted = function () {
                if (!authManager.isAuthenticated()) {
                    return false;
                }
                return AuthService.isGranted.call(AuthService, arguments);
            }
        });
})(angular)