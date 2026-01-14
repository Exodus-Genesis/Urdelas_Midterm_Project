@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="bg-gray-900 shadow-sm sticky top-0 z-40 -mx-6 px-4 sm:px-6 py-4 mb-6">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-100 flex items-center gap-2">
      <span class="text-2xl sm:text-3xl">🎮</span> Game collection
    </h1>
    <div class="text-xs sm:text-sm text-gray-400">
      {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
    </div>
  </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
  <!-- Total Games Card -->
  <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 sm:p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-400 text-xs sm:text-sm font-medium">Total Games</p>
        <p class="text-2xl sm:text-3xl font-bold text-gray-100 mt-2">{{ $totalMovies }}</p>
      </div>
      <div class="text-4xl sm:text-5xl opacity-20">🕹️</div>
    </div>
    <p class="text-xs text-gray-500 mt-4">Games in your collection</p>
  </div>

  <!-- Total Genres Card -->
  <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 sm:p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-400 text-xs sm:text-sm font-medium">Total Game Genres</p>
        <p class="text-2xl sm:text-3xl font-bold text-gray-100 mt-2">{{ $totalGenres }}</p>
      </div>
      <div class="text-4xl sm:text-5xl opacity-20">🖥️</div>
    </div>
    <p class="text-xs text-gray-500 mt-4">Game Genres available</p>
  </div>

  <!-- Top Rated Card -->
  <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 sm:p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-400 text-xs sm:text-sm font-medium">Top Rated</p>
        <p class="text-2xl sm:text-3xl font-bold text-gray-100 mt-2">
          @if($topRated)
            <span class="text-yellow-400">⭐</span> {{ $topRated->rating }}
          @else
            N/A
          @endif
        </p>
        @if($topRated)
          <p class="text-xs text-gray-300 mt-2 truncate">{{ $topRated->title }}</p>
        @endif
      </div>
      <div class="text-4xl sm:text-5xl opacity-20">🏆</div>
    </div>
  </div>
</div>

<!-- Add New Game Form -->
<div class="bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-8">
  <h2 class="text-lg sm:text-xl font-bold text-gray-100 mb-6 flex items-center gap-2">
    <span class="text-xl sm:text-2xl">⛶</span> Add New Games
  </h2>

  <form method="GET" action="{{ route('movies.export') }}" class="inline">
    <input type="hidden" name="search" value="{{ request('search') }}">
    <input type="hidden" name="genre_filter" value="{{ request('genre_filter') }}">

    <button
        type="submit"
        class="flex items-center gap-2 rounded-lg bg-blue-900 px-4 py-2 text-sm font-medium text-white
               transition-colors hover:bg-blue-800"
    >
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 16v-8m0 0l-3 3m3-3l3 3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"/>
        </svg>
        Export to PDF
    </button>
</form>




  <form method="POST" enctype="multipart/form-data" action="{{ route('movies.store') }}" class="space-y-4">
    @csrf
    
    <!-- First Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Title <span class="text-red-500">*</span></label>
        <input 
          name="title" 
          value="{{ old('title') }}" 
          placeholder="Game title"
          class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
          required
        />
      </div>
      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Developer<span class="text-red-500">*</span></label>
        <input 
          name="director" 
          value="{{ old('director') }}" 
          placeholder="Developer name"
          class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
          required
        />
      </div>
      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Release Year <span class="text-red-500">*</span></label>
        <input 
          name="release_year" 
          value="{{ old('release_year') }}" 
          placeholder="2024"
          type="number"
          class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
          required
        />
      </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Game Genre</label>
        <select 
          name="genre_id" 
          required
          class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
        >
          <option value="">Select a game genre</option>
          @foreach($genres as $g)
            <option value="{{ $g->id }}">{{ $g->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Rating</label>
        <input 
          name="rating" 
          value="{{ old('rating') }}" 
          placeholder="e.g., 8.5 or 8/10"
          class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
          required
        />
      </div>
    </div>

    <!-- Description -->
    <div>
      <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Description</label>
      <textarea 
        name="description" 
        placeholder="Game description..."
        rows="3"
        class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
      >{{ old('description') }}</textarea>
    </div>

  <!-- Photo Upload -->
<div class="md:col-span-2">
    <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
        Game Photo (Optional)
    </label>

    <input
        type="file"
        name="photo"
        accept="image/jpeg,image/png,image/jpg"
        class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm
               file:mr-4 file:rounded-md file:border-0
               file:bg-blue-50 file:px-4 file:py-2
               file:text-sm file:font-medium file:text-blue-700
               hover:file:bg-blue-100
               dark:bg-neutral-800 dark:text-neutral-100 dark:file:bg-blue-900/20
               dark:file:text-blue-300"
    >

    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
        JPG, PNG or JPEG. Max 2MB.
    </p>

    @error('photo')
        <p class="mt-1 text-xs text-red-600 dark:text-red-400">
            {{ $message }}
        </p>
    @enderror
</div>


    <!-- Submit Button -->
    <div class="flex justify-end pt-4">
      <button 
        type="submit" 
        class="px-4 sm:px-6 py-2 bg-gradient-to-r from-blue-700 to-blue-800 text-white rounded-lg hover:from-blue-800 hover:to-blue-900 font-medium transition-all duration-200 flex items-center gap-2 text-sm sm:text-base"
      >
        <span>𖦏</span> Add Game
      </button>
    </div>
  </form>
</div>

<!-- Search & Filter Section -->
<div class="rounded-xl border mb-10 border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
        Search & Filter Games 
    </h2>

    <form action="{{ route('dashboard') }}" method="GET" class="grid gap-4 md:grid-cols-3">

        <!-- Search Input -->
        <div class="md:col-span-1">
            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                Search
            </label>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by Game or Developer"
                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm
                       focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20
                       dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
            >
        </div>

        <!-- genre Filter Dropdown -->
        <div class="md:col-span-1">
            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                Filter by Genre
            </label>
            <select
                name="genre_filter"
                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm
                       focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20
                       dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
            >
                <option value="">All genres</option>

                @foreach ($genres as $genre)
                    <option
                        value="{{ $genre->id }}"
                        {{ request('genre_filter') == $genre->id ? 'selected' : '' }}
                    >
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex items-end gap-2">
            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white
                       hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30"
            >
                Apply
            </button>

            <a
                href="{{ route('dashboard') }}"
                class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium
                       text-neutral-700 hover:bg-neutral-100 dark:border-neutral-600
                       dark:text-neutral-200 dark:hover:bg-neutral-700"
            >
                Reset
            </a>
        </div>

    </form>
</div>

<!-- Movies Table -->
<div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
  <div class="p-4 sm:p-6 border-b border-gray-700">
    <h2 class="text-lg sm:text-xl font-bold text-gray-100 flex items-center gap-2">
      <span class="text-xl sm:text-2xl">🎮</span> Games Collection
    </h2>
  </div>

  <!-- Mobile Card View (visible on small screens) -->
  <div class="block lg:hidden p-4 space-y-4">
    @forelse($movies as $m)
      <div class="bg-gray-700 rounded-lg p-4 border border-gray-600">
        <div class="mb-3 flex items-center gap-2">
          <!-- Mobile Photo -->
          @if($m->photo)
            <img src="{{ Storage::url($m->photo) }}" alt="{{ $m->title }}" class="h-12 w-12 rounded-full object-cover">
          @else
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                {{ Str::upper(substr($m->title, 0, 2)) }}
            </div>
          @endif

          <div>
            <h3 class="text-sm font-bold text-gray-100">{{ $m->title }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ $m->director }} • {{ $m->release_year }}</p>
          </div>
        </div>

        <div class="space-y-2 mb-4 text-xs">
          @if($m->genre)
            <div>
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-700 text-blue-200">
                {{ $m->genre->name }}
              </span>
            </div>
          @endif
          
          @if($m->rating)
            <div class="text-yellow-400">
              ⭐ {{ $m->rating }}
            </div>
          @endif

          <div class="text-gray-300 line-clamp-2">
            {{ $m->description ?? 'N/A' }}
          </div>

          <div class="text-gray-500">
            {{ $m->created_at ? $m->created_at->format('M d, Y') : 'N/A' }}
          </div>
        </div>

        <div class="flex gap-2 pt-3 border-t border-gray-600">
          <button 
            type="button" 
            onclick="openEditModal(
              {{ $m->id }}, 
              '{{ addslashes($m->title) }}', 
              '{{ $m->genre_id }}', 
              '{{ $m->rating }}', 
              '{{ addslashes($m->director) }}', 
              '{{ $m->release_year }}', 
              '{{ addslashes($m->description ?? '') }}'
            )"
            class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-200"
          >
            ✏️ Edit
          </button>
        </div>
      </div>
    @empty
      <div class="py-8 text-center text-gray-400">
        <div class="flex flex-col items-center justify-center">
          <span class="text-4xl mb-2">🥀</span>
          <p class="text-sm">No Games found. Start by adding your first Game!</p>
        </div>
      </div>
    @endforelse
  </div>

  <!-- Desktop Table View (hidden on small screens) -->
  <div class="hidden lg:block overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-900 border-b border-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Photo</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Title</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Genre</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Developer</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Year</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Rating</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Description</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Actions</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-400">Added On</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-700">
        @forelse($movies as $m)
        <tr class="hover:bg-gray-700 transition-colors duration-150">

          <!-- Photo -->
          <td class="px-6 py-4">
            @if($m->photo)
                <img
                    src="{{ Storage::url($m->photo) }}"
                    alt="{{ $m->title }}"
                    class="h-12 w-12 rounded-full object-cover ring-2 ring-blue-100 dark:ring-blue-900"
                >
            @else
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                    {{ Str::upper(substr($m->title, 0, 2)) }}
                </div>
            @endif
          </td>

          <!-- Title -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-100 font-medium">{{ $m->title }}</td>

          <!-- Genre -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-300">
            @if($m->genre)
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-700 text-blue-200">
                {{ $m->genre->name }}
              </span>
            @else
              <span class="text-gray-500">N/A</span>
            @endif
          </td>

          <!-- Director -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-300">{{ $m->director }}</td>

          <!-- Year -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-300">{{ $m->release_year }}</td>

          <!-- Rating -->
          <td class="px-6 py-4 text-xs sm:text-sm text-yellow-400">
            @if($m->rating)
              ⭐ {{ $m->rating }}
            @else
              <span class="text-gray-500">N/A</span>
            @endif
          </td>

          <!-- Description -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-300 max-w-xs truncate">
            {{ $m->description ?? 'N/A' }}
          </td>

          <!-- Actions -->
          <td class="px-6 py-4 text-xs sm:text-sm">
            <div class="flex gap-2">
              <!-- Edit Button -->
              <button 
                type="button" 
                onclick="openEditModal(
                  {{ $m->id }}, 
                  '{{ addslashes($m->title) }}', 
                  '{{ $m->genre_id }}', 
                  '{{ $m->rating }}', 
                  '{{ addslashes($m->director) }}', 
                  '{{ $m->release_year }}', 
                  '{{ addslashes($m->description ?? '') }}'
                )"
                class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-200"
              >
                ✏️ Edit
              </button>

              <!-- Delete Button -->
              <form method="POST" action="{{ route('movies.destroy',$m) }}" onsubmit="return confirm('Are you sure you want to delete this Game?');" class="inline">
                @csrf 
                @method('DELETE')
                <button 
                  type="submit" 
                  class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-colors duration-200"
                >
                  🗑️ Delete
                </button>
              </form>
            </div>
          </td>

          <!-- Added On -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-400">
            {{ $m->created_at ? $m->created_at->format('M d, Y h:i A') : 'N/A' }}
          </td>

        </tr>
        @empty
        <tr>
          <td colspan="8" class="px-6 py-8 text-center text-gray-400">
            <div class="flex flex-col items-center justify-center">
              <span class="text-4xl mb-2">🥀</span>
              <p class="text-sm">No Games found. Start by adding your first Game!</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 p-4">
    <div class="bg-gray-800 rounded-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-xl">
        <div class="sticky top-0 bg-gradient-to-r from-blue-700 to-blue-800 px-4 sm:px-6 py-4 border-b border-gray-700">
            <h2 class="text-lg sm:text-xl font-bold text-white">✏️ Edit Game</h2>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Title</label>
                    <input 
                      type="text" 
                      name="title" 
                      id="editTitle" 
                      class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                    />
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Director</label>
                    <input 
                      type="text" 
                      name="director" 
                      id="editDirector" 
                      class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Release Year</label>
                    <input 
                      type="number" 
                      name="release_year" 
                      id="editYear" 
                      class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                    />
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Genre</label>
                    <select 
                      name="genre_id" 
                      id="editGenre" 
                      class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                    >
                        <option value="">Select Game Genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Rating</label>
                <input 
                  type="text" 
                  name="rating" 
                  id="editRating" 
                  class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                />
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea 
                  name="description" 
                  id="editDescription" 
                  rows="4"
                  class="w-full px-3 sm:px-4 py-2 border border-gray-600 bg-gray-700 text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                ></textarea>
            </div>

            <!-- Photo Upload in Edit Modal -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Games Photo
                </label>

                <!-- Current Photo Preview -->
                <div id="currentPhotoPreview" class="mb-3"></div>

                <input
                    type="file"
                    id="edit_photo"
                    name="photo"
                    accept="image/jpeg,image/png,image/jpg"
                    class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm
                           file:mr-4 file:rounded-md file:border-0
                           file:bg-blue-50 file:px-4 file:py-2
                           file:text-sm file:font-medium file:text-blue-700
                           hover:file:bg-blue-100
                           dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100
                           dark:file:bg-blue-900/20 dark:file:text-blue-400"
                >

                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    Leave empty to keep current photo. JPG, PNG or JPEG. Max 2MB.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-700">
                <button 
                  type="button" 
                  onclick="closeEditModal()" 
                  class="px-4 py-2 border border-gray-600 text-gray-200 rounded-lg hover:bg-gray-700 font-medium transition-colors duration-200 text-sm"
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  class="px-4 py-2 bg-gradient-to-r from-blue-700 to-blue-800 text-white rounded-lg hover:from-blue-800 hover:to-blue-900 font-medium transition-all duration-200 text-sm"
                >
                  Update Games
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, title, genre_id, rating, director, release_year, description, photo) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editTitle').value = decodeURIComponent(title);
    document.getElementById('editGenre').value = genre_id;
    document.getElementById('editRating').value = rating;
    document.getElementById('editDirector').value = decodeURIComponent(director);
    document.getElementById('editYear').value = release_year;
    document.getElementById('editDescription').value = decodeURIComponent(description);

     

    // Current Photo Preview
    const preview = document.getElementById('currentPhotoPreview');
    preview.innerHTML = '';
    const movie = @json($movies->keyBy('id'));
    if(movie[id].photo){
        const img = document.createElement('img');
        img.src = '{{ url('') }}/storage/' + movie[id].photo;
        img.alt = movie[id].title;
        img.className = 'h-20 w-20 rounded-lg object-cover';
        preview.appendChild(img);
    }

    document.getElementById('editForm').action = `/movies/${id}`;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});
</script>

@endsection
