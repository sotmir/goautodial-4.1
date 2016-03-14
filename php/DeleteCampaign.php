<?php

	/** Campaigns API - Add a new Campaign */
	/**
	 * Generates action circle buttons for different pages/module
	 * @param goUser 
	 * @param goPass 
	 * @param goAction 
	 * @param responsetype
	 * @param hostname
	 * @param campaign_id
	 */

	$campaign_id = $_POST['campaign_id'];

	$url = "http://162.254.144.92/goAPI/goCampaigns/goAPI.php"; #URL to GoAutoDial API. (required)

	$postfields["goUser"] 			= "goautodial"; #Username goes here. (required)
	$postfields["goPass"] 			= "JUs7g0P455W0rD11214"; #Password goes here. (required)
	$postfields["goAction"] 		= "goDeleteCampaign"; #action performed by the [[API:Functions]]
	$postfields["responsetype"] 	= "json"; #json (required)
	$postfields["hostname"] 		= $_SERVER['REMOTE_ADDR']; #Default value
	$postfields["campaign_id"] 		= (int)$campaign_id;; #Desired campaign id. (required)

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);

	$output = json_decode($data);

	if ($output->result=="success") {
		# Result was OK!
		$status = 1;
	} else {
		# An error occured
		$status = 0;
	}

	echo $status;
?>