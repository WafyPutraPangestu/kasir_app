{{-- 
    x-data diperbarui dengan state 'managementDropdownOpen'
    untuk mengontrol dropdown menu Manajemen.
--}}
<nav x-data="{ open: false, dropdownOpen: false, managementDropdownOpen: false }" class="bg-gray-800">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">

          <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
              <button @click="open = !open" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                  <span class="sr-only">Open main menu</span>
                  <svg :class="{ 'hidden': open, 'block': !open }" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                  <svg :class="{ 'block': open, 'hidden': !open }" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
          </div>

          <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
              <div class="flex flex-shrink-0 items-center">
                  <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
              </div>
              <div class="hidden sm:ml-6 sm:block">
                  <div class="flex space-x-4">
                      <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>

                      </div>
              </div>
          </div>

          <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
              @guest
                  <x-nav-link href="{{ route('login') }}" :active="request()->is('login')">Login</x-nav-link>
              @endguest

              @auth
                  <div class="hidden sm:flex sm:items-center sm:space-x-4">
                      <div class="relative">
                          <button @click="managementDropdownOpen = !managementDropdownOpen" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition">
                              Manajemen
                          </button>
                          <div x-show="managementDropdownOpen"
                               @click.away="managementDropdownOpen = false"
                               x-transition
                               class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                               style="display: none;">
                              <a href="{{ route('admin.tables.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manajemen Meja</a>
                              <a href="{{ route('admin.produk.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manajemen Produk</a>
                              <a href="{{ route('admin.category.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manajemen Kategori</a>
                          </div>
                      </div>

                      <div class="relative ml-3">
                          <button @click="dropdownOpen = !dropdownOpen" type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                              <span class="sr-only">Open user menu</span>
                              <span class="text-white px-3">{{ auth()->user()->name }}</span>
                          </button>
                          <div x-show="dropdownOpen"
                               @click.away="dropdownOpen = false"
                               x-transition
                               class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                               style="display: none;">
                              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Anda</a>
                              <form action="{{ route('logout') }}" method="POST">
                                  @csrf
                                  <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                              </form>
                          </div>
                      </div>
                  </div>
              @endauth
          </div>

      </div>
  </div>

  <div x-show="open" class="sm:hidden" id="mobile-menu" style="display: none;">
      <div class="space-y-1 px-2 pb-3 pt-2">
          <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
          @auth
              <h3 class="px-3 pt-4 pb-2 text-xs font-semibold uppercase text-gray-400">Manajemen</h3>
              <x-nav-link href="{{ route('admin.tables.index') }}" :active="request()->is('admin/tables.index*')">Manajemen Meja</x-nav-link>
              <x-nav-link href="{{ route('admin.produk.index') }}" :active="request()->is('admin/produk*')">Manajemen Produk</x-nav-link>
              <x-nav-link href="{{ route('admin.category.index') }}" :active="request()->is('admin/category*')">Manajemen Kategori</x-nav-link>

              <a href="{{ route('cart.index') }}" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white">
                <span class="sr-only">Lihat Keranjang</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.328 1.09-.824l1.102-4.411a1.125 1.125 0 00-1.09-1.328H7.21l-.228-1.141A2.25 2.25 0 004.783 5H3" /></svg>
                
                {{-- Badge ini sekarang dikontrol oleh Alpine.js --}}
                <template x-if="cartCount > 0">
                    <span x-text="cartCount" class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white"></span>
                </template>
            </a>

              <div class="border-t border-gray-700 mt-4 pt-4">
                  <div class="flex items-center px-3">
                      <div class="text-base font-medium leading-none text-white">{{ auth()->user()->name }}</div>
                  </div>
                  <div class="mt-3 space-y-1">
                      <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Profil Anda</a>
                      <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit" class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Logout</button>
                      </form>
                  </div>
              </div>
          @endauth

          @guest
              <x-nav-link href="{{ route('login') }}" :active="request()->is('login')">Login</x-nav-link>
          @endguest
      </div>
  </div>
</nav>