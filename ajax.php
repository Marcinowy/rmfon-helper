<?php
header('Content-type: application/json');
function get_stream_urls($id) {
	$code=file_get_contents("http://www.rmfon.pl/stacje/flash_aac_".$id.".xml.txt");
	$code=explode("<playlistMp3>",$code);
	$code=explode("</playlistMp3>",$code[1])[0];
	$url=explode("<item_mp3 ads=\"1\">",$code);
	$links=[];
	for ($i=1;$i<count($url);$i++) {
		$url[$i]=explode("</item_mp3>",$url[$i])[0];
		$links[]=$url[$i];
	}
	return $links;
}
function get_current_music($id) {
	$music=file_get_contents("http://rmfon.pl/stacje/playlista_".$id.".json.txt");
	$music=json_decode($music,true);
	$music=$music[array_search(0,array_column($music,"order"))];
	return $music;
}
function get_youtube_videos($query) {
	$query = str_replace(" ", "+", $query);
	$yt_code=file_get_contents("https://www.youtube.com/results?search_query=".$query);
	$yt_code=explode("class=\"item-section\">",$yt_code);
	$yt_code=explode("</ol>",$yt_code[1]);
	$yt_code=$yt_code[0]."</ol>".$yt_code[1];
	$video=explode("</div></div></div></li>",$yt_code);
	$videos=[];
	for ($i=0;$i<count($video);$i++) {
		if (strstr($video[$i],"Czas trwania: ")!=false) {
			$title=explode("\" dir=\"ltr\">",$video[$i]);
			$title=explode("</a>",$title[1]);

			$time=explode("video-time\" aria-hidden=\"true\">",$video[$i]);
			$time=explode("</span>",$time[1]);

			$url=explode("<h3 class=\"yt-lockup-title \"><a href=\"",$video[$i]);
			$url=explode("\" class",$url[1]);
			$url="https://www.youtube.com".$url[0];
			if (strstr($video[$i],"data-thumb=\"")!=false) {
				$img=explode("data-thumb=\"",$video[$i]);
			} else {
				$img=explode("src=\"",$video[$i]);
			}
			$img=explode("\"",$img[1]);
			$count=explode("</li><li>",$video[$i]);
			$count=explode(" wyświet",$count[1]);
			$videos[]=array("title"=>$title[0],"img"=>$img[0],"time"=>$time[0],"count"=>preg_replace("/[^0-9]/","",$count[0]),"url"=>$url);
		}
	}
	return $videos;
}
$id=$_GET["id"];
$streams=get_stream_urls($id);
$music=get_current_music($id);
$music_string=$music["author"]." - ".$music["title"];
$yt=get_youtube_videos($music["author"]." ".$music["title"]);
$res=array(
	"streams"=>$streams,
	"music"=>$music_string,
	"yt"=>$yt
);
echo json_encode($res,JSON_PRETTY_PRINT);
?>