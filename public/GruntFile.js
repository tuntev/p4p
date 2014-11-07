module.exports = function(grunt){
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // configure the task
        // concat the .min libraries
        concat: {
            prod: {
                files: {
                    'javascripts/dev/prod-lib-head.min.js': [
                        'javascripts/lib/angular/angular.min.js',
                        'javascripts/lib/angular/angular-route.min.js',
                        'javascripts/lib/angular/angular-sanitize.min.js'
                    ],
                    'javascripts/dev/prod-lib-foot.min.js': [
                        'javascripts/lib/jquery/jquery.min.js',
                        'javascripts/lib/underscore/underscore-min.js',
                        'javascripts/lib/bootstrap/bootstrap.min.js',
                        'javascripts/lib/bootstrap/ui-bootstrap-tpls-0.11.2.min.js',
                        'javascripts/lib/dialogs/dialogs.min.js'
                    ],
                    'javascripts/dev/prod.js': [
                        'javascripts/*.js'
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