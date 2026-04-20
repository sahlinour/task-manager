<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | TaskManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,11,85,0.3); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,11,85,0.6); }

        /* ── Glassmorphism cards ── */
        .glass {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .glass-hover:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.12);
        }
        .glass-pink {
            background: rgba(255,11,85,0.15);
            border: 1px solid rgba(255,11,85,0.25);
        }

        /* ── Sidebar active link ── */
        .nav-active {
            background: rgba(255,11,85,0.18) !important;
            border: 1px solid rgba(255,11,85,0.30) !important;
            color: white !important;
        }
        .nav-active .nav-icon {
            background: #FF0B55 !important;
            box-shadow: 0 4px 15px rgba(255,11,85,0.45);
        }

        /* ── Glow effects ── */
        .glow-pink { box-shadow: 0 0 30px rgba(255,11,85,0.25); }
        .glow-pink-sm { box-shadow: 0 4px 15px rgba(255,11,85,0.35); }

        /* ── Sidebar collapsed ── */
        #sidebar.collapsed { width: 72px; }
        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .sidebar-badge,
        #sidebar.collapsed .sidebar-logo-text,
        #sidebar.collapsed .sidebar-user-info,
        #sidebar.collapsed .sidebar-section-label { display: none; }
        #sidebar.collapsed .nav-link { justify-content: center; padding-left: 0; padding-right: 0; }
        #sidebar.collapsed .nav-icon-wrap { margin: 0 auto; }

        /* ── Animations ── */
        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.7); }
        }
        .animate-fade-down { animation: fadeSlideDown 0.4s ease forwards; }
        .animate-fade-up   { animation: fadeSlideUp  0.4s ease forwards; }
        .animate-pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }

        /* ── Mesh background ── */
        .mesh-bg {
            background-color: #070710;
            background-image:
                radial-gradient(ellipse 60% 40% at 10% 0%,   rgba(255,11,85,0.10) 0%, transparent 70%),
                radial-gradient(ellipse 50% 50% at 90% 100%, rgba(139,92,246,0.07) 0%, transparent 70%),
                radial-gradient(ellipse 40% 30% at 50% 50%,  rgba(255,11,85,0.04) 0%, transparent 70%);
        }

        /* ── Topbar notification badge ── */
        .notif-badge {
            position: absolute;
            top: -3px; right: -3px;
            width: 8px; height: 8px;
            background: #FF0B55;
            border-radius: 50%;
            border: 2px solid #070710;
        }

        /* ── Sidebar width transition ── */
        #sidebar { transition: width 0.3s cubic-bezier(0.4,0,0.2,1); overflow: hidden; }

        /* ── Toast ── */
        .toast {
            animation: fadeSlideDown 0.4s ease forwards;
        }

        /* ── Hover bg utility ── */
        .hover-glass:hover { background: rgba(255,255,255,0.06); }
    </style>
</head>

<body class="mesh-bg text-white min-h-screen flex overflow-hidden">

