<?php
	if (empty($_SESSION['steam_uptodate']) or empty($_SESSION['steam_personaname']))
	{
		require 'SteamConfig.php';

		$url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']);
		
		$content = json_decode($url, true);

		$_SESSION['steam_steamid'] 					= $content['response']['players'][0]['steamid'];
		$_SESSION['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
		$_SESSION['steam_profilestate'] 			= $content['response']['players'][0]['profilestate'];
		$_SESSION['steam_personaname'] 				= $content['response']['players'][0]['personaname'];
		$_SESSION['steam_lastlogoff'] 				= $content['response']['players'][0]['lastlogoff'];
		$_SESSION['steam_profileurl'] 				= $content['response']['players'][0]['profileurl'];
		$_SESSION['steam_avatar'] 					= $content['response']['players'][0]['avatar'];
		$_SESSION['steam_avatarmedium'] 			= $content['response']['players'][0]['avatarmedium'];
		$_SESSION['steam_avatarfull'] 				= $content['response']['players'][0]['avatarfull'];
		$_SESSION['steam_personastate'] 			= $content['response']['players'][0]['personastate'];
		
		if (isset($content['response']['players'][0]['realname']))
		{
			$_SESSION['steam_realname'] = $content['response']['players'][0]['realname'];
		} else {
			$_SESSION['steam_realname'] = "Real name not given";
		}

		$_SESSION['steam_primaryclanid'] 	= $content['response']['players'][0]['primaryclanid'];
		$_SESSION['steam_timecreated'] 		= $content['response']['players'][0]['timecreated'];
		$_SESSION['steam_uptodate'] 		= time();
	}

	function getSteamProfileAvatar()
	{
		return $_SESSION['steam_avatar'];
	}

	function getSteamProfileState()
	{
		$state = $_SESSION['steam_profilestate'];

		if ($state == 1){
			return "Online";
		}
		elseif($state == 2){
			return "Busy";
		}
		elseif($state == 3){
			return "Away";
		}
		elseif($state == 4){
			return "Snooze";
		}
		elseif($state == 5){
			return "Looking to trade";
		}
		elseif($state == 6){
			return "Looking to play";
		}

		return "Offline";
	}

	function getSteamProfileName()
	{
		return $_SESSION['steam_personaname'];
	}
?>