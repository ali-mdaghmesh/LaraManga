<?php 

namespace App\Services;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\User;

class CommentService{

    public function makeComment(User $user, array $data)
    {

        $comment = Comment::create([
            'user_id' => $user->id, 
            'chapter_id' => $data['chapter_id'] ?? null,
            'mangadex_chapter_id' => $data['mangadex_chapter_id'] ?? null,
            'content' => $data['content'], 
        ]); 

        return $comment; 
    }

    public function editComment(Comment $comment, $content)
    {
        $comment->update([
            'content' => $content
        ]); 

        return $comment; 
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete(); 
    }

    public function replyOnComment(User $user, Comment $parent, $content)
    {
        $comment = Comment::create([
            'user_id' => $user->id,
            'chapter_id' => $parent->chapter_id,
            'mangadex_chapter_id' => $parent->mangadex_chapter_id,
            'parent_id' => $parent->id,
            'content' => $content,
        ]);

        return $comment; 
    }

    public function getReplyComments(Comment $comment)
    {
        $comments = $comment->replyComments(); 
        return $comments->paginate(10); 
    }

    public function getChapterComments(Chapter $chapter)
    {
        return $chapter->comments()
            ->whereNull('parent_id')
            ->latest()
            ->paginate(20);
    }

    public function getMangaDexChapterComments(string $mangadexChapterId)
    {
        return Comment::where('mangadex_chapter_id', $mangadexChapterId)
            ->whereNull('parent_id')
            ->with(['user', 'replyComments.user'])
            ->latest()
            ->paginate(20);
    }




}