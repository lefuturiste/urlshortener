<?php
/*
* Application's router
* Using php7, Slim3
*
* @author lefuturiste <contact@lefuturiste.fr>
* @version 1.0
*
**/
require '../vendor/autoload.php';

$config = \App\Config::get();

$app = new \Slim\App([
    'settings' => [
    	'displayErrorDetails' => $config['app_debug']
	]
]);

require '../App/container.php';

$app->get('/', App\Controllers\UrlShortenerController::class . ':getBaseUrl');

$app->get('/{uuid}', App\Controllers\UrlShortenerController::class . ':getUrl');

$app->group('/api', function (){
	$this->group('/urls', function (){
		$this->get('/', \App\Controllers\UrlShortenerApiController::class . ':index')->setName('urls.index');
		$this->post('/', \App\Controllers\UrlShortenerApiController::class . ':store')->setName('urls.store');
		$this->post('/update/{uuid}', \App\Controllers\UrlShortenerApiController::class . ':update')->setName('urls.update');
		$this->get('/{uuid}', \App\Controllers\UrlShortenerApiController::class . ':show')->setName('urls.show');
		$this->delete('/{uuid}', \App\Controllers\UrlShortenerApiController::class . ':destroy')->setName('urls.destroy');
	});
})->add(new \App\Middlewares\Authorisation($container));

$app->run();