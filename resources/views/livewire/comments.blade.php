<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">
        Comments <span class="text-gray-400 text-lg">({{ $total }})</span>
    </h2>

    @auth
        <form wire:submit="addComment" class="mb-8">
            <textarea
                wire:model="body"
                rows="3"
                placeholder="Write a comment..."
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
            ></textarea>
            @error('body') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            <button
                type="submit"
                class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
            >
                <span wire:loading.remove wire:target="addComment">Post Comment</span>
                <span wire:loading wire:target="addComment">Posting...</span>
            </button>
        </form>
    @else
        <p class="mb-8 text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 underline">Log in</a> to leave a comment.
        </p>
    @endauth

    <div class="space-y-6">
        @forelse ($comments as $comment)
            @include('livewire.partials.comment', ['comment' => $comment, 'depth' => 0])
        @empty
            <p class="text-gray-500">No comments yet. Be the first!</p>
        @endforelse
    </div>
</div>
