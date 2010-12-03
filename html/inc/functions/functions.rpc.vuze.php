<?php

/**
 * get Vuze RPC torrent id (use it temporary, dont store it)
 *
 * @param $transfer
 * @return int
 */
function getVuzeTransferRpcId($transfer) {
	$hash = getTransferHash($transfer);
	$torrents = $rpc->torrent_get_hashids();
	$tid = false;
	if ( array_key_exists(strtoupper($hash),$torrents) ) {
		$tid = $torrents[strtoupper($hash)];
	}
	return $tid;
}

//to check...
function addVuzeMagnetTransfer($userid = 0, $url, $path, $paused=true) {
	global $cfg;
	
	require_once('inc/classes/VuzeRPC.php');
	$rpc = VuzeRPC::getInstance();

	$content = $path."\n";
	//... max_ul
	//... todo
	$id = $rpc->torrent_add_url( $url, $content);

	$hash = false;
	if ($id !== false) {
		$hash = $rpc->torrent_get_hashids(array($id));
	} else {
		AuditAction($cfg["constants"]["error"], "Download Magnet : ".$rpc->lastError);
	}
	return $hash;
}

?>