<?php

namespace App\Models;

class EmailLink
{

    private string $url;
    private string $label;

    public function __construct(string $url, string $label)
    {
        $this->url = $url;
        $this->label = $label;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

}
