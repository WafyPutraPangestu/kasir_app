<x-guest.layout>
    <div x-data="cartApp()" class="bg-slate-100 min-h-screen font-sans p-4 sm:p-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Review Pesanan Anda</h1>
                <p class="mt-2 text-lg text-slate-600">Satu langkah lagi! Silakan periksa kembali detail pesanan Anda di
                    bawah ini.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Order #{{ $order->id }}</h2>
                            <p class="text-sm text-slate-500">Untuk Meja: {{ $order->table->name }}</p>
                        </div>
                        <span
                            class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium border border-yellow-200">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Rincian Item</h3>
                    <ul class="divide-y divide-slate-200">
                        @foreach ($order->items as $item)
                            <li class="py-4 flex items-center">
                                <div class="flex-shrink-0 w-16 h-16 bg-slate-200 rounded-lg overflow-hidden">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/100x100/e2e8f0/64748b?text=Menu' }}"
                                        alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-md font-semibold text-slate-800">{{ $item->product->name }}</h4>
                                    <div class="flex justify-between mt-1">
                                        <p class="text-sm text-slate-500">{{ $item->quantity }} x Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</p>
                                        <p class="text-md font-medium text-slate-900">Rp
                                            {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-6 border-t border-slate-200 bg-slate-50">
                    <div class="flex justify-between items-center text-slate-800 mb-6">
                        <span class="text-lg font-medium">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-indigo-600">Rp
                            {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="space-y-3">
                        <button @click="payOrder()" id="pay-button"
                            class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold shadow-md hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center disabled:bg-slate-400 disabled:transform-none">
                            <span x-show="!isProcessing">Bayar Sekarang</span>
                            <span x-show="isProcessing">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                        </button>

                        @if (in_array($order->status, ['draft', 'pending']))
                            <button @click="isCancelModalOpen = true"
                                class="w-full text-center text-red-600 font-medium py-2 rounded-lg hover:bg-red-50 transition">
                                Batalkan Pesanan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div x-show="isCancelModalOpen"
            class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4" x-cloak>
            <div @click.away="isCancelModalOpen = false" x-show="isCancelModalOpen"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Batalkan Pesanan?</h3>
                <p class="mt-2 text-sm text-slate-600">Apakah Anda yakin ingin membatalkan pesanan ini? Aksi ini tidak
                    dapat diurungkan.</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <button @click="isCancelModalOpen = false"
                        class="px-6 py-2 rounded-lg bg-slate-200 text-slate-800 hover:bg-slate-300 transition">
                        Tidak
                    </button>
                    <button @click="cancelOrder()"
                        class="px-6 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition flex items-center justify-center"
                        :disabled="isProcessing">
                        <span x-show="!isProcessing">Ya, Batalkan</span>
                        <span x-show="isProcessing">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        function cartApp() {
            return {
                isCancelModalOpen: false,
                isProcessing: false,

                payOrder() {
                    this.isProcessing = true;
                    // Tidak perlu menonaktifkan tombol secara manual, Alpine akan menanganinya via :disabled

                    fetch('{{ route('orders.pay', $order) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                alert('Gagal memulai proses pembayaran');
                                this.isProcessing = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat memproses pembayaran');
                            this.isProcessing = false;
                        });
                },

                cancelOrder() {
                    this.isProcessing = true;
                    fetch('{{ route('orders.cancel', $order) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                alert(data.message || 'Gagal membatalkan pesanan');
                                this.isProcessing = false;
                                this.isCancelModalOpen = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal membatalkan pesanan');
                            this.isProcessing = false;
                            this.isCancelModalOpen = false;
                        });
                }
            };
        }
        // [CLEANUP] Menghapus event listener 'DOMContentLoaded' yang tidak diperlukan lagi
    </script>
</x-guest.layout>
