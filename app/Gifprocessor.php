<?php declare(strict_types=1);

namespace App;

class GifProcessor
{
    public function processGifs(array $gifs) : string
    {
        $html = '';
        foreach ($gifs['data'] as $gif) {
            $html .= '<img src="' . $gif['images']['original']['url'] . '" alt="' . $gif['title'] . '">';
        }
        return $html;
    }
}
