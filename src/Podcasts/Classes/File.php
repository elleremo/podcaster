<?php

namespace Podcasts\Classes;


class File
{
    private $id;
    private $data;

    public function __construct($id)
    {
        $this->id = $id;
        $this->data = wp_get_attachment_metadata($this->id);
    }

    public function getMimeType()
    {
        if (!isset($this->data['mime_type'])) {
            return false;
        }
        return $this->data['mime_type'];
    }

    public function getSize()
    {
        if (!isset($this->data['filesize'])) {
            return false;
        }
        return $this->data['filesize'];
    }

    public function getFileUrl()
    {
        if (!isset($this->data['filesize'])) {
            return false;
        }
        return wp_get_attachment_url($this->id);
    }

}
