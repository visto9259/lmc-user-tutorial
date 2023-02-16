<?php

namespace Album\Model;

class Album extends \ArrayObject
{
    public $id;
    public $artist;
    public $title;

    public function exchangeArray(object|array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->artist = !empty($data['artist']) ? $data['artist'] : null;
        $this->title  = !empty($data['title']) ? $data['title'] : null;
    }
}
