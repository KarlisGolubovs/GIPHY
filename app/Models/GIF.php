<?php declare(strict_types=1);

namespace Giphy\Models;

class GIF
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
    public function getUrl(): string
    {
        return $this->url;
    }
}