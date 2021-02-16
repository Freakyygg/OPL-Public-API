<?php
/*
* Public OPL Api
* Copyright Christian "Freaky" Herberg
* Date: 16.02.2021 14:04
*/
require_once 'OPLAPI/API.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

//TODO add your APIKey here
API::init('');

/*
 * Needed Info:
 *	user -> WIP
 *	event -> getMatchups($eventID) -> getTeams($eventID) -> getEventInfo($eventID) -> getEventStandings($eventID)
 *	team -> getTeam($teamID)
 *
 *
 *
 */

$eventID = 195;
$teamID = 1;

//$APICall = API::getMatchups($eventID);
//$APICall = API::getTeams($eventID);
//$APICall = API::getEventInfo($eventID);
//$APICall = API::getTeam($teamID);
$APICall = API::getEventStandings($eventID);

if(isset($APICall->Code)) {
	if($APICall->Code != 200) {
		if(isset($APICall->Response)) {
			die('Message: ' . $APICall->Message . '<br>Response: ' . $APICall->Response);
		}
		die($APICall->Message);
	} else {
		echo '<pre>';
			print_r($APICall);
			//echo json_encode($APICall);
		echo '</pre>';
	}
} else {
	die('Fatal error');
}
