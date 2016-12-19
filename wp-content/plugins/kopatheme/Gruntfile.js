module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    jshint: {
      options: {
        reporter: require('jshint-stylish')
      }
    },
    uglify: {
      options: {
        banner: '',
      },
      assets: {
        files: {                    
          'assets/compiled/kopatheme.min.js': 'assets/compiled/kopatheme.js'          
        }
      }
    },
    cssmin: {
      options: {
        keepSpecialComments: 0
      },
      target: {
        files: {
          'assets/compiled/kopatheme.min.css': ['assets/compiled/kopatheme.css']
        }
      }
    },
    concat: {
      options: {
        separator: '',
        stripBanners: true,
        banner: '',
      },
      css: {
        src: ['assets/css/*.min.css'],
        dest: 'assets/compiled/kopatheme.css',
      },
      js:{
      	src: ['assets/js/*.min.js'],
      	dest: 'assets/compiled/kopatheme.js'
      }      
    },
    assets: ['Grunfile.js']
  });
  
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch'); 
  grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.registerTask('default', ['concat:css', 'concat:js', 'uglify', 'cssmin']);
};