<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">{{ __("You're logged in As Admin") }}</p>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.posts') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">
                            Manage Posts
                        </a>
                        <a href="{{ route('admin.addpost') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                            + Add Post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
