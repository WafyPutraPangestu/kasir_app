<x-guest.layout cartCount="{{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() }}">
    <div class="bg-slate-50 min-h-screen" x-data="cartApp()" x-init="fetchCart();
    initCategoryNav();">

        <div class="flex">
            <aside
                class="hidden lg:flex lg:flex-col fixed top-0 left-0 h-full bg-gradient-to-b from-slate-100 to-green-50 border-r border-slate-200 z-20 transition-all duration-300 ease-in-out"
                :class="isSidebarOpen ? 'w-64 xl:w-72 p-6' : 'w-0 p-0 border-none'">
                <header class="text-left mb-8 flex-shrink-0 whitespace-nowrap overflow-hidden"
                    :class="isSidebarOpen ? 'opacity-100' : 'opacity-0'" style="transition-delay: 150ms;">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-800">Menu Pilihan Kami</h1>
                    <p class="mt-2 text-sm text-slate-600">
                        Pesanan untuk <span class="font-bold text-green-600">Meja {{ $table->name }}</span>
                    </p>
                </header>
                <nav class="space-y-1 flex-grow overflow-y-auto whitespace-nowrap"
                    :class="isSidebarOpen ? 'opacity-100' : 'opacity-0'" style="transition-delay: 150ms;">
                    @foreach ($categories as $category)
                        @if ($category->products->isNotEmpty())
                            <a :href="'#category-{{ $category->id }}'"
                                @click.prevent="document.getElementById('category-{{ $category->id }}').scrollIntoView({ behavior: 'smooth', block: 'start' })"
                                :class="{
                                    'bg-green-200 text-green-800 font-bold': activeCategory ===
                                        {{ $category->id }},
                                    'text-slate-700 hover:text-green-800 hover:bg-green-100': activeCategory !==
                                        {{ $category->id }}
                                }"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200">
                                <span class="truncate" x-text="'{{ $category->name }}'"></span>
                            </a>
                        @endif
                    @endforeach
                </nav>
                <div class="hidden lg:block absolute top-1/2 -translate-y-1/2 z-30 transition-all duration-300 ease-in-out"
                    :class="isSidebarOpen ? 'right-[-1rem]' : 'left-full ml-4'">
                    <button @click="isSidebarOpen = !isSidebarOpen"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm text-slate-600 hover:bg-white shadow-md transition border border-slate-200">
                        <svg x-show="isSidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg x-show="!isSidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </aside>

            <div class="w-full transition-all duration-300 ease-in-out"
                :class="isSidebarOpen ? 'lg:pl-64 xl:pl-72' : 'lg:pl-0'">
                <header class="lg:hidden w-full mb-6 bg-gradient-to-r from-slate-100 to-green-100 shadow-md">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center">
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Menu</h1>
                        <p class="mt-1 text-sm text-slate-600">
                            Pesanan untuk <span class="font-bold text-green-600">Meja {{ $table->name }}</span>
                        </p>
                    </div>
                </header>

                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <main class="w-full py-6">
                        @forelse ($categories as $category)
                            @if ($category->products->isNotEmpty())
                                <section :id="'category-{{ $category->id }}'" class="scroll-mt-24 mb-16">
                                    <h2 class="text-3xl font-bold text-slate-800 mb-6 border-b-2 border-green-500 pb-2">
                                        {{ $category->name }}</h2>
                                    <div class="grid grid-cols-2 gap-4 sm:gap-6"
                                        :class="isSidebarOpen ? 'md:grid-cols-2 lg:grid-cols-3' :
                                            'md:grid-cols-2 lg:grid-cols-4'">
                                        @foreach ($category->products as $product)
                                            <div class="group relative bg-white rounded-2xl shadow-md overflow-hidden border border-slate-200 transition-all duration-300 ease-out hover:shadow-xl hover:-translate-y-1.5 flex flex-col"
                                                :class="isPageLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                                                style="transition-delay: {{ ($loop->parent->index * count($category->products) + $loop->index) * 50 }}ms">
                                                <div class="w-full h-32 sm:h-48 bg-slate-200 overflow-hidden">
                                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300/e2e8f0/64748b?text=Menu' }}"
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                                                </div>
                                                <div class="p-3 sm:p-5 flex flex-col flex-grow">
                                                    <div class="flex-grow mb-3">
                                                        <h3
                                                            class="text-md sm:text-lg font-semibold text-slate-800 mb-1 line-clamp-2">
                                                            {{ $product->name }}
                                                        </h3>
                                                        <p class="hidden sm:block text-sm text-slate-600 line-clamp-2">
                                                            {{ $product->description ?? 'Deskripsi tidak tersedia.' }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-auto">
                                                        <p
                                                            class="text-lg sm:text-xl font-bold text-green-600 mb-2 sm:mb-0">
                                                            {{ 'Rp ' . number_format($product->price, 0, ',', '.') }}
                                                        </p>
                                                        <button @click="addToCart({{ $product->id }})"
                                                            class="w-full sm:w-auto inline-flex items-center justify-center bg-green-500 text-white px-3 py-2 sm:px-4 rounded-lg font-semibold shadow-sm hover:bg-green-600 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:bg-slate-300 disabled:cursor-not-allowed disabled:transform-none"
                                                            :disabled="!
                                                            {{ $product->is_available && $product->is_active ? 'true' : 'false' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 sm:mr-2" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                                            </svg>
                                                            <span class="hidden sm:inline">Tambah</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        @empty
                            <div
                                class="py-16 text-center text-slate-500 bg-white/50 rounded-lg border border-slate-200">
                                <p>Menu belum tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </main>
                </div>
            </div>
        </div>

        <div class="hidden lg:block">
            <div class="fixed top-6 right-6 z-40">
                <button @click="isCartOpen = true"
                    class="relative w-12 h-12 flex items-center justify-center rounded-full bg-white text-slate-700 shadow-lg hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span x-show="cartCount > 0" x-transition
                        class="absolute -top-1 -right-1 w-5 h-5 flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full"
                        x-text="cartCount"></span>
                </button>
            </div>

            <div x-show="isCartOpen" class="fixed inset-0 bg-black bg-opacity-40 z-40" @click="isCartOpen = false"
                x-cloak></div>

            <aside x-show="isCartOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 flex flex-col" x-cloak>
                <div class="p-5 border-b border-slate-200 flex-shrink-0 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-slate-900">Keranjang Anda</h2>
                    <button @click="isCartOpen = false"
                        class="p-2 rounded-full text-slate-400 hover:bg-slate-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="desktop-cart-content" class="flex-grow overflow-y-auto"></div>
            </aside>
        </div>

        <div class="lg:hidden">
            <div x-show="cartCount > 0" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-y-24" x-transition:enter-end="translate-y-0"
                class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-sm border-t border-slate-200 p-3 z-40 shadow-t-xl">
                <button @click="isCartOpen = true"
                    class="w-full bg-green-500 text-white py-3 px-4 rounded-xl font-semibold flex justify-between items-center shadow-lg hover:bg-green-600 transition-colors">
                    <span>
                        <span x-text="cartCount"></span> Item di Keranjang
                    </span>
                    <span x-text="formatCurrency(subtotal)"></span>
                </button>
            </div>

            <div x-show="isCartOpen" class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-end"
                @click.away="isCartOpen = false" x-cloak>
                <div x-show="isCartOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0"
                    x-transition:leave-end="translate-y-full"
                    class="bg-slate-50 w-full rounded-t-2xl shadow-xl max-h-[85vh] flex flex-col">
                    <div class="p-4 border-b border-slate-200 flex justify-between items-center flex-shrink-0">
                        <h2 class="text-xl font-bold text-slate-900">Keranjang Anda</h2>
                        <button @click="isCartOpen = false"
                            class="p-2 rounded-full text-slate-400 hover:bg-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="mobile-cart-content" class="overflow-y-auto"></div>
                </div>
            </div>
        </div>

        <div x-show="notification.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-2 opacity-0"
            class="fixed bottom-5 right-5 w-full max-w-xs p-4 text-white rounded-lg shadow-lg"
            :class="{
                'bg-gradient-to-r from-teal-500 to-green-500': notification
                    .type === 'success',
                'bg-gradient-to-r from-red-500 to-green-500': notification
                    .type === 'error'
            }"
            x-cloak>
            <div class="flex items-center">
                <span class="font-medium" x-text="notification.message"></span>
            </div>
        </div>
    </div>

    <template id="cart-content-template">
        <div class="flex-grow flex flex-col h-full">
            <div class="p-5 flex-grow" :class="cartItems.length > 0 ? 'overflow-y-auto' : ''">
                <ul class="divide-y divide-slate-200" x-show="cartItems.length > 0">
                    <template x-for="item in cartItems" :key="item.rowId">
                        <li class="flex py-4">
                            <div class="flex-shrink-0 w-16 h-16 bg-slate-200 rounded-md overflow-hidden">
                                <img :src="(item.options && item.options.image) ? '/storage/' + item.options.image:
                                    'https://placehold.co/100x100/e2e8f0/64748b?text=Menu'"
                                    :alt="item.name" class="w-full h-full object-cover">
                            </div>
                            <div class="ml-4 flex-1 flex flex-col">
                                <div class="flex justify-between text-base font-medium text-slate-900">
                                    <h3 class="pr-2" x-text="item.name"></h3>
                                    <p class="ml-4 flex-shrink-0" x-text="formatCurrency(item.price * item.qty)"></p>
                                </div>
                                <div class="flex-1 flex items-end justify-between text-sm">
                                    <div class="flex items-center mt-2">
                                        <button @click="updateQuantity(item, item.qty - 1)"
                                            class="text-slate-500 hover:text-green-600 p-1 rounded-full hover:bg-slate-100 transition-colors"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg></button>
                                        <span class="mx-2 w-8 text-center font-medium text-slate-700"
                                            x-text="item.qty"></span>
                                        <button @click="updateQuantity(item, item.qty + 1)"
                                            class="text-slate-500 hover:text-green-600 p-1 rounded-full hover:bg-slate-100 transition-colors"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                    clip-rule="evenodd" />
                                            </svg></button>
                                    </div>
                                    <div class="flex">
                                        <button @click="removeItem(item)" type="button"
                                            class="font-medium text-red-600 hover:text-red-500 p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>

                <div class="p-12 text-center" x-show="cartItems.length === 0" x-cloak>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-slate-900">Keranjang masih kosong</h3>
                    <p class="mt-1 text-sm text-slate-500">Silakan pilih menu yang Anda suka.</p>
                </div>
            </div>

            <div class="p-5 border-t border-slate-200 flex-shrink-0" x-show="cartItems.length > 0" x-cloak>
                <div class="flex justify-between text-base font-medium text-slate-900">
                    <p>Subtotal</p>
                    <p x-text="formatCurrency(subtotal)"></p>
                </div>
                <p class="mt-1 text-sm text-slate-500">Sudah termasuk pajak dan layanan.</p>
                <div class="mt-6">
                    <button @click="submitOrder()"
                        class="w-full flex items-center justify-center rounded-md border border-transparent bg-green-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-600 transition-colors">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </template>

    <script>
        function cartApp() {
            return {
                cartItems: [],
                subtotal: 0,
                cartCount: 0,
                isCartOpen: false,
                activeCategory: null,
                isPageLoaded: false,
                notification: {
                    show: false,
                    message: '',
                    type: 'success'
                },
                isSidebarOpen: true, // State untuk sidebar desktop

                initCategoryNav() {
                    const observer = new IntersectionObserver(entries => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.activeCategory = parseInt(entry.target.id.split('-')[1]);
                            }
                        });
                    }, {
                        rootMargin: "-20% 0px -80% 0px",
                        threshold: 0
                    });

                    document.querySelectorAll('main section').forEach(section => {
                        observer.observe(section);
                    });

                    const firstCategory = document.querySelector('main section');
                    if (firstCategory) {
                        this.activeCategory = parseInt(firstCategory.id.split('-')[1]);
                    }
                },

                renderCartContent() {
                    const template = document.getElementById('cart-content-template').innerHTML;
                    document.getElementById('desktop-cart-content').innerHTML = template;
                    document.getElementById('mobile-cart-content').innerHTML = template;
                },

                formatCurrency(amount) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
                },

                fetchCart() {
                    fetch('{{ route('api.cart.data') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.cartItems = data.cart.items;
                                this.subtotal = data.cart.subtotal;
                                this.cartCount = data.cart.totalQty;
                                this.renderCartContent();
                                this.$nextTick(() => {
                                    setTimeout(() => {
                                        this.isPageLoaded = true;
                                    }, 50);
                                });
                            }
                        });
                },

                updateCartState(data) {
                    if (data.success) {
                        this.cartItems = data.cart.items;
                        this.subtotal = data.cart.subtotal;
                        this.cartCount = data.cart.totalQty;
                        this.showNotification(data.message);
                        if (this.cartCount === 0) {
                            this.isCartOpen = false;
                        }
                    }
                },

                addToCart(productId) {
                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                product_id: productId,
                                qty: 1
                            })
                        })
                        .then(response => response.json())
                        .then(data => this.updateCartState(data));
                },

                updateQuantity(item, newQty) {
                    if (newQty < 1) {
                        this.removeItem(item);
                        return;
                    }
                    fetch('{{ route('cart.update') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                rowId: item.rowId,
                                qty: newQty
                            })
                        })
                        .then(response => response.json())
                        .then(data => this.updateCartState(data));
                },

                removeItem(item) {
                    fetch('{{ route('cart.remove') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                rowId: item.rowId
                            })
                        })
                        .then(response => response.json())
                        .then(data => this.updateCartState(data));
                },

                submitOrder() {
                    fetch('{{ route('orders.store') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect;
                            } else {
                                this.showNotification(data.message || 'Gagal membuat pesanan', 'error');
                            }
                        })
                        .catch(error => {
                            this.showNotification('Terjadi kesalahan: ' + error.message, 'error');
                        });
                },

                showNotification(message, type = 'success') {
                    this.notification.message = message;
                    this.notification.type = type;
                    this.notification.show = true;

                    setTimeout(() => {
                        this.notification.show = false;
                    }, 3000);
                }
            }
        }
    </script>
</x-guest.layout>
