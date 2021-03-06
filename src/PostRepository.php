<?php

namespace App;

class PostRepository
{
    private $posts;
    public function __construct()
    {
        $this->posts = Generator::generate();
    }

    public function all()
    {
        return $this->posts;
    }

    public function find(string $id)
    {
        return collect($this->posts)->firstWhere('id', $id);
    }
}

