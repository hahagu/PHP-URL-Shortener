<?php
/*
 * First authored by Brian Cray
 * Page created by Defyworks
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 * Contact the page creator at https://www.defyworks.com/
 */
 
ini_set('display_errors', 0);

$url_to_remove = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['shorturl'])) : trim($_REQUEST['shorturl']);

if(!empty($url_to_remove))
{
	require('config.php');

	// check if the client IP is allowed to shorten
	if($_SERVER['REMOTE_ADDR'] != LIMIT_TO_IP)
	{
		die('You are not allowed to remove shortened URLs with this service.');
	}
	
	// check if the URL exists
	$id_to_remove = getIDFromShortenedURL($url_to_remove);
	
	$urlcheck = mysql_result(mysql_query('SELECT id FROM ' . DB_TABLE. ' WHERE id="' . mysql_real_escape_string($id_to_remove) . '"'), 0, 0);
	
	if(!empty($urlcheck))
	{
		
		$creator = mysql_result(mysql_query('SELECT creator FROM ' . DB_TABLE. ' WHERE id="' . mysql_real_escape_string($id_to_remove) . '"'), 0, 0);
		if($creator != $_SERVER['REMOTE_ADDR'])
		{
			die('You are not the creator of this URL!');
		} else {
			mysql_query('DELETE FROM ' . DB_TABLE. ' WHERE id="' . mysql_real_escape_string($id_to_remove) . '"');
			die('URL Successfully deleted!');
		}
		
	}
	else
	{
		// URL doesn't exist
		die('URL does not exist on the database!');
	}
}

die('ERROR!');

function getIDFromShortenedURL ($string, $base = ALLOWED_CHARS)
{
	$length = strlen($base);
	$size = strlen($string) - 1;
	$string = str_split($string);
	$out = strpos($base, array_pop($string));
	foreach($string as $i => $char)
	{
		$out += strpos($base, $char) * pow($length, $size - $i);
	}
	return $out;
}
