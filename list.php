<?php
header('Content-type: application/json');
function filter($val) {
	return array('id'=>$val['id'], 'name'=>$val['name']);
}
$stations=json_decode(file_get_contents('http://www.rmfon.pl/json/stations.txt'), true);
$stations=array_map('filter', $stations);
echo json_encode($stations, JSON_PRETTY_PRINT);
?>