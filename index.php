<?php

require_once('config.php');

// libs
require_once('lib/mypie.php');
require_once('lib/arrayMultiSort.php');


// getting feed contents
	foreach ($feeds as $feedKey => $feed){
		// getting contents
		$results = @readRSS($feed['url']);
		foreach ($results['items'] as $item){
			// adding item array to feed type
			$itemArray = $item;
			$itemArray['type'] = $feedKey;

			// adding all items
			$allItems[] = $itemArray;
		}
	}


// sorting all entries
	$allItems = @arrayMultiSort($allItems, 'date');


// pagination
	$itemCount = count($allItems);
	if( $itemCount > $limit ){

		// calculating page count
		$pageCount = ceil( $itemCount / $limit );

		// current page control
		$page = intVal($_GET['page']);
		if( $page < 1 or $page > $pageCount ) $page = 1;

		// paged item array
		$pagedItems = array_slice($allItems, ($page-1) * $limit, $limit);

	}else{
		$page       = 1;
		$pageCount  = 1;
		$pagedItems = $allItems;
	}


?><!DOCTYPE html>
<html>
<head>
	<title>Hot News</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
</head>
<body>
	<div class="container">
		<div class="header">
			<h1><a href="./"><b>Hot News</b></a></h1>
			Self updating/living blogish thing.
		</div>

		<div id="stream">
			<?php

			foreach ($pagedItems as $item){
				// item's feed-service info
				$feedinfo = $feeds[ $item['type'] ];

				// content
				$content = $item['description'];

				// adding to content
				print '
				<div class="item '. $display .' '. $item['type'] .'">
					<h3 class="title"><a class="permalink" href="'. $item['url'] .'" target="_blank">'. $item['title'] .'</a> '. ($item['date'] ? '<span class="time">('. substr($item['date'], 0, 16) .')</span>':'') .'</h3>
					'. ($content ? '<div class="content-text">'. $content .'</div>':'') .'
				</div>
				';
			}

			?>
		</div>
		<div class="clear"></div>
		<div class="pagination">
			<br clear="all">
			<?php

			if( $pageCount > 1 ){
				print 'Pages : ';
				for ($i=1; $i <= $pageCount; $i++){ 
					print '<a href="?page='.$i.'"'. ($i==$page ? ' class="current"':'') .'>'.$i.'</a> ';
				}
			}

			?>
		</div>
	</div>
</body>
</html>