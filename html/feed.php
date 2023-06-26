<?php
// Set the feed URL.
$url1 = 'http://feeds.nos.nl/nosnieuwsalgemeen';
$url2 = "http://feeds.nos.nl/nosnieuwsopmerkelijk";

// Fetch the content.
// See http://php.net/manual/en/function.file-get-contents.php for more
// information about the file_get_contents() function.
$feed_url = $url1;
if($_GET['url']=='2') {
	$feed_url = $url2;
	}
$content = file_get_contents( $feed_url );

// Set the Content-Type header.
header("Access-Control-Allow-Origin: http://narrowcasting-ns.vslcatena.lan/");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header( 'Content-Type: application/rss+xml' );

// Display the content and exit.
echo $content;
exit;
?>
