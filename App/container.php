<?php
// Get container
$container = $app->getContainer();

$container['config'] = function ($container) use ($config) {
	return \App\Config::get();
};

$container['db'] = function ($container) {
	return new \Simplon\Mysql\Mysql(
		$container->config['mysql']['host'],
		$container->config['mysql']['username'],
		$container->config['mysql']['password'],
		$container->config['mysql']['database']
	);
};