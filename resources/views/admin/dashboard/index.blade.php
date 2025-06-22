<x-layout>
    <div class="min-h-screen bg-gray-50" x-data="dashboardManager()">
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
                        <p class="text-gray-600 mt-1 text-sm">Selamat datang kembali! Berikut ringkasan coffeeshop hari
                            ini.</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

                <div class="bg-white rounded-lg shadow p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pesanan Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $todayOrders }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $pendingOrders }} menunggu</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Revenue Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">Rp
                                {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Target: Rp 5.000.000</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Revenue Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">Rp
                                {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $monthlyOrders }} pesanan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Revenue 7 Hari Terakhir</h2>
                        <div class="text-sm text-gray-500">
                            Total: Rp {{ number_format(collect($revenueChart)->sum('revenue'), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas x-ref="revenueChart"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Produk Terpopuler</h2>
                        <div class="text-sm text-gray-500">Top 5</div>
                    </div>
                    <div class="space-y-3">
                        @forelse($popularProducts as $index => $item)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-sm font-bold text-blue-600">{{ $index + 1 }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $item->total_quantity }} terjual</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">Belum ada data penjualan</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
                            <a href="{{ route('admin.orders.index') }}"
                                class="text-sm text-blue-600 hover:text-blue-900 flex items-center">
                                Lihat Semua
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($recentOrders as $order)
                            <div class="p-5">

                                <div class="flex items-center justify-between mb-3 cursor-pointer"
                                    @click="toggleOrderDetail({{ $order->id }})">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                            <span
                                                class="text-sm font-bold text-blue-600">#{{ str_pad($order->id, 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $order->table->name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $order->items->sum('quantity') }}
                                                items • {{ $order->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right flex items-center">
                                        <div class="mr-3">
                                            <p class="font-semibold text-gray-900">Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                                            @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'preparing') bg-orange-100 text-orange-800
                                            @elseif($order->status === 'ready') bg-purple-100 text-purple-800
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform"
                                            :class="{ 'rotate-180': openOrder === {{ $order->id }} }"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="openOrder === {{ $order->id }}" x-collapse
                                    class="mt-4 bg-gray-50 rounded-lg p-4">
                                    <div class="space-y-3">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Waktu Pesanan:</span>
                                            <span
                                                class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                        </div>

                                        <div class="border-t pt-3">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Detail Item:</h4>
                                            <div class="space-y-2">
                                                @foreach ($order->items as $item)
                                                    <div class="flex justify-between text-sm">
                                                        <div>
                                                            <span
                                                                class="text-gray-900">{{ $item->product->name }}</span>
                                                            <span
                                                                class="text-gray-500 ml-2">x{{ $item->quantity }}</span>
                                                        </div>
                                                        <span class="font-medium">Rp
                                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                                    </div>
                                                    @if ($item->notes)
                                                        <div class="text-xs text-gray-500 ml-4">
                                                            Catatan: {{ $item->notes }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                        @if ($order->notes)
                                            <div class="border-t pt-3">
                                                <h4 class="text-sm font-medium text-gray-900">Catatan Pesanan:</h4>
                                                <p class="text-sm text-gray-600 mt-1">{{ $order->notes }}</p>
                                            </div>
                                        @endif

                                        <div class="border-t pt-3 flex justify-between font-medium">
                                            <span>Total:</span>
                                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-sm">Belum ada pesanan hari ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="space-y-6">

                    <div class="bg-white rounded-lg shadow p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.orders.index') }}"
                                class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium text-blue-900">Kelola Pesanan</span>
                            </a>

                            <button @click="refreshData()"
                                class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors w-full">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium text-green-900">Refresh Data</span>
                            </button>

                            <a href="{{ route('admin.produk.index') }}"
                                class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="text-sm font-medium text-purple-900">Tambah Produk</span>
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Info Sistem</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Total Meja:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $totalTables }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Total Produk:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $totalProducts }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Total Kategori:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $totalCategories }}</span>
                            </div>
                            <div class="pt-3 mt-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Status Sistem:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Online
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        function dashboardManager() {
            return {
                chart: null,
                openOrder: null,

                init() {
                    this.$nextTick(() => {
                        this.initChart();
                    });
                },

                initChart() {
                    const ctx = this.$refs.revenueChart.getContext('2d');
                    const revenueData = @json($revenueChart);

                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: revenueData.map(item => item.date),
                            datasets: [{
                                label: 'Revenue (Rp)',
                                data: revenueData.map(item => item.revenue),
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                        }
                                    }
                                }
                            },
                            elements: {
                                point: {
                                    radius: 4,
                                    hoverRadius: 6
                                }
                            }
                        }
                    });
                },

                toggleOrderDetail(orderId) {
                    this.openOrder = this.openOrder === orderId ? null : orderId;
                },

                refreshData() {
                    location.reload();
                }
            }
        }

        setInterval(() => {
            location.reload();
        }, 300000);
    </script>
</x-layout>
