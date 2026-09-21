<?php

namespace App\Services;

use App\Models\Tag;

class TagService{

    public function makeTag($name)
    {
        return Tag::create(['name' => $name]); 
    }

    public function editTag($name, Tag $tag)
    {
        $tag->update(['name' => $name]); 
        return $tag; 
    }

    public function getTags()
    {
        return Tag::paginate(15); 
    }

    public function deleteTag(Tag $tag)
    {
        $tag->delete();
    }


}