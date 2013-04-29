module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    /******** Copy ********/
    copy: {
      main: {
        files: [
          {src: ['src/init.php'], dest: 'build/init.php'},
          {expand: true, cwd: 'src/classes/', src: ['**'], dest: "build/classes"},
          {expand: true, cwd: 'src/assets/img', src: ['**'], dest: "build/assets/img"},
          {expand: true, cwd: 'src/assets/js', src: ['**'], dest: "build/assets/js"}
        ]
      }
    },

    /******** JSHint ********/
    jshint: {
      all: ['src/assets/js/*.js', 'src/classes/fields/**/js/*.js'],
      options: {
        curly: true,
        eqeqeq: true,
        eqnull: true,
        browser: true,
        unused: true,
        undef: true,
        devel: true,
        globals: {
          jQuery: true
        }
      }
    },

    /******** Uglify ********/
    uglify: {
      options: {
        //banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
        mangle: true
      },
      build: {
        files: {
          'build/classes/fields/datepicker/js/jmetadatepicker.init.min.js': ['src/classes/fields/datepicker/js/jmetadatepicker.init.js'],
          'build/classes/fields/color/js/jmetacolor.init.min.js': ['src/classes/fields/color/js/jmetacolor.init.js'],
          'build/classes/fields/upload/js/jmetaupload.init.min.js': ['src/classes/fields/upload/js/jmetaupload.init.js']
        }
      }
    },

    /******** Compass ********/
    compass: {
      dev: {
        options: {
          sassDir: 'src/assets/scss',
          cssDir: 'build/assets/css',
          imagesDir: 'build/assets/img',
          fontsDir: 'build/assets/fonts',
          outputStyle: 'compressed',
          noLineComments: true,
          require: [
            'rgbapng'
          ]
        }
      }
    },

    /******** Imagemin ********/
    imagemin: {
      dist: {
        options: {
          optimizationLevel: 3
        },
        files: {
          'build/assets/img': ['src/assets/img/*.*']
        }
      },
      dev: {
        options: {
          optimizationLevel: 0
        },
        files: {
          'build/assets/img': ['src/assets/img/*.*']
        }
      }
    },

    'sftp-deploy': {
      build: {
        auth: {
          host: 'ec2-46-137-59-133.eu-west-1.compute.amazonaws.com',
          port: 21,
          authKey: 'key'
        },
        src: 'build',
        dest: '/var/www/wp-content/themes/twentytwelve/metabox/build'
      }
    },

    /******** Watch ********/
    watch: {
      files: ['src/assets/scss/*.scss', 'src/assets/js/*.js', 'src/*', 'build'],
      tasks: ['compass', 'jshint', 'copy']
    }

  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.loadNpmTasks('grunt-contrib-compass');

  grunt.loadNpmTasks('grunt-contrib-jshint');

  grunt.loadNpmTasks('grunt-contrib-imagemin');

  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.loadNpmTasks('grunt-sftp-deploy');

  // Default task(s).
  grunt.registerTask('default', ['copy', 'jshint', 'uglify', 'compass', 'imagemin']);

};
