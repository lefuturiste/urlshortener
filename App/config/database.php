<?php
return [
	'mysql' => [
		'host' => getenv('MYSQL_HOST'),
		'username' => getenv('MYSQL_USERNAME'),
		'password' => getenv('MYSQL_PASSWORD'),
		'database' => getenv('MYSQL_DATABASE'),
	]
];