<?php

namespace CodePress\CodePost\Repository;

use CodePress\CodeDatabase\AbstractRepository;
use CodePress\CodePost\Models\Post;

class PostRepositoryEloquent extends AbstractRepository implements PostRepositoryInterface
{

    public function model()
    {
        return Post::class;
    }

    public function updateState($id, $state){
        $post = $this->find($id);
        $post->state = $state;
        $post->save();
        return $post;
    }
}