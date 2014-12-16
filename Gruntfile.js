'use strict';

module.exports = function(grunt) {

    grunt.file.defaultEncoding = 'utf-8';

    // Project configuration.
    grunt.initConfig({
        dirs: {
            bower: 'Resources/Public/BowerComponents',
            js: {
                src: 'Resources/Public/Javascript/Compiled',
                dest: 'Resources/Public/Javascript'
            },
            coffee: {
                src: 'Resources/Private/Coffeescript',
                dest: 'Resources/Public/Javascript/Compiled'
            },
            sass: {
                src: 'Resources/Private/Styles',
                dest: 'Resources/Public/Css'
            }
        },
        compass: {
            dist: {
                options: {
                    config: 'config.rb'
                }
            }
        },
        uglify: {
            dist: {
                src: [
                    '<%= dirs.js.src %>/*.js'
                ],
                dest: '<%= dirs.js.dest %>/app.min.js',
                options: {
                    sourceMap: '<%= dirs.js.dest %>/app.min.map',
                    sourceMappingURL: 'app.min.map',
                    sourceMapPrefix: 3
                }
            }
        },
        concat: {
            dist: {
                src: [
                    '<%= dirs.bower %>/jquery/jquery.min.js'
                ],
                dest: '<%= dirs.js.dest %>/libs.min.js'
            }
        },
        coffee: {
            compile: {
                options: {
                    bare: false,
                    sourceMap: true
                },
                files: {
                    '<%= dirs.coffee.dest %>/script.js': '<%= dirs.coffee.src %>*//***/*//*.coffee'
                }
            }
        },
        watch: {
            coffee: {
                files: ['<%= dirs.coffee.src %>/**/*.coffee'],
                tasks: ['coffee', 'uglify']
            },
            sass: {
                files: ['<%= dirs.sass.src %>/**/*.scss'],
                tasks: 'compass'
            }
        }
    });

    // Load the plugin that provides the "concat" task.
    grunt.loadNpmTasks('grunt-contrib-concat');

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Load the plugin that provides the "watch" task.
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Load the plugin that provides the "compass" task.
    grunt.loadNpmTasks('grunt-contrib-compass');

    // Load the plugin that provides the "coffee" task.
    grunt.loadNpmTasks('grunt-contrib-coffee');

    // Load the plugin that provides the "copy" task.
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Default task.
    grunt.registerTask('default', ['build', 'watch']);

    // Build task.
    grunt.registerTask('build', ['compass', 'coffee', 'uglify', 'concat']);
}
