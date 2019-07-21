'use strict';
module.exports = function(grunt) {
	grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        
        processpy: {
            sql: [{
                file: './doc/sql/mysql.sql', 
                folder: './doc/sql/mysql'
            }]
        }
    });
    
	grunt.loadNpmTasks('grunt-contrib-processpy');
};
