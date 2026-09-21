<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;

class TagController extends Controller
{
    private $tagService; 

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService; 
    }       

    function store(TagRequest $tagRequest)
    {
        $validatedData = $tagRequest->validated(); 
        $tag = $this->tagService->makeTag($validatedData['name']); 
        return $this->createdResponse(new TagResource($tag), "The tag created successfully."); 
    }

    function update(TagRequest $tagRequest,Tag $tag)
    {
        $validatedData = $tagRequest->validated(); 
        $tag = $this->tagService->editTag($validatedData['name'], $tag);
        return $this->successResponse(new TagResource($tag), "The tag updated successfylly"); 
    }

    function destroy(Tag $tag)
    {
        $this->tagService->deleteTag($tag); 
        return $this->deletedResponse("The tag deleted successfully."); 
    }

    function index()
    {
        $tags = $this->tagService->getTags();
        return $this->paginatedResponse($tags, TagResource::class, "The tags:");
    }

    function show(Tag $tag)
    {
        return $this->successResponse(
            new TagResource($tag)
        );
    }

}
