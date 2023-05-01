<?php declare(strict_types=1);

namespace App\Models;

class GifPropperties
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function returnUrl(): string
    {
        return $this->url;
    }
}