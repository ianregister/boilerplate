module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
		concat: {
			options: {
				  separator: ''
			},
	        config: {
				files: {
			        'js/structure.min.js': ['js/libs/underscore.js',
			        							'js/libs/backbone.js'],
			        'js/libraries.min.js': ['js/libs/jquery-1.11.1.min.js',
			        							'js/libs/jquery.migrate.1.2.1.min.js'],
			        'js/plugins.min.js': [	'js/plugins/jquery.flexslider.2.2.2.js',
			        							'js/plugins/jquery.unveil.min.js',
			        							//'js/plugins/jquery.dropit.min.js',
			        							'js/plugins/jquery.validate.min.js'	],
				}
	        },
	        main: {
				files: {
			        'js/main.min.js': ['js/main/config.js','js/main/router.js','js/main/actions.js','js/main/initialise.js','js/main/functions.js'],
				}
	        }
		},
		uglify: {
			options: {
				mangle: {
					except: ['jQuery', 'Backbone'],
				}
			},
			js: {
				files: {
					'js/main.min.js': ['js/main.min.js'],
				}
			}
		},
        sass: {
			options: {
				outputStyle: 'compressed',
			    //sourceComments: 'map'
				//style: 'compressed',
				//quiet: true
				//require: 'susy'
			},
			'css/styles.css': ['sass/styles.scss'],
        },
        watch: {
            sass: {
                files: ['sass/**/*.{scss,sass}'],
                tasks: ['sass']
            },
            js: {
	            files: ['js/main/*.js'],
	            tasks: ['concat:main','uglify:js']
            }
	    },
        browserSync: {
            files : ['**/*.php','css/styles.css', 'js/main.min.js' ],
            options: {
                watchTask: true,
                notify: false,
                logSnippet: false,
                port:3000,
                host: 'boilerplate.site',
                }
        },
    });
    grunt.registerTask('default', ['browserSync','watch']);
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-browser-sync');
};