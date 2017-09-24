<?php

namespace App\Middlewares;

use Symfony\Component\Yaml\Yaml;


class Authorisation
{

	/**
	 * AdminAuthorisation constructor.
	 * @param $container
	 * @param string $file
	 */
	public function __construct($container, $file = '../auth.yml')
	{
		$this->file = $file;
		$this->container = $container;

		//parsing auth file
		$this->auth = Yaml::parse(file_get_contents($file))['auth'];
	}

	/**
	 * @param $request
	 * @param $response
	 * @param $next
	 * @return mixed
	 */
	public function __invoke($request, $response, $next)
	{
		if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
			if (array_search($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW'], $this->auth) !== false) {
				return $next($request, $response);
			} else {
				return $response->write('Error with authentification : incorect authentification')->withStatus(401);
			}
		} else {
			return $response->write('Error with authentification : no authentification provided')->withStatus(401);
		}
	}
}