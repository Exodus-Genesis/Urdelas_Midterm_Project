@extends('layouts.app')
@section('content')

<!-- Page Header -->
<div class="bg-gray-900 shadow-sm sticky top-0 z-40 -mx-6 px-4 sm:px-6 py-4 mb-6">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0">
    <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center gap-2">
      <span class="text-2xl sm:text-3xl">🖥️</span> Game Genre Management
    </h1>
    <div class="text-xs sm:text-sm text-gray-300">
      {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
    </div>
  </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">

  <!-- Total Genres -->
  <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 sm:p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-200 text-xs sm:text-sm font-medium">Total Genre</p>
        <p class="text-2xl sm:text-3xl font-bold text-white mt-2">{{ $totalGenres }}</p>
      </div>
      <div class="text-4xl sm:text-5xl opacity-30">🕹️</div>
    </div>
    <p class="text-xs text-gray-300 mt-4">Game Genre available in your system</p>
  </div>

  <!-- Genre with Most Movies -->
  <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 sm:p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-200 text-xs sm:text-sm font-medium">Top platform</p>
        <p class="text-xl sm:text-2xl font-bold text-white mt-2">
          {{ $topGenre ? $topGenre->name : 'No Genre yet' }}
        </p>
      </div>
      <div class="text-4xl sm:text-5xl opacity-30">🏆</div>
    </div>
    <p class="text-xs text-gray-300 mt-4">
      {{ $topGenre ? $topGenre->movies_count . ' games ' : 'No data available' }}
    </p>
  </div>

  <!-- Total Movies Inside All Genres -->
  <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-4 sm:p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-200 text-xs sm:text-sm font-medium">Total Games Across Platforms</p>
        <p class="text-2xl sm:text-3xl font-bold text-white mt-2">{{ $totalMoviesAcrossGenres }}</p>
      </div>
      <div class="text-4xl sm:text-5xl opacity-30">🖥️</div>
    </div>
    <p class="text-xs text-gray-300 mt-4">Total games counted from all platforms</p>
  </div>

</div>

<!-- Add New Genre Form -->
<div class="bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-8">
  <h2 class="text-lg sm:text-xl font-bold text-white mb-6 flex items-center gap-2">
    <span class="text-xl sm:text-2xl">⛶</span> Add New Game Genre
  </h2>
  
  <form method="POST" action="{{ route('genres.store') }}" class="space-y-4">
    @csrf
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-200 mb-2">Genre Name <span class="text-red-500">*</span></label>
        <input 
          name="name" 
          value="{{ old('name') }}"
          placeholder="Enter genre name"
          class="w-full px-3 sm:px-4 py-2 border border-gray-700 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none transition text-sm bg-gray-900 text-white"
          required
        />
        @error('name')
          <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div>
      <label class="block text-xs sm:text-sm font-medium text-gray-200 mb-2">Description</label>
      <textarea 
        name="description" 
        placeholder="Enter genre description..."
        rows="3"
        class="w-full px-3 sm:px-4 py-2 border border-gray-700 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none transition text-sm bg-gray-900 text-white"
      >{{ old('description') }}</textarea>
    </div>

    <div class="flex justify-end pt-4">
      <button 
        type="submit" 
        class="px-4 sm:px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-950 font-medium transition-all duration-200 flex items-center gap-2 text-sm sm:text-base"
      >
        <span>𖦏</span> Add Genre
      </button>
    </div>
  </form>
</div>

<!-- All Genres Table -->
<div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
  <div class="p-4 sm:p-6 border-b border-gray-700">
    <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
      <span class="text-xl sm:text-2xl">🕹️</span> All Game Genre
    </h2>
  </div>

  <!-- Mobile Card View -->
  <div class="block lg:hidden p-4 space-y-4">
    @forelse($genres as $g)
      <div class="bg-gray-900 rounded-lg p-4 border border-gray-700">
        <div class="mb-3">
          <div class="flex items-center gap-2 mb-2">
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-800 text-white">
              {{ $g->name }}
            </span>
          </div>
          @if($g->description)
            <p class="text-xs sm:text-sm text-gray-300 line-clamp-2">{{ $g->description }}</p>
          @else
            <p class="text-xs text-gray-400 italic">No description</p>
          @endif
        </div>

        <div class="space-y-2 mb-4 text-xs sm:text-sm">
          <div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-800 text-white">
              🎥 {{ $g->movies_count }}
              <span class="ml-1">{{ $g->movies_count === 1 ? 'games' : 'games' }}</span>
            </span>
          </div>

          <div class="text-gray-300 text-xs">
            {{ $g->created_at ? $g->created_at->format('M d, Y') : 'N/A' }}
          </div>
        </div>

        <div class="flex gap-2 pt-3 border-t border-gray-700">
          <button 
            type="button"
            onclick="openEditGenreModal({{ $g->id }}, '{{ addslashes($g->name) }}', '{{ addslashes($g->description ?? '') }}')"
            class="flex-1 px-3 py-2 bg-gray-800 hover:bg-gray-900 text-white text-xs font-medium rounded-lg transition-colors duration-200"
          >
            ✏️ Edit
          </button>

          <form method="POST" action="{{ route('genres.destroy', $g) }}" onsubmit="return confirm('Are you sure?');" class="flex-1">
            @csrf
            @method('DELETE')
            <button 
              type="submit" 
              class="w-full px-3 py-2 bg-red-700 hover:bg-red-800 text-white text-xs font-medium rounded-lg transition-colors duration-200"
            >
              🗑️ Delete
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="py-8 text-center text-gray-300">
        <div class="flex flex-col items-center justify-center">
          <span class="text-4xl mb-2">🥀</span>
          <p class="text-sm font-medium">No genres found yet</p>
          <p class="text-xs text-gray-400">Create your first genre to get started!</p>
        </div>
      </div>
    @endforelse
  </div>

  <!-- Desktop Table View -->
  <div class="hidden lg:block overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-900 border-b border-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-white">Genre Name</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-white">Description</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-white">Games played</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-white">Added On</th>
          <th class="px-6 py-3 text-left text-xs sm:text-sm font-semibold text-white">Actions</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-700">
        @forelse($genres as $g)
        <tr class="hover:bg-gray-800 transition-colors duration-150">

          <!-- Genre Name -->
          <td class="px-6 py-4 text-xs sm:text-sm text-white font-medium">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-800 text-white">
              {{ $g->name }}
            </span>
          </td>

          <!-- Description -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-300">
            @if($g->description)
              <span class="line-clamp-2">{{ $g->description }}</span>
            @else
              <span class="text-gray-400 italic">No description</span>
            @endif
          </td>

          <!-- Movies Count -->
          <td class="px-6 py-4 text-xs sm:text-sm">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-800 text-white">
              🎥 {{ $g->movies_count }}
              <span class="ml-1">{{ $g->movies_count === 1 ? 'Games' : 'Games' }}</span>
            </span>
          </td>

          <!-- Added On -->
          <td class="px-6 py-4 text-xs sm:text-sm text-gray-300">
            {{ $g->created_at ? $g->created_at->format('M d, Y h:i A') : 'N/A' }}
          </td>

          <!-- Actions -->
          <td class="px-6 py-4 text-xs sm:text-sm">
            <div class="flex gap-2">

              <!-- Edit Button -->
              <button 
                type="button"
                onclick="openEditGenreModal({{ $g->id }}, '{{ addslashes($g->name) }}', '{{ addslashes($g->description ?? '') }}')"
                class="px-3 py-1 bg-gray-800 hover:bg-gray-900 text-white text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1"
              >
                ✏️ Edit
              </button>

              <!-- Delete Button -->
              <form method="POST" action="{{ route('genres.destroy', $g) }}" onsubmit="return confirm('Are you sure you want to delete this genre? This action cannot be undone.');" class="inline">
                @csrf
                @method('DELETE')
                <button 
                  type="submit" 
                  class="px-3 py-1 bg-red-700 hover:bg-red-800 text-white text-xs font-medium rounded-lg transition-colors duration-200 flex items-center gap-1"
                >
                  🗑️ Delete
                </button>
              </form>

            </div>
          </td>

        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-6 py-8 text-center text-gray-300">
            <div class="flex flex-col items-center justify-center">
              <span class="text-4xl mb-2">🥀</span>
              <p class="font-medium text-sm">No genres found yet</p>
              <p class="text-xs text-gray-400">Create your first genre to get started!</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Genre Modal -->
<div id="editGenreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
  <div class="bg-gray-900 rounded-lg w-full max-w-md max-h-[90vh] overflow-y-auto shadow-xl">
    <!-- Modal Header -->
    <div class="sticky top-0 bg-gray-800 px-4 sm:px-6 py-4 border-b border-gray-700">
      <h2 class="text-lg sm:text-xl font-bold text-white">✏️ Edit Genre</h2>
    </div>

    <!-- Modal Body -->
    <form id="editGenreForm" method="POST" class="p-4 sm:p-6 space-y-4">
      @csrf
      @method('PUT')
      
      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-200 mb-2">Genre Name</label>
        <input 
          type="text" 
          name="name" 
          id="editGenreName" 
          class="w-full px-3 sm:px-4 py-2 border border-gray-700 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none transition text-sm bg-gray-800 text-white"
          required
        />
      </div>

      <div>
        <label class="block text-xs sm:text-sm font-medium text-gray-200 mb-2">Description</label>
        <textarea 
          name="description" 
          id="editGenreDescription" 
          rows="4"
          class="w-full px-3 sm:px-4 py-2 border border-gray-700 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none transition text-sm bg-gray-800 text-white"
        ></textarea>
      </div>

      <!-- Modal Footer -->
      <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-700">
        <button 
          type="button" 
          onclick="closeEditGenreModal()" 
          class="px-4 py-2 border border-gray-600 text-gray-200 rounded-lg hover:bg-gray-800 font-medium transition-colors duration-200 text-sm"
        >
          Cancel
        </button>
        <button 
          type="submit" 
          class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 font-medium transition-all duration-200 text-sm"
        >
          Update Genre
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditGenreModal(id, name, description) {
    document.getElementById('editGenreModal').classList.remove('hidden');
    document.getElementById('editGenreName').value = decodeURIComponent(name);
    document.getElementById('editGenreDescription').value = decodeURIComponent(description);
    document.getElementById('editGenreForm').action = `/genres/${id}`;
}

function closeEditGenreModal() {
    document.getElementById('editGenreModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editGenreModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditGenreModal();
    }
});

// Close modal when pressing Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditGenreModal();
    }
});
</script>

@endsection
