<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\DestroyCommentRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Chapter;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {}

    public function store(StoreCommentRequest $request)
    {
        $validatedData = $request->validated(); 
        $comment = $this->commentService->makeComment($request->user(), $validatedData); 

        return $this->createdResponse(new CommentResource($comment), "The comment created successfully."); 
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $validatedData = $request->validated(); 
        $comment = $this->commentService->editComment($comment, $validatedData['content']); 

        return $this->successResponse(new CommentResource($comment), "The comment updated successfully."); 
    }

    public function destroy(DestroyCommentRequest $request, Comment $comment)
    {
        $this->commentService->deleteComment($comment); 

        return $this->deletedResponse("The comment deleted successfully."); 
    }

    public function replyOnComment(Request $request, Comment $parent)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:1|max:2000'
        ]); 

        $comment = $this->commentService->replyOnComment($request->user(), $parent, $validated['content']); 

        return $this->createdResponse(new CommentResource($comment), "The reply created successfully"); 
    }

    public function getReplyComments(Comment $comment)
    {
        $comments = $this->commentService->getReplyComments($comment); 

        return $this->paginatedResponse($comments, CommentResource::class, "The reply list:"); 
    }

    public function getChapterComments(Chapter $chapter)
    {
        $comments = $this->commentService->getChapterComments($chapter); 

        return $this->paginatedResponse($comments, CommentResource::class, "The chapter comments:"); 
    }

    public function getMangaDexChapterComments(string $mangadexChapterId)
    {
        $comments = $this->commentService->getMangaDexChapterComments($mangadexChapterId);

        return $this->paginatedResponse($comments, CommentResource::class, "The MangaDex chapter comments:");
    }
}