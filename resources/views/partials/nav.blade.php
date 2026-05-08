<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-shield-alt text-blue-600 mr-2"></i>PDPA System
                </h1>
            </div>

            <div class="flex items-center space-x-6">
                @auth
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : '' }}">
                            <i class="fas fa-chart-line mr-2"></i>Dashboard
                        </a>
                        
                        @if(auth()->user()->can('viewAny', App\Models\DataSubjectRecord::class))
                            <a href="{{ route('records.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('records.*') ? 'text-blue-600 font-semibold' : '' }}">
                                <i class="fas fa-database mr-2"></i>Records
                            </a>
                            <a href="{{ route('data-subject-requests.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('data-subject-requests.*') ? 'text-blue-600 font-semibold' : '' }}">
                                <i class="fas fa-file-alt mr-2"></i>Requests
                            </a>
                        @endif

                        @if(auth()->user()->can('viewAny', App\Models\AuditLog::class))
                            <a href="{{ route('audit-logs.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('audit-logs.*') ? 'text-blue-600 font-semibold' : '' }}">
                                <i class="fas fa-history mr-2"></i>Audit Logs
                            </a>
                        @endif

                        <a href="{{ route('privacy-notice') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-lock mr-2"></i>Privacy
                        </a>
                    </div>

                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ auth()->user()->role === 'admin' ? 'bg-red-100 text-red-800' : (auth()->user()->role === 'staff' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
