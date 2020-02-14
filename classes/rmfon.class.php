<?php

class rmfon
{
    public $id;
    public function __construct(int $id = 0)
    {
        if ($id <= 0) die('Wrong ID');
        $this->id = $id;
    }
    public function getStreamUrls()
    {
        $xml = new SimpleXMLElement(file_get_contents('http://www.rmfon.pl/stacje/flash_aac_'.$this->id.'.xml.txt'));
        $list = $xml->playlistMp3->item_mp3;
        $links = [];
        for ($i=0; $i<count($list); $i++) $links[] = (string)$list[$i];
        return $links;
    }
    public function getCurrentMusic()
    {
        $music=file_get_contents('http://rmfon.pl/stacje/playlista_'.$this->id.'.json.txt');
        $music=json_decode($music, true);
        $music=$music[array_search(0, array_column($music, 'order'))];
        return $music;
    }
    public static function getStationsList()
    {
        $stations = json_decode(file_get_contents('http://www.rmfon.pl/json/stations.txt'), true);
        $stations = array_map('self::stationsFilter', $stations);

        return $stations;
    }
    private static function stationsFilter($val)
    {
        return array('id' => $val['id'], 'name' => $val['name']);
    }
}