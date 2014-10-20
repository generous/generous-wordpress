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
            pub: {
              src: '<%=wp_g.assets.path.src%>/js/public/**/*.js',
              dest: '<%=wp_g.assets.path.build%>/js/wp-generous.dev.js',
              min: '<%=wp_g.assets.path.build%>/js/wp-generous.js'
            }
          },
          sass: {
            pub: {
              src: '<%=wp_g.assets.path.src%>/sass/public.scss',
              dest: '<%=wp_g.assets.path.build%>/css/wp-generous.css'
            }
          }
        }
      }
    },
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      pub: {
        options: {
          separator: '\n\n'
        },
        src: '<%=wp_g.assets.paths.js.pub.src%>',
        dest: '<%=wp_g.assets.paths.js.pub.dest%>'
      }
    },
    uglify: {
      dist: {
        files: {
          '<%=wp_g.assets.paths.js.pub.min%>': ['<%=wp_g.assets.paths.js.pub.dest%>']
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
          '<%=wp_g.assets.paths.sass.pub.dest%>': '<%=wp_g.assets.paths.sass.pub.src%>'
        }
      }
    },
    clean: {
      build: ['<%=wp_g.assets.paths.js.pub.dest%>']
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