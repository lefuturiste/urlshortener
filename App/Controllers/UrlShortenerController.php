<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UrlShortenerController extends Controller
{
	public function getUrl(RequestInterface $request, ResponseInterface $response, $args)
	{
		$req = $this->db->fetchColumn('SELECT redirect FROM urls WHERE uuid = :uuid', ['uuid' => $args['uuid']]);
		if (!empty($req)) {
			return $response->withRedirect($req);
		} else {
			$body = $response->getBody();
			$body->write('Link not found');

			return $response->withStatus(404);
		}
	}

	public function getBaseUrl(RequestInterface $request, ResponseInterface $response)
	{
		$baseUrl = $this->container->config['base_redirect_url'];
		if (!empty($baseUrl)) {
			return $response->withRedirect($baseUrl);
		} else {
			$body = $response->getBody();
			$body->write('Base url not found');

			return $response->withStatus(404);
		}
	}
}