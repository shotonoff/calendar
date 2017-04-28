module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'public/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/bootstrap.js': 'bootswatch-dist/js/bootstrap.js',
                    'js/angular.js': 'angular/angular.min.js',
                    'js/angular-route.js': 'angular-route/angular-route.js',
                    'js/angular-jwt.js': 'angular-jwt/dist/angular-jwt.min.js',
                    'js/moment.js': 'moment/min/moment.min.js',
                    'js/fullcalendar.js': 'fullcalendar/dist/fullcalendar.js',
                    'js/fullcalendar-gcal.js': 'fullcalendar/dist/gcal.js',
                    'js/bootstrap-datetimepicker.js': 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                    'js/spectrum.js': 'spectrum/spectrum.js',
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootswatch-dist/css/bootstrap.css',
                    'css/fullcalendar.css': 'fullcalendar/dist/fullcalendar.css',
                    'css/bootstrap-datetimepicker.css': 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css',
                    'css/spectrum.css': 'spectrum/spectrum.css',
                    'css/sp-dark.css': 'spectrum/themes/sp-dark.css',
                }
            },
            fonts: {
                files: {
                    'fonts': 'bootswatch-dist/fonts'
                }
            }
        },
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.registerTask('install', ['bowercopy']);
};
