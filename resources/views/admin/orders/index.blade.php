<x-layout>
    <div x-data="orderDashboard" x-cloak class="container mx-auto p-4 sm:p-6 lg:p-8 font-sans">
        
        {{-- Header tidak berubah --}}
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Dasbor Pesanan</h1>
            <p class="text-gray-500 mt-1">Manajemen pesanan aktif dan riwayat transaksi.</p>
        </header>

        {{-- Kartu Statistik tidak berubah --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pesanan -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex items-center space-x-4 transform hover:-translate-y-1 transition-transform duration-300">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pesanan (Hari Ini)</p>
                    <p class="text-2xl font-bold text-gray-800" x-text="todayStats.total_orders"></p>
                </div>
            </div>
            <!-- Total Pendapatan -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex items-center space-x-4 transform hover:-translate-y-1 transition-transform duration-300">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 11.218 12 10.5 12 10.5s-1.536-.718-2.621-1.818c-1.172-.879-1.172-2.303 0-3.182C10.536 4.621 12 5.25 12 5.25s1.536.718 2.621 1.818l.879.659M7 12h10"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-800" x-text="formatCurrency(todayStats.total_revenue)"></p>
                </div>
            </div>
            <!-- Pesanan Selesai -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex items-center space-x-4 transform hover:-translate-y-1 transition-transform duration-300">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pesanan Selesai</p>
                    <p class="text-2xl font-bold text-gray-800" x-text="todayStats.completed_orders"></p>
                </div>
            </div>
            <!-- Pesanan Pending -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex items-center space-x-4 transform hover:-translate-y-1 transition-transform duration-300">
                <div class="bg-yellow-100 p-3 rounded-full">
                     <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pesanan Pending</p>
                    <p class="text-2xl font-bold text-gray-800" x-text="todayStats.pending_orders"></p>
                </div>
            </div>
        </div>

        {{-- Sistem Tab --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            {{-- Navigasi Tab --}}
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-6 px-6" aria-label="Tabs">
                    <button @click="activeTab = 'active'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'active', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'active' }" class="relative whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none">
                        Pesanan Aktif
                        <span x-show="newOrdersCount > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center" x-text="newOrdersCount"></span>
                    </button>
                    <button @click="activeTab = 'history'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'history', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'history' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none">
                        Riwayat Pesanan
                    </button>
                </nav>
            </div>

            <div class="p-6 min-h-[400px]">
                {{-- Panel Pesanan Aktif --}}
                <div x-show="activeTab === 'active'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="order in activeOrders" :key="order.id">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm flex flex-col justify-between transition-shadow hover:shadow-md">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-bold text-lg text-gray-800">Pesanan #<span x-text="order.id"></span></p>
                                            <p class="text-sm text-gray-600">Meja: <span x-text="order.table.name"></span></p>
                                        </div>
                                        <span :class="getStatusClass(order.status)" class="text-xs font-semibold px-2.5 py-0.5 rounded-full" x-text="order.status.charAt(0).toUpperCase() + order.status.slice(1)"></span>
                                    </div>
                                    <div class="mt-4 border-t pt-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Items:</p>
                                        <ul class="text-sm text-gray-600 space-y-1 max-h-24 overflow-y-auto pr-2">
                                            <template x-for="item in order.items" :key="item.id">
                                                <li><span x-text="item.quantity"></span>x <span x-text="item.product.name"></span></li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-4 border-t pt-4 flex justify-between items-center">
                                    <p class="text-lg font-bold text-indigo-600" x-text="formatCurrency(order.total_amount)"></p>
                                    <div class="flex items-center space-x-2">
                                        <button @click="showOrderDetails(order.id)" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition">Detail</button>
                                        <div class="inline-block relative" x-data="{ dropdownOpen: false }">
                                            <button @click="dropdownOpen = !dropdownOpen" class="text-sm bg-indigo-500 text-white px-3 py-1 rounded-md hover:bg-indigo-600 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ubah Status</button>
                                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-20 border">
                                                <template x-if="order.status === 'pending'">
                                                     <a @click.prevent="updateStatus(order.id, 'paid'); dropdownOpen = false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paid</a>
                                                </template>
                                                
                                                <template x-if="order.status === 'paid'">
                                                    <div>
                                                        <a @click.prevent="updateStatus(order.id, 'preparing'); dropdownOpen = false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Preparing</a>
                                                        <a @click.prevent="updateStatus(order.id, 'completed'); dropdownOpen = false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Completed</a>
                                                    </div>
                                                </template>

                                                <template x-if="order.status === 'preparing'">
                                                     <a @click.prevent="updateStatus(order.id, 'completed'); dropdownOpen = false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Completed</a>
                                                </template>

                                                <div class="border-t my-1"></div>
                                                <a @click.prevent="updateStatus(order.id, 'cancelled'); dropdownOpen = false" href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div x-show="activeOrders.length === 0" class="col-span-full text-center py-12 text-gray-500 flex flex-col items-center justify-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pesanan aktif</h3>
                            <p class="mt-1 text-sm text-gray-500">Semua pesanan yang masuk sudah selesai.</p>
                        </div>
                    </div>
                </div>

                {{-- Panel Riwayat Pesanan --}}
                <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    {{-- Filter Tanggal --}}
                    <div class="flex flex-wrap items-end gap-4 mb-6">
                        <div>
                            <label for="startDate" class="text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input x-ref="startDate" type="text" id="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="endDate" class="text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input x-ref="endDate" type="text" id="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <button @click="fetchOrderHistory" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-wait" :disabled="isLoading.history">
                            <span x-show="!isLoading.history">Filter</span>
                            <span x-show="isLoading.history">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    
                    {{-- Tabel Riwayat --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meja</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-if="isLoading.history">
                                    <template x-for="i in 5">
                                        <tr><td class="px-6 py-4" colspan="5"><div class="animate-pulse h-4 bg-gray-200 rounded w-full"></div></td></tr>
                                    </template>
                                </template>
                                <template x-if="!isLoading.history">
                                    <template x-for="report in orderHistory" :key="report.id">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="report.id"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="report.table.name"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="formatDateTime(report.created_at)"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span :class="getStatusClass(report.status)" class="text-xs font-semibold px-2.5 py-0.5 rounded-full" x-text="report.status.charAt(0).toUpperCase() + report.status.slice(1)"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-800" x-text="formatCurrency(report.total_amount)"></td>
                                        </tr>
                                    </template>
                                </template>
                                <tr x-show="!isLoading.history && orderHistory.length === 0">
                                    <td colspan="5" class="text-center py-12 text-gray-500">
                                        Tidak ada data riwayat untuk rentang tanggal yang dipilih.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal tidak berubah --}}
        <div x-show="modal.isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" @keydown.escape.window="closeModal()">
            <div @click.away="closeModal" x-show="modal.isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-auto">
                 <div class="p-6">
                    <div class="flex justify-between items-center border-b pb-3 mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Detail Pesanan #<span x-text="modal.data?.id"></span></h3>
                        <button @click="closeModal" class="text-gray-400 hover:text-gray-600 text-3xl leading-none focus:outline-none">&times;</button>
                    </div>
                    <div>
                        <template x-if="isLoading.modal">
                            <div class="text-center py-8">
                                <svg class="animate-spin mx-auto h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="mt-2 text-gray-500">Memuat data...</p>
                            </div>
                        </template>
                        <template x-if="!isLoading.modal && modal.data">
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                                    <div><p class="text-gray-500">Meja</p><p class="font-medium text-gray-800" x-text="modal.data.table.name"></p></div>
                                    <div><p class="text-gray-500">Status</p><p class="font-medium text-gray-800"><span :class="getStatusClass(modal.data.status)" class="text-xs font-semibold px-2.5 py-0.5 rounded-full" x-text="modal.data.status.charAt(0).toUpperCase() + modal.data.status.slice(1)"></span></p></div>
                                    <div><p class="text-gray-500">Tanggal</p><p class="font-medium text-gray-800" x-text="formatDateTime(modal.data.created_at)"></p></div>
                                </div>
                                <div class="border-t pt-4">
                                    <h4 class="font-semibold text-gray-800 mb-2">Rincian Item</h4>
                                    <ul class="divide-y divide-gray-200 max-h-48 overflow-y-auto pr-2">
                                        <template x-for="item in modal.data.items" :key="item.id">
                                            <li class="py-2 flex justify-between items-center">
                                                <div>
                                                    <p class="font-medium text-gray-800" x-text="item.product.name"></p>
                                                    <p class="text-sm text-gray-500">Jumlah: <span x-text="item.quantity"></span></p>
                                                </div>
                                                <p class="text-sm text-gray-700" x-text="formatCurrency(item.price * item.quantity)"></p>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <div class="border-t pt-4 flex justify-end">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Total</p>
                                        <p class="text-2xl font-bold text-indigo-600" x-text="formatCurrency(modal.data.total_amount)"></p>
                                    </div>
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
                activeOrders: @json($activeOrders),
                orderHistory: @json($historyOrders),
                todayStats: @json($todayStats),
                filter: {
                    startDate: @json($startDate),
                    endDate: @json($endDate),
                },
                isLoading: { history: false, modal: false },
                modal: { isOpen: false, data: null },
                newOrdersCount: 0,
                
                init() {
                    flatpickr(this.$refs.startDate, { defaultDate: this.filter.startDate, dateFormat: "Y-m-d", onChange: (d, str) => this.filter.startDate = str });
                    flatpickr(this.$refs.endDate, { defaultDate: this.filter.endDate, dateFormat: "Y-m-d", onChange: (d, str) => this.filter.endDate = str });
                    setInterval(() => this.checkNewOrders(), 15000);
                    console.log('Order Dashboard V3 (Instant Update) Initialized');
                },

                // Helper tidak berubah
                formatCurrency(value) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value); },
                formatDateTime(isoString) { return new Date(isoString).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }); },
                getStatusClass(status) {
                    const classes = {
                        'draft': 'bg-gray-200 text-gray-800', 'pending': 'bg-yellow-100 text-yellow-800',
                        'paid': 'bg-blue-100 text-blue-800', 'preparing': 'bg-purple-100 text-purple-800',
                        'completed': 'bg-green-100 text-green-800', 'cancelled': 'bg-red-100 text-red-800',
                    };
                    return classes[status] || classes['draft'];
                },

                // Fetch logic tidak berubah
                async fetchOrderHistory() {
                    if (this.isLoading.history) return;
                    this.isLoading.history = true;
                    try {
                        const params = new URLSearchParams({ start_date: this.filter.startDate, end_date: this.filter.endDate });
                        const response = await fetch(`{{ route('admin.orders.history') }}?${params}`);
                        const data = await response.json();
                        if (data.success) {
                            this.orderHistory = data.reports;
                            this.showToast('Riwayat berhasil diperbarui.', 'success');
                        } else { throw new Error(data.message); }
                    } catch (error) {
                        this.showToast(error.message, 'error');
                    } finally {
                        this.isLoading.history = false;
                    }
                },
                async checkNewOrders() {
                    try {
                        const response = await fetch(`{{ route('admin.orders.checkNew') }}`);
                        const data = await response.json();
                        if (data.hasNew && data.count > 0) {
                            this.newOrdersCount = data.count;
                            this.showToast(`${data.count} pesanan baru telah masuk!`, 'info');
                            await this.fetchActiveOrders();
                        } else {
                            this.newOrdersCount = 0;
                        }
                    } catch (error) { console.error('Check new orders error:', error); }
                },
                async fetchActiveOrders() {
                    try {
                        const response = await fetch(`{{ route('admin.orders.active') }}`);
                        const data = await response.json();
                        if (data.success) { this.activeOrders = data.orders; }
                    } catch (error) { console.error('Fetch active orders error:', error); }
                },
                async showOrderDetails(orderId) {
                    this.modal.isOpen = true; this.isLoading.modal = true; this.modal.data = null;
                    try {
                        const response = await fetch(`/admin/orders/${orderId}`);
                        const data = await response.json();
                        if (data.success) { this.modal.data = data.order; } 
                        else { throw new Error(data.message); }
                    } catch (error) {
                        this.showToast(error.message, 'error'); this.closeModal();
                    } finally { this.isLoading.modal = false; }
                },
                closeModal() { this.modal.isOpen = false; setTimeout(() => { this.modal.data = null; }, 300); },

                // [MODIFIKASI KUNCI] Logika update status yang lebih baik
                async updateStatus(orderId, newStatus) {
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch(`/admin/orders/${orderId}/update-status`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                            body: JSON.stringify({ status: newStatus })
                        });
                        const data = await response.json();
                        if (!data.success) throw new Error(data.message);
                        
                        this.showToast(data.message, 'success');
                        const updatedOrder = data.order;
                        const activeIndex = this.activeOrders.findIndex(o => o.id === updatedOrder.id);
                        
                        // Cek apakah status baru adalah status final (completed/cancelled)
                        if (['completed', 'cancelled'].includes(updatedOrder.status)) {
                            // Jika ya, hapus dari daftar aktif
                            if (activeIndex !== -1) {
                                this.activeOrders.splice(activeIndex, 1);
                            }
                            // Dan langsung tambahkan ke daftar riwayat di paling atas
                            if (!this.orderHistory.some(r => r.id === updatedOrder.id)) {
                                this.orderHistory.unshift(updatedOrder);
                            }
                        } else {
                            // Jika status baru masih aktif (misal: paid -> preparing)
                            // Cukup perbarui data pesanan di tempatnya
                            if (activeIndex !== -1) {
                                this.activeOrders[activeIndex] = updatedOrder;
                            }
                        }

                    } catch (error) { 
                        this.showToast(error.message, 'error'); 
                    }
                },
                
                showToast(message, type = 'info') {
                    Toastify({
                        text: message, duration: 3000, close: true, gravity: "top", position: "right",
                        style: { background: {success: '#00b09b', error: '#ff5f6d', info: '#0072ff'}[type] || '#0072ff' }
                    }).showToast();
                }
            }));
        });
    </script>
</x-layout>
