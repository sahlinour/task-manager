@extends('layouts.app')

@section('title', 'Modifier la tâche')

@section('content')

{{-- ════════════════════════════════════════
     PAGE HEADER
════════════════════════════════════════ --}}
<div class="flex items-center gap-3 mb-8">
    <a href="{{ route('tasks.index') }}"
       class="w-9 h-9 rounded-xl glass border border-white/10 flex items-center justify-center
              text-white/40 hover:text-white hover:border-white/20 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-extrabold text-white tracking-tight">Modifier la tâche</h1>
        <p class="text-white/30 text-xs mt-0.5">
            Créée le {{ $task->created_at->format('d/m/Y à H:i') }}
        </p>
    </div>

    {{-- Status badge actuel --}}
    <div class="ml-auto">
        <span class="px-3 py-1.5 rounded-xl text-xs font-bold
            @if($task->status === 'completed') bg-emerald-500/15 text-emerald-400 border border-emerald-500/25
            @elseif($task->status === 'in_progress') bg-amber-500/15 text-amber-400 border border-amber-500/25
            @else bg-white/8 text-white/40 border border-white/10 @endif">
            @if($task->status === 'completed') ✓ Terminée
            @elseif($task->status === 'in_progress') ⚡ En cours
            @else ○ À faire @endif
        </span>
    </div>
</div>

