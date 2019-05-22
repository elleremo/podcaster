<?php

namespace Podcasts\Data;


class ExtractOptions
{
    private $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function getData()
    {
        return get_option($this->slug, []);
    }

}
