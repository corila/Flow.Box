module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			feCss: {
				src: [
					'Resources/Private/Styles/Bootstrap/3.0.0/bootstrap.css',
					'Resources/Private/Styles/select2.min.css',
					'Resources/Private/Styles/Bootstrap/3.0.0/bootstrap-glyphicons.css',
					'Resources/Private/Styles/prettify.css',
					'Resources/Private/Styles/style.css',
					'Resources/Private/Styles/devices_style.css',
				],
				dest: 'Resources/Public/Css/Style.css'
			},
			beCss: {
				src: [
					'Resources/Private/Styles/Bootstrap/3.0.0/bootstrap.css',
					'Resources/Private/Styles/select2.min.css',
					'Resources/Private/Styles/datepicker.css',
					'Resources/Private/Styles/Bootstrap/3.0.0/bootstrap-glyphicons.css',
					'Resources/Private/Styles/prettify.css',
					'Resources/Private/Styles/backend-style.css',
				],
				dest: 'Resources/Public/Css/BeStyle.css'
			}
		},
		watch: {
			feJs: {
				files: ['Resources/Public/JavaScript/script.js'],
				tasks: ['uglify:feJs']
			},
			beJs: {
				files: ['Resources/Public/JavaScript/backend-script.js'],
				tasks: ['uglify:beJS']
			},
			feCss: {
				files: [
					'Resources/Private/Styles/style.css'
				],
				tasks: ['concat:feCss']
			},
			beCss: {
				files: [
					'Resources/Private/Styles/backend-style.css'
				],
				tasks: ['concat:beCss']
			}
		},
		uglify: {
			feJs: {
				src: [
					'Resources/Public/JavaScript/JQuery/1.10.2/jquery.min.js',
					'Resources/Public/JavaScript/select2.full.js',
					'Resources/Public/JavaScript/JQuery-validation/jquery.validate.min.js',
					'Resources/Public/JavaScript/Bootstrap/3.0.0/bootstrap.min.js',
					'Resources/Public/JavaScript/prettify.min.js',
					'Resources/Public/JavaScript/ie10-viewport-bug-workaround.js',
					'Resources/Public/JavaScript/script.js',
				],
				dest: 'Resources/Public/JavaScript/Script.min.js'
			},
			beJS: {
				src: 'Resources/Public/JavaScript/backend-script.js',
				dest: 'Resources/Public/JavaScript/BackendScript.min.js'
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['concat', 'uglify', 'watch']);
};