{{-- ════════════════════════════════════════
     FORM CARD
════════════════════════════════════════ --}}
<div >
    <div class="relative glass rounded-2xl border border-white/8 overflow-hidden">

        {{-- Accent top --}}
        <div class="absolute top-0 left-0 right-0 h-[2px]
                    bg-gradient-to-r from-blue-500 via-blue-400 to-transparent"></div>

        {{-- Glow décoratif --}}
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full
                    bg-blue-500/8 blur-3xl pointer-events-none"></div>

        <div class="relative p-7">

            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- ── TITLE ── --}}
                <div class="space-y-2">
                    <label for="title" class="flex items-center gap-2 text-sm font-semibold text-white/70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#FF0B55]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Titre
                        <span class="text-[#FF0B55]">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', $task->title) }}"
                           required
                           autocomplete="off"
                           class="w-full px-4 py-3 rounded-xl
                                  bg-white/5 border border-white/10 text-white text-sm
                                  placeholder-white/20
                                  focus:outline-none focus:border-blue-500/50 focus:bg-white/7
                                  transition-all duration-200
                                  @error('title') border-red-500/50 bg-red-500/5 @enderror">
                    @error('title')
                        <p class="text-red-400 text-xs flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- ── DESCRIPTION ── --}}
                <div class="space-y-2">
                    <label for="description" class="flex items-center gap-2 text-sm font-semibold text-white/70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#FF0B55]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10"/>
                        </svg>
                        Description
                        <span class="text-white/25 font-normal text-xs">(optionnel)</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              placeholder="Décrivez votre tâche en détail..."
                              class="w-full px-4 py-3 rounded-xl resize-none
                                     bg-white/5 border border-white/10 text-white text-sm
                                     placeholder-white/20
                                     focus:outline-none focus:border-blue-500/50 focus:bg-white/7
                                     transition-all duration-200
                                     @error('description') border-red-500/50 bg-red-500/5 @enderror">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-xs flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-right text-xs text-white/20">
                        <span id="charCount">{{ strlen($task->description ?? '') }}</span> caractères
                    </p>
                </div>

                {{-- ── STATUS ── --}}
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-semibold text-white/70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#FF0B55]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806
                                     3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806
                                     3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946
                                     3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946
                                     3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806
                                     3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806
                                     3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946
                                     3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946
                                     3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Statut
                        <span class="text-[#FF0B55]">*</span>
                    </label>

                    <div class="grid grid-cols-3 gap-3">

                        {{-- To Do --}}
                        <label class="status-option cursor-pointer">
                            <input type="radio" name="status" value="todo"
                                   class="sr-only"
                                   {{ old('status', $task->status) === 'todo' ? 'checked' : '' }}>
                            <div class="status-card flex flex-col items-center gap-2 px-3 py-4 rounded-xl
                                        border border-white/10 bg-white/5
                                        hover:border-white/20 hover:bg-white/8
                                        transition-all duration-200 text-center">
                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                    <span class="text-base leading-none">○</span>
                                </div>
                                <span class="text-xs font-semibold text-white/60">To Do</span>
                            </div>
                        </label>

                        {{-- In Progress --}}
                        <label class="status-option cursor-pointer">
                            <input type="radio" name="status" value="in_progress"
                                   class="sr-only"
                                   {{ old('status', $task->status) === 'in_progress' ? 'checked' : '' }}>
                            <div class="status-card flex flex-col items-center gap-2 px-3 py-4 rounded-xl
                                        border border-white/10 bg-white/5
                                        hover:border-amber-500/30 hover:bg-amber-500/5
                                        transition-all duration-200 text-center">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/15 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-white/60">In Progress</span>
                            </div>
                        </label>

                        {{-- Done --}}
                        <label class="status-option cursor-pointer">
                            <input type="radio" name="status" value="completed"
                                   class="sr-only"
                                   {{ old('status', $task->status) === 'completed' ? 'checked' : '' }}>
                            <div class="status-card flex flex-col items-center gap-2 px-3 py-4 rounded-xl
                                        border border-white/10 bg-white/5
                                        hover:border-emerald-500/30 hover:bg-emerald-500/5
                                        transition-all duration-200 text-center">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-white/60">Done</span>
                            </div>
                        </label>

                    </div>
                </div>

                {{-- ── DIVIDER ── --}}
                <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

                {{-- ── DANGER ZONE : Delete ── --}}
                {{-- Le form delete est ICI, EN DEHORS du form principal (forms imbriqués interdits en HTML) --}}
                <div class="glass rounded-xl border border-red-500/15 p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-red-400/80">Supprimer la tâche</p>
                        <p class="text-xs text-white/25 mt-0.5">Cette action est irréversible.</p>
                    </div>
                    {{-- Le bouton pointe vers form#delete-form via l'attribut form="" --}}
                    <button type="submit"
                            form="delete-form"
                            onclick="return confirm('Supprimer définitivement cette tâche ?')"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl
                                   bg-red-500/10 hover:bg-red-500/20
                                   border border-red-500/20 hover:border-red-500/40
                                   text-red-400 text-xs font-semibold
                                   transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </div>

                {{-- ── ACTIONS ── --}}
                <div class="flex items-center gap-3">

                    <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2
                                   px-6 py-3 rounded-xl
                                   bg-[#FF0B55] hover:bg-[#e0004a]
                                   text-white text-sm font-bold
                                  shadow-lg shadow-pink-600/30 hover:shadow-pink-600/50
                                   transition-all duration-200 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Sauvegarder les modifications
                    </button>

                    <a href="{{ route('tasks.index') }}"
                       class="px-5 py-3 rounded-xl glass border border-white/10
                              text-white/50 hover:text-white hover:border-white/20
                              text-sm font-medium transition-all duration-200">
                        Annuler
                    </a>

                </div>

            </form>

            {{-- ── Form DELETE séparé, invisible, EN DEHORS du form principal ── --}}
            <form id="delete-form"
                  action="{{ route('tasks.destroy', $task->id) }}"
                  method="POST"
                  class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .status-option input[type="radio"]:checked + .status-card {
        box-shadow: 0 0 0 1px rgba(59,130,246,0.4);
        border-color: rgba(59,130,246,0.45) !important;
        background: rgba(59,130,246,0.10) !important;
    }
    .status-option input[type="radio"]:checked + .status-card span {
        color: white !important;
    }
    input:-webkit-autofill,
    textarea:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px rgba(255,255,255,0.05) inset !important;
        -webkit-text-fill-color: white !important;
    }
</style>

<script>
    // ── Compteur de caractères ──────────────────────────────────
    const textarea  = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
    });

    // ── Couleur des status cards selon sélection ────────────────
    const radios = document.querySelectorAll('.status-option input[type="radio"]');
    const colors = {
        todo:        { border: 'rgba(255,255,255,0.20)', bg: 'rgba(255,255,255,0.08)' },
        in_progress: { border: 'rgba(251,191,36,0.40)', bg: 'rgba(251,191,36,0.10)'  },
        completed:   { border: 'rgba(52,211,153,0.40)', bg: 'rgba(52,211,153,0.10)'  },
    };

    function updateStatusCards() {
        radios.forEach(radio => {
            const card = radio.nextElementSibling;
            if (radio.checked) {
                const c = colors[radio.value] || colors.todo;
                card.style.borderColor = c.border;
                card.style.background  = c.bg;
            } else {
                card.style.borderColor = '';
                card.style.background  = '';
            }
        });
    }

    radios.forEach(r => r.addEventListener('change', updateStatusCards));
    updateStatusCards();
</script>
@endpush