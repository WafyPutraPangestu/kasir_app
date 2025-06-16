<!-- Navigation Component -->
<nav class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50" x-data="{ mobileMenuOpen: false, profileDropdown: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="bg-green-600 rounded-lg p-2">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h1 class="text-xl font-bold text-gray-900">MyApp</h1>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    
                    @guest
                        <!-- Guest Navigation -->
                        <x-nav-link 
                            :href="route('home')" 
                            :active="request()->routeIs('home')"
                            class="text-gray-700 hover:text-green-600 hover:bg-green-50 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Home
                        </x-nav-link>
                        
                        <x-nav-link 
                            :href="route('login')" 
                            :active="request()->routeIs('login')"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Login
                        </x-nav-link>
                    @endguest

                    @can('admin')
                    <!-- Admin Navigation -->
                    <x-nav-link 
                        :href="route('admin.dashboard.index')" 
                        :active="request()->routeIs('admin.dashboard.*')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Dashboard</span>
                    </x-nav-link>
                
                    <x-nav-link 
                        :href="route('admin.category.index')" 
                        :active="request()->routeIs('admin.category.*')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span>Category</span>
                    </x-nav-link>
                
                    <x-nav-link 
                        :href="route('admin.produk.index')" 
                        :active="request()->routeIs('admin.produk.*')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span>Products</span>
                    </x-nav-link>
                
                    <x-nav-link 
                        :href="route('admin.orders.index')" 
                        :active="request()->routeIs('admin.orders.*')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Orders</span>
                    </x-nav-link>
                
                    <x-nav-link 
                        :href="route('admin.tables.index')" 
                        :active="request()->routeIs('admin.tables.*')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span>Tables</span>
                    </x-nav-link>
                @endcan
                </div>
            </div>

            <!-- Profile Dropdown / Auth -->
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    
                    @auth
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" id="user-menu-button">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="ml-2 text-gray-700 text-sm font-medium">{{ auth()->user()->name }}</span>
                                    <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
            
            @guest
                <x-nav-link 
                    :href="route('login')" 
                    :active="request()->routeIs('login')"
                    class="text-gray-700 hover:text-green-600 hover:bg-green-50 block px-3 py-2 rounded-md text-base font-medium">
                    Login
                </x-nav-link>
            @endguest

            @can('admin')
                <!-- Admin Mobile Navigation -->
                <x-nav-link 
                    :href="route('admin.dashboard.index')" 
                    :active="request()->routeIs('admin.dashboard.*')"
                    class="text-gray-700 hover:text-green-600 hover:bg-green-50 block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 Labels24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </x-nav-link>

                <x-nav-link 
                    :href="route('admin.category.index')" 
                    :active="request()->routeIs('admin.category.*')"
                    class="text-gray-700 hover:text-green-600 hover:bg-green-50 block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Category</span>
                </x-nav-link>

                <x-nav-link 
                    :href="route('admin.produk.index')" 
                    :active="request()->routeIs('admin.produk.*')"
                    class="text-gray-700 hover:text-green-600 hover:bg-green-50 block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Products</span>
                </x-nav-link>

                <x-nav-link 
                    :href="route('admin.orders.index')" 
                    :active="request()->routeIs('admin.orders.*')"
                    class="text-gray-700 hover:text-green-600 hover:bg-green-50 block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Orders</span>
                </x-nav-link>
            @endcan

            @guest
                <!-- User Mobile Navigation -->
                <x-nav-link 
                    :href="route('home')" 
                    :active="request()->routeIs('home')"
                    class="text-gray-700 hover:text-green-600 hover:bg-green-50 block px-3 py-2 rounded-md text-base font-medium">
                    Home
                </x-nav-link>
                
              
            @endguest

            @auth
                <!-- Mobile Profile Section -->
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-green-600 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-gray-500 hover:bg-gray-50">Profile</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-gray-500 hover:bg-gray-50">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-gray-500 hover:bg-gray-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>