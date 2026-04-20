@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ════════════════════════════════════════
     PAGE HEADER
════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">
            Bonjour, <span class="text-[#FF0B55]">{{ auth()->user()->name }} 👋</span>
        </h1>
        <p class="text-white/35 text-sm mt-1">Voici un aperçu de vos tâches aujourd'hui.</p>
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
     STATS CARDS
════════════════════════════════════════ --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

    {{-- Total --}}
    <div class="relative overflow-hidden rounded-2xl p-5 glass border border-white/8
                hover:border-white/15 transition-all duration-300 group">
        <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full
                    bg-violet-500/10 blur-2xl group-hover:bg-violet-500/20 transition-all duration-500"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-white/40 text-xs font-semibold uppercase tracking-widest mb-2">Total</p>
                <p class="text-4xl font-extrabold text-white">{{ $totalTasks }}</p>
                <p class="text-white/30 text-xs mt-1">tâches créées</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-violet-500/20 border border-violet-500/30
                        flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                             M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
            </div>
        </div>
        {{-- Progress bar --}}
        <div class="mt-4 h-1 rounded-full bg-white/5">
            <div class="h-1 rounded-full bg-violet-500" style="width: 100%"></div>
        </div>
    </div>

    {{-- Completed --}}
    <div class="relative overflow-hidden rounded-2xl p-5 glass border border-white/8
                hover:border-white/15 transition-all duration-300 group">
        <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full
                    bg-emerald-500/10 blur-2xl group-hover:bg-emerald-500/20 transition-all duration-500"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-white/40 text-xs font-semibold uppercase tracking-widest mb-2">Complétées</p>
                <p class="text-4xl font-extrabold text-white">{{ $completedTasks }}</p>
                <p class="text-white/30 text-xs mt-1">tâches terminées</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-500/20 border border-emerald-500/30
                        flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
        <div class="mt-4 h-1 rounded-full bg-white/5">
            @php $completedPct = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0; @endphp
            <div class="h-1 rounded-full bg-emerald-500 transition-all duration-700"
                 style="width: {{ $completedPct }}%"></div>
        </div>
    </div>

    {{-- In Progress --}}
    <div class="relative overflow-hidden rounded-2xl p-5 glass border border-white/8
                hover:border-white/15 transition-all duration-300 group">
        <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full
                    bg-amber-500/10 blur-2xl group-hover:bg-amber-500/20 transition-all duration-500"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-white/40 text-xs font-semibold uppercase tracking-widest mb-2">En cours</p>
                <p class="text-4xl font-extrabold text-white">{{ $inProgressTasks }}</p>
                <p class="text-white/30 text-xs mt-1">tâches actives</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-500/20 border border-amber-500/30
                        flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-4 h-1 rounded-full bg-white/5">
            @php $inProgressPct = $totalTasks > 0 ? round(($inProgressTasks / $totalTasks) * 100) : 0; @endphp
            <div class="h-1 rounded-full bg-amber-500 transition-all duration-700"
                 style="width: {{ $inProgressPct }}%"></div>
        </div>
    </div>

</div>

