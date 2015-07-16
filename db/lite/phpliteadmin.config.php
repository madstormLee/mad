<?php 
$password = 'admin';
$directory = 'xp/';
$subdirectories = false;

$databases = array(
	array(
		'path'=> 'data.db',
		'name'=> 'Database 2'
	),
);

$theme = 'phpliteadmin.css';
$language = 'en';

$rowsNum = 30;
$charsNum = 300;

$custom_functions = array(
	'md5', 'sha1', 'time', 'strtotime',
);

$cookie_name = 'pla3412';
$debug = false;
$allowed_extensions = array('db','db3','sqlite','sqlite3');
