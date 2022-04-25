<?php
/*
* Public OPL Api
* Copyright Christian "Freaky" Herberg
* Date: 17.03.2022 23:00
*/
class API_v3_test {

	protected static $apikey;

	const URL = 'https://www.opleague.eu/api/api%20v3/v3.php';


	public static function init($apikey) {
		self::$apikey = $apikey;
	}

	public static function get_tournament($tournament_ID) {
		return self::sendPostRequest(
			self::buildData('get_tournament', 'tournament_ID', $tournament_ID)
		);
	}

	public static function get_standing($tournament_ID) {
		return self::sendPostRequest(
			self::buildData('get_standing', 'tournament_ID', $tournament_ID)
		);
	}

	public static function get_team($teamID) {
		return self::sendPostRequest(
			self::buildData('get_team', 'team_ID', $teamID)
		);
	}

    public static function get_user($account_ID) {
		return self::sendPostRequest(
			self::buildData('get_user', 'account_ID', $account_ID)
		);
	}

	public static function get_matchup($matchup_ID) {
		return self::sendPostRequest(
			self::buildData('get_matchup', 'matchup_ID', $matchup_ID)
		);
	}

	public static function buildData($endPoint, $variable, $ID) {
		return [
			'endpoint' => $endPoint,
			$variable => $ID,
		];
	}

	public static function sendPostRequest($data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		//Is needed don't remove
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
                $message = '';
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
