<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran - Order #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- SweetAlert2 tidak lagi digunakan, diganti modal kustom --}}
   
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-indigo-100 h-full font-sans">
    <div class="min-h-screen flex items-center justify-center p-4" 
         x-data="pollingStatus()" 
         x-init="init()"
         x-cloak>
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-2xl max-w-md w-full mx-auto text-center transition-all duration-300">
            
            {{-- Visualisasi Status --}}
            <div class="relative w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                {{-- Polling/Loading State --}}
                <template x-if="isLoading">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="absolute w-full h-full bg-indigo-100 rounded-full animate-ping opacity-50"></div>
                        <div class="w-20 h-20 bg-indigo-200 rounded-full"></div>
                    </div>
                </template>

                {{-- Ikon Status --}}
                <div class="relative transition-transform duration-300" :class="{ 'scale-110': !isLoading }">
                    <template x-if="status === 'paid'">
                        <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </template>
                    <template x-if="['cancelled', 'expire', 'deny'].includes(status)">
                        <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                    </template>
                     <template x-if="!['paid', 'cancelled', 'expire', 'deny'].includes(status)">
                        <div class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </template>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-slate-800" x-text="statusMessage"></h1>
            <p class="text-slate-600 mt-2">ID Pesanan: #{{ $order->id }} | Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

            <p class="text-sm text-slate-500 mt-4 h-5" x-show="timeRemaining > 0 && pollingStarted">
                Timeout dalam: <span x-text="formatTime(timeRemaining)" class="font-semibold"></span>
            </p>

            {{-- Tombol Aksi --}}
            <div class="mt-8">
                <div x-show="currentStep === 'payment'">
                     <button @click="openSnapPayment"
                            class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lanjutkan Pembayaran
                    </button>
                    <button @click="cancelProcess" 
                            class="mt-3 w-full text-center text-slate-600 font-medium py-2 rounded-lg hover:bg-slate-200 transition">
                        Batal
                    </button>
                </div>

                <div x-show="currentStep === 'restart'">
                    <button @click="restartProcess"
                            class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Coba Bayar Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pollingStatus() {
            return {
                orderId: {{ $order->id }},
                status: '{{ $order->status }}',
                statusMessage: 'Menunggu konfirmasi pembayaran.',
                snapToken: '{{ $order->snap_token }}',
                isLoading: false,
                timer: null,
                timeout: null,
                timeRemaining: 300, // 5 menit
                pollingStarted: false,
                currentStep: 'payment', // 'payment', 'polling', 'restart'

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
                            // Setelah popup ditutup, langsung mulai polling
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
                    this.statusMessage = 'Pembayaran Berhasil!';
                    setTimeout(() => {
                        window.location.href = '{{ route("customer.success") }}';
                    }, 1500);
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
                    window.location.href = '{{ route("home") }}'; // Arahkan ke halaman utama atau menu
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
            }
        }
    </script>
</body>
</html>
