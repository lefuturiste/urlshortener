<?php

namespace App\Controllers;

use App\Time;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UrlShortenerApiController extends Controller
{

	/**
	 * List all of redirect urls
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @return mixed
	 */
	public function index(ServerRequestInterface $request, ResponseInterface $response)
	{
		$data = $this->db->fetchRowMany('SELECT * FROM urls');

		return $response->withJson($data);
	}

	/**
	 * Show a specified data about a redirect url
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param $args
	 * @return mixed
	 */
	public function show(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		$data = $this->db->fetchRow('SELECT * FROM urls WHERE uuid = :uuid', [
			'uuid' => $args['uuid']
		]);
		if ($data) {
			return $response->withJson($data);
		} else {
			return $response->withJson([
				'Error' => 'Ressource not found'
			])->withStatus(404);
		}
	}

	/**
	 * Create a redirect url
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @return mixed
	 */
	public function store(ServerRequestInterface $request, ResponseInterface $response)
	{
		//if the uuid is already used
		if (!isset($request->getParsedBody()['uuid']) OR empty($request->getParsedBody()['uuid'])) {
			$uuid = bin2hex(random_bytes(2));
		} else {
			$uuid = $request->getParsedBody()['uuid'];
		}
		$req = $this->db->fetchColumn('SELECT uuid FROM urls WHERE uuid = :uuid', [
			'uuid' => $uuid
		]);
		if (empty($req)) {
			return $response->withJson($this->db->insert('urls', [
				'uuid' => $uuid,
				'redirect' => $request->getParsedBody()['redirect'],
				'created_at' => Time::now()
			]));
		} else {
			return $response->withJson([
				'Error' => 'Uuid ressource already used'
			])->withStatus(400);
		}

	}

	/**
	 * Update a redirect url
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param $args
	 * @return mixed
	 */
	public function update(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		//if this uuid is empty or not isset => uuid is not required
		if (empty($request->getParsedBody()['uuid']) OR !isset($request->getParsedBody()['uuid'])) {
			$uuid = $args['uuid'];
		} else {
			$uuid = $request->getParsedBody()['uuid'];
		}

		//if the uuid is already used
		$req = $this->db->fetchColumn('SELECT uuid FROM urls WHERE uuid = :uuid', [
			'uuid' => $args['uuid']
		]);

		if (!empty($req)) {
			return $response->withJson($this->db->update('urls', [
				'uuid' => $args['uuid']
			], [
				'uuid' => $uuid,
				'redirect' => $request->getParsedBody()['redirect'],
				'updated_at' => Time::now()
			]));
		} else {
			return $response->withJson([
				'Error' => 'Ressource not found'
			])->withStatus(404);
		}
	}

	/**
	 * Delete a redirect url
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param $args
	 * @return mixed
	 */
	public function destroy(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		return $response->withJson($this->db->delete('urls', [
			'uuid' => $args['uuid']
		]));
	}
}