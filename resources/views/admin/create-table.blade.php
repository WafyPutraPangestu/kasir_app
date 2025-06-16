<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('admin.tables.index') }}" class="ml-4 text-gray-500 hover:text-indigo-600">Meja</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ml-4 text-gray-700 font-medium">Tambah Meja</span>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tambah Meja Baru</h1>
                <p class="mt-2 text-sm sm:text-base text-gray-600">Buat meja baru untuk restoran Anda.</p>
            </div>

            <!-- Toast Container -->
            <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-4"></div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Formulir Tambah Meja</h2>
                </div>
                <div class="p-8">
                    <div x-data="{ 
                        isSubmitting: false,
                        formValid: true,
                        submitForm() {
                            this.formValid = true;
                            const nameInput = document.getElementById('name');
                            if (!nameInput.value.trim()) {
                                this.formValid = false;
                                showToast('Nama meja harus diisi', 'error');
                                return;
                            }
                            this.isSubmitting = true;
                            this.$refs.form.submit();
                        }
                    }">
                        <form method="POST" action="{{ route('admin.tables.store') }}" x-ref="form">
                            @csrf
                            <div class="space-y-6">
                                <!-- Input Nama Meja -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Nama Meja
                                            <span class="text-red-500 ml-1">*</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input id="name" 
                                               name="name" 
                                               type="text" 
                                               value="{{ old('name') }}" 
                                               required 
                                               autofocus
                                               placeholder="Masukkan nama meja (Contoh: Meja 01, Pojok Kiri)"
                                               class="block w-full max-w-lg px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200 text-gray-900 placeholder-gray-400 bg-gray-50 focus:bg-white {{ $errors->has('name') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('name')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Nama meja harus unik
                                    </p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                                    <a href="{{ route('admin.tables.index') }}" 
                                       class="inline-flex justify-center items-center px-6 py-3 border-2 border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Batal
                                    </a>
                                    <button type="button" 
                                            x-on:click="submitForm()"
                                            x-bind:disabled="isSubmitting"
                                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg x-show="!isSubmitting" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <svg x-show="isSubmitting" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Meja'">Simpan Meja</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Show initial notifications if they exist
        @if (session('success'))
            showToast('{{ session("success") }}', 'success');
        @endif
        @if (session('error'))
            showToast('{{ session("error") }}', 'error');
        @endif

        // Toast notification function
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            const toastId = 'toast-' + Date.now();
            
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const icon = type === 'success' ? 
                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>' :
                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';

            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `${bgColor} text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out max-w-xs sm:max-w-sm`;
            toast.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            ${icon}
                        </div>
                        <div class="ml-3">
                            <p class="text-xs sm:text-sm font-medium">${message}</p>
                        </div>
                    </div>
                    <button onclick="dismissToast('${toastId}')" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `;

            toastContainer.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                dismissToast(toastId);
            }, 5000);
        }

        function dismissToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }
    </script>
    @endpush
</x-layout>