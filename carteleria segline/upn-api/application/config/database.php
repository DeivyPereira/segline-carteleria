<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	/*
	'hostname' => 'localhost',
	'username' => 'u162200389_sigem',
	'password' => 'vocL5w5xpAhH',
	'database' => 'u162200389_sigem',
	*/
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'nb5ejwAeJAZ5kN',
	'database' => 'upn-tv',
	
	
    'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);



