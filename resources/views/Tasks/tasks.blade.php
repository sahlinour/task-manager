@extends('layouts.app')

@section('title', 'Mes Tâches')

@section('content')

{{-- ════════════════════════════════════════
     PAGE HEADER
════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Mes Tâches</h1>
        <p class="text-white/30 text-xs mt-1">
            {{ $tasks->count() }} tâche(s) au total
        </p>
    </div>

    <a href="{{ route('tasks.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl
              bg-[#FF0B55] hover:bg-[#e0004a] text-white text-sm font-semibold
              shadow-lg shadow-pink-600/30 hover:shadow-pink-600/50
              transition-all duration-200 active:scale-95">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle tâche
    </a>
</div>

{{-- ════════════════════════════════════════
     FILTRES
════════════════════════════════════════ --}}
<div class="flex flex-col sm:flex-row gap-3 mb-6">

    {{-- Search --}}
    <div class="relative flex-1">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-white/30 pointer-events-none"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input id="searchInput"
               type="text"
               placeholder="Rechercher une tâche..."
               class="w-full pl-10 pr-4 py-2.5 rounded-xl glass border border-white/10
                      text-sm text-white placeholder-white/25
                      focus:outline-none focus:border-[#FF0B55]/40
                      transition-all duration-200 bg-transparent">
    </div>

    {{-- Status tabs --}}
    <div class="flex items-center gap-1 glass border border-white/10 rounded-xl p-1">
        @foreach(['' => 'Tous', 'todo' => 'À faire', 'in_progress' => 'En cours', 'completed' => 'Terminées'] as $val => $label)
        <button onclick="filterByStatus('{{ $val }}')"
                data-status="{{ $val }}"
                class="status-tab px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200
                       {{ $val === '' ? 'bg-white/10 text-white' : 'text-white/40 hover:text-white' }}">
            {{ $label }}
        </button>
        @endforeach
    </div>

</div>

{{-- ════════════════════════════════════════
     EMPTY STATE
════════════════════════════════════════ --}}
@if($tasks->isEmpty())
<div class="flex flex-col items-center justify-center py-24 text-center">
    <div class="w-20 h-20 rounded-3xl glass border border-white/8
                flex items-center justify-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                     M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
        </svg>
    </div>
    <p class="text-white/30 font-semibold">Aucune tâche pour le moment</p>
    <p class="text-white/15 text-sm mt-1">Commencez par créer votre première tâche</p>
    <a href="{{ route('tasks.create') }}"
       class="mt-6 flex items-center gap-2 px-5 py-2.5 rounded-xl
              bg-[#FF0B55] text-white text-sm font-semibold
              shadow-lg shadow-pink-600/30 hover:bg-[#e0004a] transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Créer une tâche
    </a>
</div>

@else

{{-- ════════════════════════════════════════
     TASKS GRID
════════════════════════════════════════ --}}
<div id="taskGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

    @foreach($tasks as $task)
    <div class="task-card group relative glass rounded-2xl border border-white/8 overflow-hidden
                hover:border-white/15 transition-all duration-300
                hover:shadow-lg hover:shadow-black/20 hover:-translate-y-0.5"
         data-status="{{ $task->status }}"
         data-title="{{ strtolower($task->title) }}">

        {{-- Status color bar --}}
        <div class="absolute top-0 left-0 right-0 h-[2px]
            @if($task->status === 'completed') bg-gradient-to-r from-emerald-500 to-transparent
            @elseif($task->status === 'in_progress') bg-gradient-to-r from-amber-500 to-transparent
            @else bg-gradient-to-r from-white/20 to-transparent @endif">
        </div>

        <div class="p-5">

            {{-- Header --}}
            <div class="flex items-start justify-between gap-3 mb-3">

                {{-- Status badge --}}
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold
                    @if($task->status === 'completed')
                        bg-emerald-500/15 text-emerald-400 border border-emerald-500/25
                    @elseif($task->status === 'in_progress')
                        bg-amber-500/15 text-amber-400 border border-amber-500/25
                    @else
                        bg-white/8 text-white/40 border border-white/10
                    @endif">

                    @if($task->status === 'completed')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Terminée
                    @elseif($task->status === 'in_progress')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        En cours
                    @else
                        <span class="w-2 h-2 rounded-full bg-white/30"></span>
                        À faire
                    @endif
                </span>

                {{-- Date --}}
                <span class="text-white/20 text-[10px] shrink-0 mt-0.5">
                    {{ $task->created_at->format('d/m/Y') }}
                </span>
            </div>

            {{-- Title --}}
            <h3 class="font-bold text-white text-base leading-snug mb-2
                       {{ $task->status === 'completed' ? 'line-through text-white/40' : '' }}">
                {{ $task->title }}
            </h3>

            {{-- Description --}}
            @if($task->description)
            <p class="text-white/35 text-sm leading-relaxed line-clamp-2">
                {{ $task->description }}
            </p>
            @else
            <p class="text-white/15 text-sm italic">Aucune description</p>
            @endif

            {{-- Divider --}}
            <div class="h-px bg-white/5 my-4"></div>

            {{-- Actions --}}
            <div class="flex items-center gap-2">

                <a href="{{ route('tasks.edit', $task->id) }}"
                   class="flex-1 flex items-center justify-center gap-1.5
                          px-3 py-2 rounded-xl text-xs font-semibold
                          bg-white/5 hover:bg-blue-500/15 hover:text-blue-400
                          text-white/50 border border-white/8 hover:border-blue-500/25
                          transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>

                {{-- Delete form --}}
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                      onsubmit="return confirm('Supprimer cette tâche ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="flex items-center justify-center gap-1.5
                                   px-3 py-2 rounded-xl text-xs font-semibold
                                   bg-white/5 hover:bg-red-500/15 hover:text-red-400
                                   text-white/50 border border-white/8 hover:border-red-500/25
                                   transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                                     m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </form>

            </div>
        </div>
    </div>
    @endforeach

</div>

{{-- No results message --}}
<div id="noResults" class="hidden flex flex-col items-center justify-center py-16 text-center">
    <p class="text-white/25 font-medium">Aucune tâche trouvée</p>
    <p class="text-white/15 text-xs mt-1">Essayez un autre mot-clé ou filtre</p>
</div>

@endif

@endsection

@push('scripts')
<script>
    // ── Filtre par statut (tabs) ────────────────────────────────
    let activeStatus = '';

    function filterByStatus(status) {
        activeStatus = status;

        // Update tab styles
        document.querySelectorAll('.status-tab').forEach(tab => {
            const isActive = tab.dataset.status === status;
            tab.classList.toggle('bg-white/10', isActive);
            tab.classList.toggle('text-white',   isActive);
            tab.classList.toggle('text-white/40', !isActive);
        });

        applyFilters();
    }

    // ── Recherche live ──────────────────────────────────────────
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    function applyFilters() {
        const q       = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const cards   = document.querySelectorAll('.task-card');
        const noRes   = document.getElementById('noResults');
        let   visible = 0;

        cards.forEach(card => {
            const titleMatch  = card.dataset.title.includes(q);
            const statusMatch = activeStatus === '' || card.dataset.status === activeStatus;

            if (titleMatch && statusMatch) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noRes) noRes.classList.toggle('hidden', visible > 0);
    }
</script>
@endpush