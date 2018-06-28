<?php

namespace JWage\APNS;

class Sender {

	/**
	 * @var \JWage\APNS\Client
	 */
	private $client;

	/**
	 * Construct.
	 *
	 * @param \JWage\APNS\Client $client
	 */
	public function __construct(Client $client) {

		$this->client = $client;
	}

	/**
	 *
	 * @param array $notifications
	 * Example notification object => {token: p, title: q, body: r, deep_link: s}
	 * @return int
	 */
	public function send(array $notifications) {

		$messageBinary = $this->client->createApnMessagesBinary($notifications);

		return $this->client->sendPayload($messageBinary);

	}
}
