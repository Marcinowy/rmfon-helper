<?php

header('Content-type: application/json');

include 'includes/autoload.php';

$id = $_GET['id'];
try {
    $rmfon = new rmfon($id);
    $music = $rmfon->getCurrentMusic();
    $yt = (new youtube())->getVideos($music['author'] . ' ' . $music['title']);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ], JSON_PRETTY_PRINT);
    exit;
}

echo json_encode([
    'success' => true,
    'streams' => $rmfon->getStreamUrls(),
    'music' => $music['author'] . ' - ' . $music['title'],
    'yt' => $yt,
], JSON_PRETTY_PRINT);
?>
