<nav class="bg-white shadow-sm" x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }">
    <div class="  px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            
            <div class="flex-1 flex justify-start">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3">
                            <div class="bg-green-600 rounded-lg p-2 flex items-center justify-center">
                                
                                <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c.251.023.501.05.75.082a12.023 12.023 0 018.25 3.188m-8.25-3.188c-1.28.32-2.486.84-3.5 1.534m-3.5-1.534a12.016 12.016 0 016.25-1.815M3.75 5.625c.348-.19.71-.355 1.086-.492M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5.25 5.25l-2.437-2.438" />
                                </svg>
                            </div>
                            <h1 class="text-xl font-bold text-gray-800">Coffe<span class="font-semibold text-green-600">shop</span></h1>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="hidden md:flex justify-center">
                <div class="flex items-baseline space-x-6">
                    @guest
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-green-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} transition-colors duration-200">
                            Home
                        </a>
                    @endguest

                    @can('admin')
                        @php
                            $baseLinkClasses = 'flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200';
                            $activeLinkClasses = 'bg-green-100 text-green-700 font-semibold';
                            $inactiveLinkClasses = 'text-gray-500 hover:bg-gray-100 hover:text-gray-700';
                        @endphp

                        <a href="{{ route('admin.dashboard.index') }}" class="{{ $baseLinkClasses }} {{ request()->routeIs('admin.dashboard.*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.category.index') }}" class="{{ $baseLinkClasses }} {{ request()->routeIs('admin.category.*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            <span>Category</span>
                        </a>
                        <a href="{{ route('admin.produk.index') }}" class="{{ $baseLinkClasses }} {{ request()->routeIs('admin.produk.*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span>Products</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="{{ $baseLinkClasses }} {{ request()->routeIs('admin.orders.*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Orders</span>
                        </a>
                        <a href="{{ route('admin.tables.index') }}" class="{{ $baseLinkClasses }} {{ request()->routeIs('admin.tables.*') ? $activeLinkClasses : $inactiveLinkClasses }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span>Tables</span>
                        </a>
                    @endcan
                </div>
            </div>

            
            <div class="flex-1 flex justify-end items-center">
                
                <div class="hidden md:flex items-center">
                    @guest
                        <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Login
                        </a>
                    @endguest
                    @auth
                        
                        <div class="ml-3 relative">
                            <div>
                                <button @click="profileDropdownOpen = !profileDropdownOpen" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="hidden sm:block ml-2 text-gray-700 text-sm font-medium">{{ auth()->user()->name }}</span>
                                    <svg class="hidden sm:block ml-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="profileDropdownOpen"
                                 @click.away="profileDropdownOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                 role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
                
                <div class="-mr-2 flex md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" style="display: none;" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
             @can('admin')
                <x-nav-link-mobile :href="route('admin.dashboard.index')" :active="request()->routeIs('admin.dashboard.*')">Dashboard</x-nav-link-mobile>
                <x-nav-link-mobile :href="route('admin.category.index')" :active="request()->routeIs('admin.category.*')">Category</x-nav-link-mobile>
                <x-nav-link-mobile :href="route('admin.produk.index')" :active="request()->routeIs('admin.produk.*')">Products</x-nav-link-mobile>
                <x-nav-link-mobile :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">Orders</x-nav-link-mobile>
                <x-nav-link-mobile :href="route('admin.tables.index')" :active="request()->routeIs('admin.tables.*')">Tables</x-nav-link-mobile>
             @else
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">Home</a>
             @endcan         </div>
        
        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-green-600 flex items-center justify-center">
                            <span class="text-base font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('login') }}" class="block w-full text-left bg-green-600 text-white px-3 py-2 rounded-md text-base font-medium text-center">Login</a>
            </div>
        @endauth
    </div>
</nav>