{{-- ════════════════════════════════════════
     FILTERS
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

    {{-- Status filter --}}
    <div class="relative sm:w-48">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-white/30 pointer-events-none"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
        </svg>
        <select id="statusFilter"
                class="w-full pl-10 pr-4 py-2.5 rounded-xl glass border border-white/10
                       text-sm text-white/70
                       focus:outline-none focus:border-[#FF0B55]/40
                       transition-all duration-200 bg-gray-950 appearance-none cursor-pointer">
            <option value="">Tous les statuts</option>
            <option value="todo">To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>

</div>

{{-- ════════════════════════════════════════
     TASKS CHECKLIST
════════════════════════════════════════ --}}
<div class="glass rounded-2xl border border-white/8 overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-white/8">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-[#FF0B55] animate-pulse"></div>
            <h3 class="text-base font-bold text-white">Liste des tâches</h3>
            <span class="px-2 py-0.5 rounded-full bg-[#FF0B55]/20 border border-[#FF0B55]/30
                         text-[#FF0B55] text-xs font-bold">
                {{ $tasks->count() }}
            </span>
        </div>
    </div>

    {{-- Task list --}}
    <ul id="taskList" class="divide-y divide-white/5">

        @forelse($tasks as $task)
        <li class="task-item flex items-center gap-4 px-6 py-4
                   hover:bg-white/3 transition-all duration-200 group"
            data-status="{{ $task->status }}"
            data-title="{{ strtolower($task->title) }}">

            {{-- Checkbox --}}
            <div class="shrink-0">
                <input type="checkbox"
                       {{ $task->status === 'completed' ? 'checked' : '' }}
                       class="w-4 h-4 rounded accent-[#FF0B55] cursor-pointer">
            </div>

            {{-- Dot status indicator --}}
            <div class="shrink-0 w-2 h-2 rounded-full
                @if($task->status === 'completed') bg-emerald-400
                @elseif($task->status === 'in_progress') bg-amber-400
                @else bg-white/20 @endif">
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold truncate
                           {{ $task->status === 'completed' ? 'line-through text-white/30' : 'text-white' }}">
                    {{ $task->title }}
                </h4>
                @if($task->description)
                <p class="text-white/35 text-xs truncate mt-0.5">{{ $task->description }}</p>
                @endif
            </div>

            {{-- Status badge --}}
            <div class="shrink-0 hidden sm:block">
                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold
                    @if($task->status === 'completed')
                        bg-emerald-500/15 text-emerald-400 border border-emerald-500/25
                    @elseif($task->status === 'in_progress')
                        bg-amber-500/15 text-amber-400 border border-amber-500/25
                    @else
                        bg-white/8 text-white/40 border border-white/10
                    @endif">
                    @if($task->status === 'completed') ✓ Terminée
                    @elseif($task->status === 'in_progress') ⚡ En cours
                    @else ○ À faire
                    @endif
                </span>
            </div>

            {{-- Actions --}}
            <div class="shrink-0 flex items-center gap-1
                        opacity-0 group-hover:opacity-100 transition-opacity duration-200">

                <a href="{{ route('tasks.edit', $task->id) }}"
                   class="w-8 h-8 rounded-lg flex items-center justify-center
                          bg-white/5 hover:bg-blue-500/20 hover:text-blue-400
                          text-white/40 transition-all duration-200"
                   title="Modifier">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>

                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                      onsubmit="return confirm('Supprimer cette tâche ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-8 h-8 rounded-lg flex items-center justify-center
                                   bg-white/5 hover:bg-red-500/20 hover:text-red-400
                                   text-white/40 transition-all duration-200"
                            title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>

            </div>
        </li>
        @empty
        <li class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/8
                        flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                             M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
            </div>
            <p class="text-white/30 text-sm font-medium">Aucune tâche pour le moment</p>
            <a href="{{ route('tasks.create') }}"
               class="mt-4 px-4 py-2 rounded-xl bg-[#FF0B55] text-white text-sm font-semibold
                      hover:bg-[#e0004a] transition-all duration-200">
                Créer une tâche
            </a>
        </li>
        @endforelse

    </ul>

    {{-- Footer pagination --}}
    @if($tasks->count() > 0)
    <div class="px-6 py-3 border-t border-white/5 flex items-center justify-between">
        <p class="text-white/25 text-xs">{{ $tasks->count() }} tâche(s) affichée(s)</p>
        <div id="noResults" class="hidden text-white/30 text-xs">Aucun résultat</div>
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    // ── Filtrage live (search + status) ──────────────────────────
    const searchInput  = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const taskItems    = document.querySelectorAll('.task-item');
    const noResults    = document.getElementById('noResults');

    function filterTasks() {
        const q      = searchInput.value.toLowerCase().trim();
        const status = statusFilter.value;
        let   count  = 0;

        taskItems.forEach(item => {
            const titleMatch  = item.dataset.title.includes(q);
            const statusMatch = status === '' || item.dataset.status === status;

            if (titleMatch && statusMatch) {
                item.style.display = '';
                count++;
            } else {
                item.style.display = 'none';
            }
        });

        if (noResults) noResults.classList.toggle('hidden', count > 0);
    }

    searchInput.addEventListener('input', filterTasks);
    statusFilter.addEventListener('change', filterTasks);
</script>
@endpush