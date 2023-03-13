<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = [
	'dsn'			=> '',
	'hostname' 		=> $_ENV["DB_HOSTNAME"],
	'port' 			=> $_ENV["DB_PORT"],
	'username' 		=> $_ENV["DB_USERNAME"],
	'password' 		=> $_ENV["DB_PASSWORD"],
	'database' 		=> $_ENV["DB_NAME"],
	'dbdriver' 		=> $_ENV["DB_DRIVER"],
	'dbprefix' 		=> '',
	'pconnect' 		=> FALSE,
	'db_debug' 		=> TRUE,
	'cache_on' 		=> FALSE,
	'cachedir' 		=> '',
	'char_set' 		=> 'utf8',
	'dbcollat' 		=> 'utf8_general_ci',
	'swap_pre' 		=> '',
	'encrypt' 		=> FALSE,
	'compress' 		=> FALSE,
	'stricton' 		=> FALSE,
	'failover' 		=> [],
	'save_queries' 	=> TRUE,
];
