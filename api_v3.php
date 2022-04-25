<?php
/*
* Public OPL Api
* Copyright Christian "Freaky" Herberg
* Date: 17.03.2022 23:00
*/
require_once 'extern/extern_call.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

//your API key
API_v3_test::init('');

$tournament_ID = 125;
$team_ID = 1;
$account_ID = 1;
$matchup_ID = 4057;

//$call = API_v3_test::get_team($team_ID);
//$call = API_v3_test::get_user($account_ID);
//$call = API_v3_test::get_tournament($tournament_ID);
//$call = API_v3_test::get_standing($tournament_ID);
$call = API_v3_test::get_matchup($matchup_ID);

if(isset($call->code)) {
	if($call->code != 200) {
		echo '<pre>';
			print_r($call);
		echo '</pre>';
		die();
	} else {
		echo '<pre>';
			print_r($call);
			//echo json_encode($APICall);
		echo '</pre>';
	}
} else {
	die('Fatal error');
}