{{-- ════════════════════════════════════════
     SIDEBAR
════════════════════════════════════════ --}}
<aside id="sidebar" class="relative flex flex-col w-64 h-screen shrink-0 glass border-r border-white/8 z-40">

    {{-- Accent top bar --}}
    <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-[#FF0B55] via-pink-400 to-transparent z-10"></div>

    <div class="flex flex-col h-full py-5 px-3 gap-5">

        {{-- ── Logo ── --}}
        <div class="flex items-center gap-3 px-2">
            <div class="w-9 h-9 shrink-0 rounded-xl bg-[#FF0B55] flex items-center justify-center glow-pink-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                             M9 5a2 2 0 002 2h2a2 2 0 002-2
                             M9 5a2 2 0 012-2h2a2 2 0 012 2
                             m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <span class="sidebar-logo-text text-lg font-extrabold tracking-tight whitespace-nowrap">
                Task<span class="text-[#FF0B55]">Manager</span>
            </span>
        </div>

        {{-- ── Divider ── --}}
        <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mx-2"></div>

        {{-- ── User card ── --}}
        <div class="glass rounded-2xl px-3 py-3 flex items-center gap-3">
            <div class="w-9 h-9 shrink-0 rounded-xl bg-gradient-to-br from-[#FF0B55] to-rose-700 flex items-center justify-center font-bold text-sm glow-pink-sm">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="sidebar-user-info flex flex-col min-w-0">
                <span class="text-sm font-semibold text-white truncate leading-tight">
                    {{ auth()->user()->name ?? 'Utilisateur' }}
                </span>
                <span class="text-[11px] text-white/35 truncate">
                    {{ auth()->user()->email ?? '' }}
                </span>
            </div>
        </div>

        {{-- ── Navigation ── --}}
        <nav class="flex flex-col gap-1 flex-1">

            <p class="sidebar-section-label text-[10px] font-bold uppercase tracking-widest text-white/25 px-3 mb-1">Navigation</p>

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/55 hover:text-white hover-glass border border-transparent
                      transition-all duration-200
                      {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                <span class="nav-icon-wrap w-8 h-8 shrink-0 rounded-lg flex items-center justify-center
                             nav-icon bg-white/5 group-hover:bg-white/10 transition-all duration-200
                             {{ request()->routeIs('dashboard') ? 'bg-[#FF0B55] shadow-md shadow-pink-600/40' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
                <span class="sidebar-text text-sm font-medium">Dashboard</span>
                @if(request()->routeIs('dashboard'))
                    <span class="sidebar-badge ml-auto w-1.5 h-1.5 rounded-full bg-[#FF0B55] animate-pulse-dot"></span>
                @endif
            </a>

            {{-- Tasks --}}
            <a href="{{ route('tasks.index') }}"
               class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/55 hover:text-white hover-glass border border-transparent
                      transition-all duration-200
                      {{ request()->routeIs('tasks.*') ? 'nav-active' : '' }}">
                <span class="nav-icon-wrap w-8 h-8 shrink-0 rounded-lg flex items-center justify-center
                             nav-icon bg-white/5 group-hover:bg-white/10 transition-all duration-200
                             {{ request()->routeIs('tasks.*') ? 'bg-[#FF0B55] shadow-md shadow-pink-600/40' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                 M9 5a2 2 0 002 2h2a2 2 0 002-2M15 13l-3 3-1.5-1.5"/>
                    </svg>
                </span>
                <span class="sidebar-text text-sm font-medium">Mes tâches</span>
                @if(request()->routeIs('tasks.*'))
                    <span class="sidebar-badge ml-auto w-1.5 h-1.5 rounded-full bg-[#FF0B55] animate-pulse-dot"></span>
                @endif
            </a>

            
        </nav>

        {{-- ── Divider ── --}}
        <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mx-2"></div>

        {{-- ── Logout ── --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="nav-link group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl
                           text-white/40 hover:text-red-400 border border-transparent
                           hover:bg-red-500/10 hover:border-red-500/20
                           transition-all duration-200">
                <span class="nav-icon-wrap w-8 h-8 shrink-0 rounded-lg flex items-center justify-center
                             bg-white/5 group-hover:bg-red-500/20 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                    </svg>
                </span>
                <span class="sidebar-text text-sm font-medium">Déconnexion</span>
            </button>
        </form>

        {{-- ── Toggle collapse button ── --}}
        <button id="toggleSidebar"
                class="flex items-center justify-center gap-2 px-3 py-2 rounded-xl
                       text-white/30 hover:text-white/70 hover-glass
                       transition-all duration-200 text-xs">
            <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <span class="sidebar-text">Réduire</span>
        </button>

    </div>
</aside>

{{-- ════════════════════════════════════════
     MAIN WRAPPER
════════════════════════════════════════ --}}
<div class="flex-1 flex flex-col h-screen overflow-hidden">

    {{-- ── TOPBAR ── --}}
    <header class="glass border-b border-white/8 px-6 py-3.5 flex items-center justify-between sticky top-0 z-30">

        {{-- Left : breadcrumb --}}
        <div class="flex items-center gap-2 text-sm">
            <span class="text-white/30">TaskManager</span>
            <span class="text-white/20">/</span>
            <span class="text-white font-medium">@yield('title', 'Dashboard')</span>
        </div>

        {{-- Right : actions --}}
        <div class="flex items-center gap-3">

       
            {{-- Notifications --}}
            <button class="relative w-9 h-9 rounded-xl glass hover-glass flex items-center justify-center
                           transition-all duration-200 hover:border-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="notif-badge"></span>
            </button>

            {{-- User pill --}}
            <div class="glass-pink rounded-xl px-3 py-2 flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-[#FF0B55] flex items-center justify-center text-xs font-bold glow-pink-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="text-sm font-semibold text-white hidden sm:block">
                    {{ auth()->user()->name ?? 'Utilisateur' }}
                </span>
            </div>

        </div>
    </header>

    {{-- ── CONTENT ── --}}
    <main class="flex-1 overflow-auto p-6 space-y-5">

        {{-- Flash success --}}
        @if(session('success'))
            <div class="animate-fade-down flex items-center gap-3 px-4 py-3 rounded-xl
                        bg-emerald-500/15 border border-emerald-500/25 text-emerald-300 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Flash error --}}
        @if($errors->any())
            <div class="animate-fade-down flex items-start gap-3 px-4 py-3 rounded-xl
                        bg-red-500/15 border border-red-500/25 text-red-300 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-red-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul class="space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Page content --}}
        @yield('content')

    </main>
</div>

{{-- ════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════ --}}
<script>
    // ── Sidebar toggle ──────────────────────────────
    const sidebar    = document.getElementById('sidebar');
    const toggleBtn  = document.getElementById('toggleSidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    let collapsed    = false;

    toggleBtn.addEventListener('click', () => {
        collapsed = !collapsed;
        sidebar.classList.toggle('collapsed', collapsed);
        toggleIcon.style.transform = collapsed ? 'rotate(180deg)' : 'rotate(0deg)';
    });

    // ── Auto-close alerts ──────────────────────────
    document.querySelectorAll('.animate-fade-down').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity    = '0';
            setTimeout(() => el.remove(), 500);
        }, 4000);
    });
</script>

@stack('scripts')

</body>
</html>