<?php
/*
* Public OPL Api
* Copyright Christian "Freaky" Herberg
* Date: 16.02.2021 14:04
*/

class API {

	protected static $apikey;

	const URL = 'https://www.opleague.eu/APIV2/PublicAPI';


	public static function init($apikey) {
		self::$apikey = $apikey;
	}

	public static function getMatchups($eventID) {
		return self::sendPostRequest(
			self::buildData('event', 'getMatchups', $eventID)
		);
	}

	public static function getEventInfo($eventID) {
		return self::sendPostRequest(
			self::buildData('event', 'getEventInfo', $eventID)
		);
	}

	public static function getEventStandings($eventID) {
		return self::sendPostRequest(
			self::buildData('event', 'getEventStandings', $eventID)
		);
	}

	public static function getTeams($eventID) {
		return self::sendPostRequest(
			self::buildData('event', 'getTeams', $eventID)
		);
	}

	public static function getTeam($teamID) {
		return self::sendPostRequest(
			self::buildData('team', 'getTeam', $teamID)
		);
	}

	public static function buildData($endPoint, $methode, $fetch) {
		$data = [];

		$data['endpoint'] = $endPoint;
		$data['methode'] = $methode;
		$data['fetch'] = $fetch;

		return $data;
	}

	public static function sendPostRequest($data) {
        $bodyData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyData);
		curl_setopt($ch, CURLOPT_USERAGENT, 'OPL/1.0');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'Authorization: Bearer ' . self::$apikey
        ));

        curl_setopt($ch, CURLOPT_URL, self::URL);
        $result = curl_exec($ch);

        if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
            $response = json_decode($result);

            if ($info['http_code'] != 200) {
                $message = null;
                if (isset($response->error)) {
                    $message = "[" . $response->error->code . "]" .$response->error->message;
                }
                throw new \Exception($message, $info['http_code']);
            }

            return $response;
        }
        return false;
    }

}
