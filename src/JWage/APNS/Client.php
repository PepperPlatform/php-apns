<?php

namespace JWage\APNS;

class Client {

	/**
	 * @var \JWage\APNS\SocketClient
	 */
	private $socketClient;

	/**
	 * Construct.
	 *
	 * @param \JWage\APNS\SocketClient $socketClient
	 */
	public function __construct(SocketClient $socketClient) {

		$this->socketClient = $socketClient;
	}

	/**
	 * Creates an APNSMessage instance for the given device token and payload.
	 *
	 * @param string $deviceToken
	 * @param \JWage\APNS\Payload $payload
	 * @return \JWage\APNS\APNSMessage
	 */
	protected function createApnMessage($deviceToken, Payload $payload) {

		return new APNSMessage($deviceToken, $payload);
	}

	/**
	 * @param array $data - Data item structure { token: foo, payload: baz }
	 * @return string
	 */
	public function createApnMessagesBinary(array $data) {

		$messageBinary = "";
		foreach ($data as $notificationData) {
			$messageBinary .= $this->createApnMessage($notificationData->token, new Payload($notificationData->title, $notificationData->body, $notificationData->deepLink))->getBinaryMessage();
		}

		return $messageBinary;
	}

	/**
	 * @param $binaryMessage
	 * @return int
	 */
	public function sendPayload($binaryMessage) {

		return $this->socketClient->write($binaryMessage);
	}
}
