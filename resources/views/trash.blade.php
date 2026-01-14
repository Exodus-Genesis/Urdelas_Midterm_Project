@extends('layouts.app')

@section('content')

<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">
                Trash
            </h1>
            <p class="mt-1 text-sm text-gray-400">
                Manage deleted games — restore or permanently delete
            </p>
        </div>

        <a href="{{ route('dashboard') }}"
           class="rounded-lg bg-gray-700 px-4 py-2 text-sm font-medium text-white hover:bg-gray-600 transition">
            Back to Dashboard
        </a>
    </div>

    {{-- Stats --}}
    <div class="rounded-xl bg-gray-800 border border-gray-700 p-6">
        <div class="flex items-center gap-4">
            <div class="rounded-full bg-red-700 p-3">
                🗑️
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    Games in Trash
                </p>
                <h3 class="mt-1 text-2xl font-bold text-white">
                    {{ $movies->count() }}
                </h3>
            </div>
        </div>
    </div>

    {{-- Trash Table --}}
    <div class="rounded-xl bg-gray-800 border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-400">
                            Game Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-400">
                            Genre
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase text-gray-400">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @forelse ($movies as $movie)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm text-white">
                                {{ $movie->title }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $movie->genre?->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">

                                    {{-- Restore --}}
                                    <form method="POST" action="{{ route('movies.restore', $movie->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="rounded-lg bg-green-700 px-3 py-1 text-white hover:bg-green-600 transition">
                                            Restore
                                        </button>
                                    </form>

                                    {{-- Permanent Delete --}}
                                    <form method="POST" action="{{ route('movies.forceDelete', $movie->id) }}"
                                          onsubmit="event.stopPropagation('This will permanently delete the Game. Continue?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="rounded-lg bg-red-700 px-3 py-1 text-white hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-400">
                                No Games found in trash.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
