<x-guest.layout>

    <div class="bg-gradient-to-br from-slate-50 to-indigo-100 h-full font-sans">
        <div class="min-h-screen flex items-center justify-center p-4" x-data="pollingStatus" x-init="init()"
            x-cloak>
            <div
                class="bg-white p-6 sm:p-8 rounded-2xl shadow-2xl max-w-md w-full mx-auto text-center transition-all duration-300">

                <div x-show="!isSuccess" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div class="relative w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                        <template x-if="isLoading">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="absolute w-full h-full bg-indigo-100 rounded-full animate-ping opacity-50">
                                </div>
                                <div class="w-20 h-20 bg-indigo-200 rounded-full"></div>
                            </div>
                        </template>
                        <div class="relative transition-transform duration-300" :class="{ 'scale-110': !isLoading }">
                            <template x-if="['cancelled', 'expire', 'deny'].includes(status)">
                                <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center"><svg
                                        class="w-12 h-12 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg></div>
                            </template>
                            <template x-if="!['paid', 'cancelled', 'expire', 'deny'].includes(status)">
                                <div class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center"><svg
                                        class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg></div>
                            </template>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-800" x-text="statusMessage"></h1>
                    <p class="text-slate-600 mt-2">ID Pesanan: #{{ $order->id }} | Total: Rp
                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <p class="text-sm text-slate-500 mt-4 h-5" x-show="timeRemaining > 0 && pollingStarted">Timeout
                        dalam: <span x-text="formatTime(timeRemaining)" class="font-semibold"></span></p>
                    <div class="mt-8">
                        <div x-show="currentStep === 'payment'">
                            <button @click="openSnapPayment"
                                class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Lanjutkan
                                Pembayaran</button>
                            <button @click="cancelProcess"
                                class="mt-3 w-full text-center text-slate-600 font-medium py-2 rounded-lg hover:bg-slate-200 transition">Batal</button>
                        </div>
                        <div x-show="currentStep === 'restart'">
                            <button @click="restartProcess"
                                class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Coba
                                Bayar Lagi</button>
                        </div>
                    </div>
                </div>

                <div x-show="isSuccess" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <template x-for="i in 20">
                            <div class="confetti"
                                :style="`background-color: ${['#f59e0b', '#10b981', '#3b82f6', '#ec4899'][i % 4]}; left: ${Math.random() * 100}%; animation-delay: ${Math.random() * 1.5}s;`">
                            </div>
                        </template>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-900 mb-4">Pembayaran Berhasil!</h1>
                    <p class="text-lg text-slate-600 mb-8">Terima kasih! Pesanan Anda sedang kami siapkan dan akan
                        segera diantar ke meja.</p>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-left">
                        <h2 class="text-lg font-semibold text-slate-800 mb-3">Detail Pesanan</h2>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-slate-500">Nomor Pesanan:</span> <span
                                    class="font-medium text-slate-800">#{{ $order->id }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">Meja:</span> <span
                                    class="font-medium text-slate-800">{{ $table_name }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">Total Pembayaran:</span>
                                <span class="font-medium text-slate-800">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between"><span class="text-slate-500">Status:</span> <span
                                    class="font-bold text-green-600">{{ strtoupper($order->status) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }

            .confetti {
                position: absolute;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                opacity: 0;
                animation: confetti-fall 1.5s ease-out forwards;
            }

            @keyframes confetti-fall {
                0% {
                    transform: translateY(-10px) scale(1);
                    opacity: 1;
                }

                100% {
                    transform: translateY(80px) scale(0);
                    opacity: 0;
                }
            }
        </style>

        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('pollingStatus', () => ({
                    orderId: {{ $order->id }},
                    status: '{{ $order->status }}',
                    statusMessage: 'Menunggu konfirmasi pembayaran.',
                    snapToken: '{{ $order->snap_token }}',
                    isLoading: false,
                    isSuccess: false,
                    timer: null,
                    timeout: null,
                    timeRemaining: 300,
                    pollingStarted: false,
                    currentStep: 'payment',

                    init() {
                        if (this.status === 'paid') {
                            this.handleSuccess();
                            return;
                        }
                        if (['cancelled', 'expire', 'deny'].includes(this.status)) {
                            this.handleFailure(this.getStatusText(this.status));
                            return;
                        }
                        this.currentStep = 'payment';
                        this.statusMessage = 'Klik untuk melanjutkan pembayaran.';
                    },

                    openSnapPayment() {
                        if (!this.snapToken) {
                            alert('Token pembayaran tidak valid.');
                            return;
                        }
                        window.snap.pay(this.snapToken, {
                            onSuccess: (result) => this.startPolling(),
                            onPending: (result) => this.startPolling(),
                            onError: (result) => alert('Terjadi kesalahan pembayaran.'),
                            onClose: () => {
                                if (!this.pollingStarted) {
                                    this.startPolling();
                                }
                            }
                        });
                    },

                    startPolling() {
                        this.currentStep = 'polling';
                        this.pollingStarted = true;
                        this.statusMessage = 'Memantau status pembayaran...';
                        this.isLoading = true;

                        this.timer = setInterval(() => this.checkOrderStatus(), 3000);

                        this.timeout = setInterval(() => {
                            this.timeRemaining--;
                            if (this.timeRemaining <= 0) {
                                this.handleTimeout();
                            }
                        }, 1000);

                        this.checkOrderStatus();
                    },

                    stopPolling() {
                        clearInterval(this.timer);
                        clearInterval(this.timeout);
                        this.timer = null;
                        this.timeout = null;
                        this.pollingStarted = false;
                        this.isLoading = false;
                    },

                    async checkOrderStatus() {
                        try {
                            const response = await fetch(`/orders/${this.orderId}/check-status`);
                            const data = await response.json();
                            this.status = data.status;

                            if (this.status === 'paid') {
                                this.handleSuccess();
                            } else if (['cancelled', 'expire', 'deny'].includes(this.status)) {
                                this.handleFailure(this.getStatusText(this.status));
                            }
                        } catch (error) {
                            console.error('Error checking status:', error);
                        }
                    },

                    handleSuccess() {
                        this.stopPolling();
                        this.isSuccess = true;
                    },

                    handleFailure(message) {
                        this.stopPolling();
                        this.statusMessage = message || 'Pembayaran Gagal';
                        this.currentStep = 'restart';
                    },

                    handleTimeout() {
                        this.stopPolling();
                        this.statusMessage = 'Waktu pembayaran habis.';
                        this.currentStep = 'restart';
                    },

                    cancelProcess() {
                        this.stopPolling();
                        window.location.href = '{{ route('home') }}';
                    },

                    restartProcess() {
                        this.currentStep = 'payment';
                        this.statusMessage = 'Klik untuk melanjutkan pembayaran.';
                        this.timeRemaining = 300;
                        this.status = 'pending';
                    },

                    getStatusText(status) {
                        const statusTexts = {
                            'pending': 'Menunggu pembayaran',
                            'paid': 'Pembayaran berhasil',
                            'cancelled': 'Pembayaran dibatalkan',
                            'expire': 'Pembayaran kadaluarsa',
                            'deny': 'Pembayaran ditolak'
                        };
                        return statusTexts[status] || 'Status tidak dikenal';
                    },

                    formatTime(seconds) {
                        const mins = Math.floor(seconds / 60);
                        const secs = seconds % 60;
                        return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                    }
                }));
            });
        </script>
    </div>
</x-guest.layout>
