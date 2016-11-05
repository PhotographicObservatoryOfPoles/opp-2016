module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

   	// CONFIG ===================================/

	/* css tasks */
	compass: {
    	all: {
			options: {              
				sassDir: ['sass'],
			},
		}
    },
    autoprefixer: {
		dist: {
			files: {
				'style.css': 'style.css'
			}
		}
    },
	cssmin: {
		css: {
		    src: 'style.css',
		    dest: 'style.css'
		}
	},

    /* js tasks */
	uglify: {
		js: {
			files: {
	        	'js/acf-map.min.js': 'js/acf-map.js',
	        	'js/ajax-filter.min.js': 'js/ajax-filter.js',
	        	'js/hamburger-button.min.js': 'js/hamburger-button.js',
	        	'js/panel.min.js': 'js/panel.js',
	        	'js/smooth-scroll.min.js': 'js/smooth-scroll.js',
	    	}
		},
	},

	/* watch task (dev) */
    watch: {
		css: {
			files: ['**/*.{scss,sass}'],
			tasks: ['compass', 'autoprefixer', 'cssmin']
		},
		js: {
			files: ['js/**/*.js'],
			tasks: ['uglify']
		},
    }

  });

  // DEPENDENT PLUGINS =========================/

	grunt.loadNpmTasks('grunt-contrib-compass');
  	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
  	grunt.loadNpmTasks('grunt-contrib-uglify');
 	grunt.loadNpmTasks('grunt-contrib-watch');

  // TASKS =====================================/

  grunt.registerTask('default', ['watch']);
  grunt.registerTask('dev', ['watch']);
  grunt.registerTask('prod', ['compass', 'autoprefixer', 'cssmin', 'uglify']);

};