<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Posts') }}
            </h2>
            <a href="{{ route('admin.addpost') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                + Add Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($posts as $post)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $post->id }}</td>
                                        <td class="px-4 py-3">
                                            @if ($post->image)
                                                <img src="{{ asset('img/' . $post->image) }}" alt="{{ $post->title }}"
                                                    class="w-16 h-12 object-cover rounded">
                                            @else
                                                <span class="text-gray-400 text-xs">No image</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $post->title }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $post->user_name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $post->created_at->format('M j, Y') }}</td>
                                        <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                                            <a href="{{ route('fullpost', $post->id) }}" target="_blank"
                                                class="text-gray-600 hover:text-gray-900">View</a>
                                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                                class="ml-3 text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-3 text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No posts yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
