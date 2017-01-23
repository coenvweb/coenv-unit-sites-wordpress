module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        includePaths: ['bower_components/foundation/scss']
      },
      dist: {
        options: {
          outputStyle: 'compressed'
        },
        files: {
          'css/app.css': 'scss/app.scss'
        }        
      }
    },
      
    bless: {
        css: {
            options: {
                // Task-specific options go here.
            },
            files: {
               'css/appie.css': 'css/app.css'
            }
        }
    },

    copy: {
      scripts: {
        expand: true,
        cwd: 'bower_components/',
        src: '**/*.js',
        dest: 'js'
      },

      maps: {
        expand: true,
        cwd: 'bower_components/',
        src: '**/*.map',
        dest: 'js'
      },
    },

    uglify: {
      dist: {
        files: {
          'js/modernizr/modernizr.min.js': ['js/modernizr/modernizr.js']
        }
      }
    },

    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [
          'js/foundation/js/foundation.min.js',
          'js/init-foundation.js',
		      'js/nivo-lightbox/nivo-lightbox.min.js',
		      'js/slick.js/slick/slick.min.js',
		      'js/share.js',
		      'js/main.js',
            './js/alert-closer.js',
          'js/wp-menufix.js',
          'js/isotope2.js',
          'js/imagesloaded.pkgd.min.js',
        ],

        dest: 'js/app.js',
      },

    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'scss/**/*.scss',
        tasks: ['sass'],
				options: {
					livereload: true
				}
      },
			css: {
				files: 'css/**/*.css',
				options: {
					livereload: true
				}
			},
			scripts: {
				files: ['js/**/*.js','js/wp-menufix.js'],
				tasks: [ 'uglify' ],
				options: {
					livereload: true
				}
			},
			files: {
				files: [
					'**/*.{html,php}'
				],
				options: {
					livereload: true
				}
			}
			
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-bless');  

  grunt.registerTask('build', ['sass']);
  grunt.registerTask('default', ['copy', 'uglify', 'concat', 'sass', 'bless', 'watch']);

}
