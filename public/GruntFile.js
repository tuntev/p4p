module.exports = function(grunt){
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // configure the task
        // concat the .min libraries
        concat: {
            prod: {
                files: {
                    'javascripts/dev/prod-lib-head.min.js': [
                        'bower_components/angular/angular.min.js',
                        'bower_components/angular-route/angular-route.min.js',
                        'bower_components/angular-sanitize/angular-sanitize.min.js'
                    ],
                    'javascripts/dev/prod-lib-foot.min.js': [
                        'bower_components/jquery/dist/jquery.min.js',
                        'bower_components/underscore/underscore-min.js',
                        'bower_components/bootstrap/dist/js/bootstrap.min.js',
                        'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
                        'bower_components/angular-dialog-service/dist/dialogs.min.js',
                        'javascripts/lib/jquery.timeago.js'
                    ],
                    'javascripts/dev/prod.js': [
                        'javascripts/*.js'
                    ],
                    'styles/dev/prod-styles.css': [
                        'bower_components/bootstrap/dist/css/bootstrap.min.css',
                        'bower_components/bootstrap-social/bootstrap-social.css'
                    ]
                }
            }
        },

        // uglify the user angular javascripts
        uglify: {
            prod: {
                files: {
                    'javascripts/dev/prod.min.js': [
                        'javascripts/*.js'
                    ]
                }
            }
        },

        // minify the css
        cssmin: {
            prod: {
                files: {
                    'styles/main.min.css': 'styles/main.css'
                }
            }
        }
    });

    // load the task
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // load a custom task
    grunt.loadTasks('tasks');

    // setup the workflow
    grunt.registerTask('default',['concat','uglify','cssmin']);
};