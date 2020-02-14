<?php

header('Content-type: application/json');

include 'includes/autoload.php';

$id=$_GET['id']*1;
$rmfon=new rmfon($id);
$music=$rmfon->getCurrentMusic();

$res=array(
	'streams' => $rmfon->getStreamUrls(),
	'music' => $music['author'] . ' - ' . $music['title'],
	'yt' => (new youtube())->getVideos($music['author'] . ' ' . $music['title'])
);

echo json_encode($res, JSON_PRETTY_PRINT);
?>