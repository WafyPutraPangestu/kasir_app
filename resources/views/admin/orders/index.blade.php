<x-layout>
    <header class="px-8 py-8 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 rounded-xl sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 transition-all duration-300">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Dasbor Pesanan</h1>
        <p class="text-white mt-1">Manajemen pesanan aktif dan riwayat transaksi.</p>
    </header>
    
    <div x-data="orderDashboard" x-cloak class="p-4 sm:p-6 lg:p-8 font-sans">
        <!-- Statistics Section -->
        <div class="mb-8 px-6 py-6 rounded-2xl">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Statistik Pesanan</h1>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-500 flex flex-col gap-4 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="bg-blue-100 p-3 rounded-full w-14 h-14 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pesanan (Hari Ini)</p>
                        <p class="text-2xl font-bold text-gray-800" x-text="todayStats.total_orders"></p>
                    </div>
                </div>
                <div class="bg-white p-6 border border-gray-500 rounded-xl flex flex-col gap-4 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="bg-green-100 p-3 rounded-full w-14 h-14 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 11.218 12 10.5 12 10.5s-1.536-.718-2.621-1.818c-1.172-.879-1.172-2.303 0-3.182C10.536 4.621 12 5.25 12 5.25s1.536.718 2.621 1.818l.879.659M7 12h10"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-800" x-text="formatCurrency(todayStats.total_revenue)"></p>
                    </div>
                </div>
                <div class="bg-white p-6 border border-gray-500 rounded-xl flex flex-col gap-4 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="bg-indigo-100 p-3 rounded-full w-14 h-14 flex items-center justify-center">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pesanan Selesai</p>
                        <p class="text-2xl font-bold text-gray-800" x-text="todayStats.completed_orders"></p>
                    </div>
                </div>
                <div class="bg-white p-6 border border-gray-500 rounded-xl flex flex-col gap-4 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="bg-yellow-100 p-3 rounded-full w-14 h-14 flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pesanan Pending</p>
                        <p class="text-2xl font-bold text-gray-800" x-text="todayStats.pending_orders"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="rounded-xl">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-6 px-6" aria-label="Tabs">
                    <button @click="switchTab('active')" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'active', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'active' }" class="relative whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none">
                        Pesanan Aktif
                        <span x-show="newOrdersCount > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center" x-text="newOrdersCount"></span>
                    </button>
                    <button @click="switchTab('history')" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'history', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'history' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none">
                        Riwayat Pesanan
                    </button>
                </nav>
            </div>

            <div class="p-6 min-h-[400px]">
                <!-- Active Orders Tab -->
                <div x-show="activeTab === 'active'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="flex flex-col space-y-4">
                        <template x-for="order in activeOrders" :key="order.id">
                            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="w-full md:w-48 flex-shrink-0 mb-4 md:mb-0 md:pr-4">
                                    <p class="font-bold text-gray-800">Pesanan #<span x-text="order.id"></span></p>
                                    <p class="text-sm text-gray-500">Meja: <span class="font-medium" x-text="order.table.name"></span></p>
                                </div>
                                <div class="flex-1 min-w-0 mb-4 md:mb-0 md:px-4 md:border-l md:border-r border-gray-200">
                                    <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-thin">
                                        <template x-for="item in order.items" :key="item.id">
                                            <div class="flex-shrink-0 bg-gray-50 text-sm text-gray-700 rounded-full px-3 py-1 whitespace-nowrap">
                                                <span class="font-semibold text-indigo-600" x-text="item.quantity + 'x'"></span>
                                                <span x-text="item.product.name"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="w-full md:w-64 flex-shrink-0 md:pl-4 flex items-center justify-between">
                                    <div class="text-left">
                                        <span :class="getStatusClass(order.status)" class="text-xs font-semibold px-2.5 py-1 rounded-full" x-text="order.status.charAt(0).toUpperCase() + order.status.slice(1)"></span>
                                        <p class="text-lg font-bold text-indigo-600 mt-1" x-text="formatCurrency(order.total_amount)"></p>
                                    </div>
                                    <div class="flex items-center">
                                        <button @click="showOrderDetails(order.id)" class="text-gray-400 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                                            <span class="sr-only">Lihat Detail</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <div class="relative inline-block text-left">
                                            <button @click="toggleActionMenu(order.id)" type="button" class="text-gray-400 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                                                <span class="sr-only">Opsi</span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                </svg>
                                            </button>
                                            <div x-show="actionMenuOpenFor === order.id" @click.away="closeActionMenu()" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                <div class="py-1">
                                                    <template x-if="order.status === 'pending'">
                                                        <a href="#" @click.prevent="updateStatus(order.id, 'paid')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tandai Bayar</a>
                                                    </template>
                                                    <template x-if="order.status === 'paid'">
                                                        <a href="#" @click.prevent="updateStatus(order.id, 'preparing')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Proses Pesanan</a>
                                                    </template>
                                                    <template x-if="['paid', 'preparing'].includes(order.status)">
                                                        <a href="#" @click.prevent="updateStatus(order.id, 'completed')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Selesaikan</a>
                                                    </template>
                                                    <template x-if="!['completed', 'cancelled'].includes(order.status)">
                                                        <div class="border-t border-gray-100 my-1"></div>
                                                        <a href="#" @click.prevent="updateStatus(order.id, 'cancelled')" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Batalkan</a>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="activeOrders.length === 0" class="col-span-full text-center py-16 text-gray-500 flex flex-col items-center justify-center">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-full p-6 mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan aktif</h3>
                            <p class="text-sm text-gray-500">Semua pesanan yang masuk sudah selesai.</p>
                        </div>
                    </div>

                    <!-- Pagination for Active Orders -->
                    <div x-show="activePagination.last_page > 1" class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button @click="changeActivePage(activePagination.current_page - 1)" :disabled="activePagination.current_page === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                Sebelumnya
                            </button>
                            <button @click="changeActivePage(activePagination.current_page + 1)" :disabled="activePagination.current_page === activePagination.last_page" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                Selanjutnya
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Menampilkan <span class="font-medium" x-text="activePagination.from"></span> sampai <span class="font-medium" x-text="activePagination.to"></span> dari <span class="font-medium" x-text="activePagination.total"></span> pesanan
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                    <button @click="changeActivePage(activePagination.current_page - 1)" :disabled="activePagination.current_page === 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <template x-for="page in getPageNumbers(activePagination.current_page, activePagination.last_page)" :key="page">
                                        <button @click="page !== '...' && changeActivePage(page)" :class="{'bg-indigo-50 border-indigo-500 text-indigo-600 z-10': page === activePagination.current_page, 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': page !== activePagination.current_page}" :disabled="page === '...'" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium" x-text="page">
                                        </button>
                                    </template>
                                    <button @click="changeActivePage(activePagination.current_page + 1)" :disabled="activePagination.current_page === activePagination.last_page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- History Orders Tab -->
                <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <!-- Filter Section -->
                    <div class="mb-6 p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                            <div class="flex-shrink-0">
                                <label class="text-sm font-medium text-gray-700 mb-2 block">Pilih Cepat</label>
                                <div class="flex items-center rounded-lg p-1 space-x-1">
                                    <button @click="setFilterRange('today')" :class="{ 'bg-indigo-600 text-white shadow': activePreset === 'today', 'hover:bg-gray-200 text-gray-600': activePreset !== 'today' }" class="px-3 py-1.5 text-sm font-medium rounded-md transition-all">Hari Ini</button>
                                    <button @click="setFilterRange('last7days')" :class="{ 'bg-indigo-600 text-white shadow': activePreset === 'last7days', 'hover:bg-gray-200 text-gray-600': activePreset !== 'last7days' }" class="px-3 py-1.5 text-sm font-medium rounded-md transition-all">7 Hari Terakhir</button>
                                    <button @click="setFilterRange('thismonth')" :class="{ 'bg-indigo-600 text-white shadow': activePreset === 'thismonth', 'hover:bg-gray-200 text-gray-600': activePreset !== 'thismonth' }" class="px-3 py-1.5 text-sm font-medium rounded-md transition-all">Bulan Ini</button>
                                </div>
                            </div>

                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="startDate" class="text-sm font-medium text-gray-700 mb-2 block">Dari Tanggal</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <input x-ref="startDate" type="text" id="startDate" class="w-full pl-10 pr-3 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                                <div>
                                    <label for="endDate" class="text-sm font-medium text-gray-700 mb-2 block">Sampai Tanggal</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <input x-ref="endDate" type="text" id="endDate" class="w-full pl-10 pr-3 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <button @click="fetchOrderHistory" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-wait flex items-center justify-center space-x-2" :disabled="isLoading.history">
                                    <span x-show="!isLoading.history" class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                        </svg>
                                        <span>Filter</span>
                                    </span>
                                    <span x-show="isLoading.history" class="flex items-center space-x-2">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Memuat...</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- History Table -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Meja</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <template x-if="isLoading.history">
                                        <template x-for="i in 5">
                                            <tr>
                                                <td class="px-6 py-4" colspan="5">
                                                    <div class="animate-pulse flex space-x-4">
                                                        <div class="rounded-full bg-gray-200 h-4 w-4"></div>
                                                        <div class="flex-1 space-y-2">
                                                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                                            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                    <template x-if="!isLoading.history">
                                        <template x-for="report in orderHistory" :key="report.id">
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="report.id"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="report.table.name"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="formatDateTime(report.created_at)"></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span :class="getStatusClass(report.status)" class="text-xs font-semibold px-3 py-1.5 rounded-full" x-text="report.status.charAt(0).toUpperCase() + report.status.slice(1)"></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-800" x-text="formatCurrency(report.total_amount)"></td>
                                            </tr>
                                        </template>
                                    </template>
                                    <tr x-show="!isLoading.history && orderHistory.length === 0">
                                        <td colspan="5" class="text-center py-16 text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-full p-4 mb-4">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6-4h6m2 5l-3-3 3-3m-5 14H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium">Tidak ada data riwayat</p>
                                                <p class="text-xs text-gray-400 mt-1">untuk rentang tanggal yang dipilih</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination for History -->
                        <div x-show="historyPagination.last_page > 1" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    <button @click="changeHistoryPage(historyPagination.current_page - 1)" :disabled="historyPagination.current_page === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Sebelumnya
                                    </button>
                                    <button @click="changeHistoryPage(historyPagination.current_page + 1)" :disabled="historyPagination.current_page === historyPagination.last_page" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Selanjutnya
                                    </button>
                                </div>
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Menampilkan <span class="font-medium" x-text="historyPagination.from"></span> sampai <span class="font-medium" x-text="historyPagination.to"></span> dari <span class="font-medium" x-text="historyPagination.total"></span> riwayat
                                        </p>
                                    </div>
                                    <div>
                                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                            <button @click="changeHistoryPage(historyPagination.current_page - 1)" :disabled="historyPagination.current_page === 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <template x-for="page in getPageNumbers(historyPagination.current_page, historyPagination.last_page)" :key="page">
                                                <button @click="page !== '...' && changeHistoryPage(page)" :class="{'bg-indigo-50 border-indigo-500 text-indigo-600': page === historyPagination.current_page, 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': page !== historyPagination.current_page}" :disabled="page === '...'" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium" x-text="page">
                                                </button>
                                            </template>
                                            <button @click="changeHistoryPage(historyPagination.current_page + 1)" :disabled="historyPagination.current_page === historyPagination.last_page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Pesanan -->
        <div x-show="modal.isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4 backdrop-blur-sm" @keydown.escape.window="closeModal()">
            <div @click.away="closeModal" x-show="modal.isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Detail Pesanan #<span x-text="modal.data?.id"></span></h3>
                        <button @click="closeModal" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <template x-if="isLoading.modal">
                            <div class="text-center py-12">
                                <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-gray-500 font-medium">Memuat data...</p>
                            </div>
                        </template>
                        <template x-if="!isLoading.modal && modal.data">
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Meja</p>
                                        <p class="font-semibold text-gray-800" x-text="modal.data.table.name"></p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                                        <p class="font-semibold text-gray-800" x-text="formatDateTime(modal.data.created_at)"></p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <p>
                                            <span :class="getStatusClass(modal.data.status)" class="text-xs font-semibold px-3 py-1.5 rounded-full" x-text="modal.data.status.charAt(0).toUpperCase() + modal.data.status.slice(1)"></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-4">
                                    <h4 class="font-semibold text-gray-800 mb-3">Rincian Item</h4>
                                    <div class="space-y-2 max-h-60 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                        <template x-for="item in modal.data.items" :key="item.id">
                                            <div class="flex justify-between items-center bg-white border rounded-lg p-3">
                                                <div>
                                                    <p class="font-medium text-gray-900" x-text="item.product.name"></p>
                                                    <p class="text-sm text-gray-500">
                                                        <span x-text="item.quantity"></span> x <span x-text="formatCurrency(item.price)"></span>
                                                    </p>
                                                </div>
                                                <p class="font-semibold text-gray-800" x-text="formatCurrency(item.price * item.quantity)"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-4 flex justify-between items-center bg-gray-50 rounded-lg p-4">
                                    <p class="text-lg font-bold text-gray-800">Total Keseluruhan</p>
                                    <p class="text-2xl font-bold text-indigo-600" x-text="formatCurrency(modal.data.total_amount)"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderDashboard', () => ({
                activeTab: 'active',
                activeOrders: [],
                orderHistory: [],
                todayStats: @json($todayStats),
                filter: {
                    startDate: @json($startDate),
                    endDate: @json($endDate)
                },
                activePagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 10,
                    total: 0,
                    from: 0,
                    to: 0
                },
                historyPagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 15,
                    total: 0,
                    from: 0,
                    to: 0
                },
                isLoading: {
                    history: false,
                    active: false,
                    modal: false
                },
                modal: {
                    isOpen: false,
                    data: null
                },
                newOrdersCount: 0,
                actionMenuOpenFor: null,
                activePreset: 'custom',
                fpStartDate: null,
                fpEndDate: null,

                init() {
                    // Initialize with first page data
                    this.activeOrders = @json($activeOrders->items());
                    this.orderHistory = @json($historyOrders->items());
                    
                    this.activePagination = {
                        current_page: {{ $activeOrders->currentPage() }},
                        last_page: {{ $activeOrders->lastPage() }},
                        per_page: {{ $activeOrders->perPage() }},
                        total: {{ $activeOrders->total() }},
                        from: {{ $activeOrders->firstItem() ?? 0 }},
                        to: {{ $activeOrders->lastItem() ?? 0 }}
                    };
                    
                    this.historyPagination = {
                        current_page: {{ $historyOrders->currentPage() }},
                        last_page: {{ $historyOrders->lastPage() }},
                        per_page: {{ $historyOrders->perPage() }},
                        total: {{ $historyOrders->total() }},
                        from: {{ $historyOrders->firstItem() ?? 0 }},
                        to: {{ $historyOrders->lastItem() ?? 0 }}
                    };

                    // Initialize Flatpickr
                    this.fpStartDate = flatpickr(this.$refs.startDate, {
                        defaultDate: this.filter.startDate,
                        dateFormat: "Y-m-d",
                        onChange: (d, str) => {
                            this.filter.startDate = str;
                            this.activePreset = 'custom';
                        }
                    });
                    this.fpEndDate = flatpickr(this.$refs.endDate, {
                        defaultDate: this.filter.endDate,
                        dateFormat: "Y-m-d",
                        onChange: (d, str) => {
                            this.filter.endDate = str;
                            this.activePreset = 'custom';
                        }
                    });

                    console.log('Order Dashboard dengan Paginasi Initialized');
                },

                switchTab(tab) {
                    this.activeTab = tab;
                },

                setFilterRange(preset) {
                    this.activePreset = preset;
                    const today = new Date();
                    let startDate, endDate = new Date();

                    switch (preset) {
                        case 'today':
                            startDate = new Date();
                            break;
                        case 'last7days':
                            startDate = new Date();
                            startDate.setDate(today.getDate() - 6);
                            break;
                        case 'thismonth':
                            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                            break;
                        default:
                            return;
                    }

                    const formatDate = (date) => date.toISOString().split('T')[0];

                    this.filter.startDate = formatDate(startDate);
                    this.filter.endDate = formatDate(endDate);

                    this.fpStartDate.setDate(this.filter.startDate, false);
                    this.fpEndDate.setDate(this.filter.endDate, false);

                    this.fetchOrderHistory();
                },

                getPageNumbers(current, last) {
                    const delta = 2;
                    const range = [];
                    const rangeWithDots = [];

                    for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
                        range.push(i);
                    }

                    if (current - delta > 2) {
                        rangeWithDots.push(1, '...');
                    } else {
                        rangeWithDots.push(1);
                    }

                    rangeWithDots.push(...range);

                    if (current + delta < last - 1) {
                        rangeWithDots.push('...', last);
                    } else if (last > 1) {
                        rangeWithDots.push(last);
                    }

                    return rangeWithDots;
                },

                async changeActivePage(page) {
                    if (page < 1 || page > this.activePagination.last_page || this.isLoading.active) return;
                    
                    this.isLoading.active = true;
                    try {
                        const response = await fetch(`{{ route('admin.orders.active') }}?page=${page}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            this.activeOrders = data.orders;
                            this.activePagination = data.pagination;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    } catch (error) {
                        this.showToast('Gagal memuat halaman', 'error');
                    } finally {
                        this.isLoading.active = false;
                    }
                },

                async changeHistoryPage(page) {
                    if (page < 1 || page > this.historyPagination.last_page || this.isLoading.history) return;
                    
                    this.isLoading.history = true;
                    try {
                        const params = new URLSearchParams({
                            start_date: this.filter.startDate,
                            end_date: this.filter.endDate,
                            page: page
                        });
                        
                        const response = await fetch(`{{ route('admin.orders.history') }}?${params}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            this.orderHistory = data.reports;
                            this.historyPagination = data.pagination;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    } catch (error) {
                        this.showToast('Gagal memuat halaman', 'error');
                    } finally {
                        this.isLoading.history = false;
                    }
                },

                async fetchOrderHistory() {
                    if (this.isLoading.history) return;
                    
                    this.isLoading.history = true;
                    try {
                        const params = new URLSearchParams({
                            start_date: this.filter.startDate,
                            end_date: this.filter.endDate,
                            page: 1
                        });
                        
                        const response = await fetch(`{{ route('admin.orders.history') }}?${params}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            this.orderHistory = data.reports;
                            this.historyPagination = data.pagination;
                            this.showToast('Riwayat berhasil diperbarui.', 'success');
                        } else {
                            throw new Error(data.message);
                        }
                    } catch (error) {
                        this.showToast(error.message || 'Gagal memuat riwayat', 'error');
                    } finally {
                        this.isLoading.history = false;
                    }
                },

                async fetchActiveOrders() {
                    try {
                        const response = await fetch(`{{ route('admin.orders.active') }}`);
                        const data = await response.json();
                        if (data.success) {
                            this.activeOrders = data.orders;
                            this.activePagination = data.pagination;
                        }
                    } catch (error) {
                        console.error('Fetch active orders error:', error);
                    }
                },

                async showOrderDetails(orderId) {
                    this.modal.isOpen = true;
                    this.isLoading.modal = true;
                    this.modal.data = { id: orderId };
                    
                    try {
                        const response = await fetch(`/admin/orders/${orderId}`);
                        const data = await response.json();
                        if (data.success) {
                            this.modal.data = data.order;
                        } else {
                            throw new Error(data.message);
                        }
                    } catch (error) {
                        this.showToast(error.message || 'Gagal memuat detail', 'error');
                        this.closeModal();
                    } finally {
                        this.isLoading.modal = false;
                    }
                },

                closeModal() {
                    this.modal.isOpen = false;
                    setTimeout(() => {
                        this.modal.data = null;
                    }, 300);
                },

                toggleActionMenu(orderId) {
                    this.actionMenuOpenFor = this.actionMenuOpenFor === orderId ? null : orderId;
                },

                closeActionMenu() {
                    this.actionMenuOpenFor = null;
                },

                async updateStatus(orderId, newStatus) {
                    this.closeActionMenu();
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch(`/admin/orders/${orderId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ status: newStatus })
                        });
                        
                        const data = await response.json();
                        if (!data.success) throw new Error(data.message);

                        this.showToast(data.message, 'success');
                        const updatedOrder = data.order;
                        const activeIndex = this.activeOrders.findIndex(o => o.id === updatedOrder.id);

                        if (['completed', 'cancelled'].includes(updatedOrder.status)) {
                            if (activeIndex !== -1) this.activeOrders.splice(activeIndex, 1);
                            if (!this.orderHistory.some(r => r.id === updatedOrder.id)) {
                                this.orderHistory.unshift(updatedOrder);
                            }
                        } else {
                            if (activeIndex !== -1) this.activeOrders[activeIndex] = updatedOrder;
                        }
                    } catch (error) {
                        this.showToast(error.message || `Gagal mengubah status`, 'error');
                    }
                },

                formatCurrency(value) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(value);
                },

                formatDateTime(isoString) {
                    return new Date(isoString).toLocaleString('id-ID', {
                        dateStyle: 'medium',
                        timeStyle: 'short'
                    });
                },

                getStatusClass(status) {
                    return {
                        'pending': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                        'paid': 'bg-blue-100 text-blue-800 border border-blue-200',
                        'preparing': 'bg-purple-100 text-purple-800 border border-purple-200',
                        'completed': 'bg-green-100 text-green-800 border border-green-200',
                        'cancelled': 'bg-red-100 text-red-800 border border-red-200',
                    }[status] || 'bg-gray-100 text-gray-800 border border-gray-200';
                },

                showToast(message, type = 'info') {
                    Toastify({
                        text: message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: {
                                success: '#10B981',
                                error: '#EF4444',
                                info: '#3B82F6'
                            }[type] || '#6B7280'
                        }
                    }).showToast();
                }
            }));
        });
    </script>
</x-layout>