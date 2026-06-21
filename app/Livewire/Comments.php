<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Comments extends Component
{
    public Post $post;

    #[Validate('required|string|min:1|max:1000')]
    public string $body = '';

    public ?int $replyTo = null;
    #[Validate('required|string|min:1|max:1000')]
    public string $replyBody = '';

    public ?int $editId = null;
    #[Validate('required|string|min:1|max:1000')]
    public string $editBody = '';

    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    public function addComment(): void
    {
        $this->ensureAuth();
        $this->validateOnly('body');

        $this->post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->body,
        ]);

        $this->body = '';
    }

    public function setReply(int $commentId): void
    {
        $this->ensureAuth();
        $this->reset('replyBody');
        $this->replyTo = $commentId;
    }

    public function cancelReply(): void
    {
        $this->reset('replyTo', 'replyBody');
    }

    public function addReply(): void
    {
        $this->ensureAuth();
        $this->validateOnly('replyBody');

        $this->post->comments()->create([
            'user_id' => Auth::id(),
            'parent_id' => $this->replyTo,
            'body' => $this->replyBody,
        ]);

        $this->reset('replyTo', 'replyBody');
    }

    public function startEdit(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);
        $this->authorizeOwner($comment);

        $this->editId = $commentId;
        $this->editBody = $comment->body;
    }

    public function cancelEdit(): void
    {
        $this->reset('editId', 'editBody');
    }

    public function updateComment(): void
    {
        $comment = Comment::findOrFail($this->editId);
        $this->authorizeOwner($comment);
        $this->validateOnly('editBody');

        $comment->update(['body' => $this->editBody]);
        $this->reset('editId', 'editBody');
    }

    public function deleteComment(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);
        $this->authorizeOwner($comment);

        $comment->delete();
    }

    protected function ensureAuth(): void
    {
        abort_unless(Auth::check(), 403);
    }

    protected function authorizeOwner(Comment $comment): void
    {
        abort_unless(Auth::check() && $comment->user_id === Auth::id(), 403);
    }

    public function render()
    {
        $comments = $this->post->comments()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user', 'replies.replies.user'])
            ->latest()
            ->get();

        return view('livewire.comments', [
            'comments' => $comments,
            'total' => $this->post->comments()->count(),
        ]);
    }
}
