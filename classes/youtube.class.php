<?php

class youtube
{
    private function extractSingleResult(string $html)
    {
        $title = explode('" dir="ltr">', $html);
        $title = explode('</a>', $title[1]);

        $time = explode('video-time" aria-hidden="true">', $html);
        $time = explode('</span>', $time[1]);

        $url = explode('<h3 class="yt-lockup-title "><a href="', $html);
        $url = explode('" class', $url[1]);
        $url = 'https://www.youtube.com' . $url[0];

        if (strstr($html, 'data-thumb="') != false) {
            $img = explode('data-thumb="', $html);
        } else {
            $img = explode('src="', $html);
        }
        $img = explode('"', $img[1]);

        $count = explode(' wyświet', $html);
        $count = explode('<li>', $count[0]);

        return array(
            'title' => $title[0],
            'img' => $img[0],
            'time' => $time[0],
            'count' => preg_replace('/[^0-9]/', '', $count[count($count) - 1]),
            'url' => $url
        );
    }
    private function extractSearchData(string $html)
    {
        $html = explode('class="item-section">', $html);
        $html = explode('</ol>', $html[1]);
        $html = $html[0] . '</ol>' . $html[1];

        $video = explode('</div></div></div></li>', $html);
        $videos = [];

        for ($i=0; $i<count($video); $i++) {
            if (strstr($video[$i], 'Czas trwania: ')!=false) {
                $videos[] = $this->extractSingleResult($video[$i]);
            }
        }

        return $videos;
    }

    public function getVideos(string $query)
    {
        $query = str_replace(' ', '+', $query);
        $ytCode = file_get_contents('https://www.youtube.com/results?search_query=' . $query);

        $videos = $this->extractSearchData($ytCode);

        return $videos;
    }
}
