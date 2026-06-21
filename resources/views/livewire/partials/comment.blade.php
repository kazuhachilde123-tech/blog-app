@php $depth = $depth ?? 0; @endphp
<div class="flex gap-3 {{ $depth > 0 ? 'mt-4 ml-6 md:ml-10 border-l border-gray-200 pl-4' : '' }}"
    wire:key="comment-{{ $comment->id }}">
    <div class="shrink-0">
        <div
            class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold uppercase">
            {{ substr($comment->user->name ?? '?', 0, 1) }}
        </div>
    </div>

    <div class="flex-1">
        <div class="bg-gray-50 rounded-lg p-3">
            <div class="flex items-center justify-between">
                <span class="font-semibold text-gray-900">{{ $comment->user->name ?? 'Unknown' }}</span>
                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            @if ($editId === $comment->id)
                <form wire:submit="updateComment" class="mt-2">
                    <textarea wire:model="editBody" rows="2"
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    @error('editBody')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 flex gap-2">
                        <button type="submit"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Save</button>
                        <button type="button" wire:click="cancelEdit"
                            class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">Cancel</button>
                    </div>
                </form>
            @else
                <p class="text-gray-700 mt-1 whitespace-pre-wrap">{{ $comment->body }}</p>
            @endif
        </div>

        @if ($editId !== $comment->id)
            <div class="flex gap-4 mt-1 text-sm text-gray-500">
                @auth
                    <button wire:click="setReply({{ $comment->id }})" class="hover:text-blue-600">Reply</button>
                    @if ($comment->user_id === auth()->id())
                        <button wire:click="startEdit({{ $comment->id }})" class="hover:text-blue-600">Edit</button>
                        <button wire:click="deleteComment({{ $comment->id }})" wire:confirm="Delete this comment?"
                            class="hover:text-red-600">Delete</button>
                    @endif
                @endauth
            </div>
        @endif

        @auth
            @if ($replyTo === $comment->id)
                <form wire:submit="addReply" class="mt-3">
                    <textarea wire:model="replyBody" rows="2" placeholder="Write a reply..."
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    @error('replyBody')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 flex gap-2">
                        <button type="submit"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Reply</button>
                        <button type="button" wire:click="cancelReply"
                            class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">Cancel</button>
                    </div>
                </form>
            @endif
        @endauth

        @if ($comment->replies->isNotEmpty())
            <div class="mt-2">
                @foreach ($comment->replies as $reply)
                    @include('livewire.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
                @endforeach
            </div>
        @endif
    </div>
</div>
