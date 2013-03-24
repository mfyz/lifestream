<?php 

// simple pie
require_once('lib/simplepie.inc');

// feed to array
function readRSS($params){
	if( !is_array($params) ) $url = $params;
	if( !$url ) return false;

	// getting feed
	$feed = new SimplePie($url);
	$feed->handle_content_type();

	// params
	if($params[expire]) $feed->set_cache_duration($params[expire]);

	// feed info
	$result[feed][title]       = $feed->get_title();
	$result[feed][url]         = $feed->get_permalink();
	$result[feed][description] = $feed->get_description();

	// items
	$i = 1;
	foreach ($feed->get_items() as $item){
		$items[] = array(
			'title'       => $item->get_title(),
			'date'        => $item->get_date('Y-m-d H:i:s'),
			'url'         => $item->get_permalink(),
			'description' => $item->get_description(),
		);
		$i++;
		if( $size and $i > $size ) break;
	}

	// adding items to result
	$result[items] = $items;

	// result
	return $result;
}




?>