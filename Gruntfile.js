module.exports = function(grunt) {

  grunt.initConfig({
    wp_g: {
      assets: {
        path: {
          src: 'assets/src',
          build: 'assets'
        },
        paths: {
          js: {
            frontend: {
              src: '<%=wp_g.assets.path.src%>/js/public/**/*.js',
              dest: '<%=wp_g.assets.path.build%>/js/wp-generous.js',
              min: '<%=wp_g.assets.path.build%>/js/wp-generous.min.js'
            }
          },
          sass: {
            frontend: {
              src: '<%=wp_g.assets.path.src%>/sass/public.scss',
              dest: '<%=wp_g.assets.path.build%>/css/wp-generous.css'
            }
          }
        }
      }
    },
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      frontend: {
        options: {
          separator: '\n\n'
        },
        src: '<%=wp_g.assets.paths.js.frontend.src%>',
        dest: '<%=wp_g.assets.paths.js.frontend.dest%>'
      }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> (<%= pkg.version %>) */\n'
      },
      dist: {
        files: {
          '<%=wp_g.assets.paths.js.frontend.min%>': ['<%=wp_g.assets.paths.js.frontend.dest%>']
        }
      }
    },
    sass: {
      dist: {
        options: {
          style: 'compressed',
          noCache: false,
          sourcemap: 'none'
        },
        files: {
          '<%=wp_g.assets.paths.sass.frontend.dest%>': '<%=wp_g.assets.paths.sass.frontend.src%>'
        }
      }
    },
    clean: {
      build: ['<%=wp_g.assets.paths.js.frontend.dest%>']
    },
    watch: {
      scss: {
        files: ['<%=wp_g.assets.path.src%>/sass/**/*.scss'],
        tasks: ['sass']
      },
      concat: {
        files: ['<%=wp_g.assets.path.src%>/js/**/*.js'],
        tasks: ['concat']
      },
      uglify: {
        files: ['<%=wp_g.assets.path.src%>/js/**/*.js'],
        tasks: ['uglify']
      },
      clean: {
        files: ['<%=wp_g.assets.path.build%>/js/**/*.js'],
        tasks: ['clean']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', [
    'concat',
    'sass',
    'uglify',
    'clean',
    'watch'
  ]);
  
};