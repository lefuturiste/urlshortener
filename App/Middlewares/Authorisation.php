<?php

namespace App\Middlewares;

class Authorisation
{

	/**
	 * AdminAuthorisation constructor.
	 */
	public function __construct($container)
	{
		$this->container = $container;
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
			if ($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW'] == $this->container->config['api_auth']) {
				return $next($request, $response);
			} else {
				return $response->write('Error with authentification : incorect authentification')->withStatus(401);
			}
		} else {
			return $response->write('Error with authentification : no authentification provided')->withStatus(401);
		}
	}
}