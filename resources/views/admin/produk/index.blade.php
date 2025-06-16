<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Manajemen Produk</h1>
                    <p class="text-sm sm:text-base text-gray-600">Kelola produk Anda dengan mudah</p>
                </div>
                <a href="{{ route('admin.produk.create') }}"
                   class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 border border-transparent rounded-xl font-medium text-sm text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Produk
                </a>
            </div>

            <!-- Toast Notification Container -->
            <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-4"></div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Stats Header -->
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-4 sm:px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-indigo-100 rounded-lg">
                                <svg class="w-5 sm:w-6 h-5 sm:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Daftar Produk</h3>
                                <p class="text-xs sm:text-sm text-gray-600">Total: {{ count($products) }} produk</p>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Gambar
                                </th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nama Produk
                                </th>
                                <th scope="col" class="hidden md:table-cell px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th scope="col" class="hidden lg:table-cell px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th scope="col" class="hidden lg:table-cell px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="relative px-4 sm:px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80' }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg">
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <div class="text-sm sm:text-base font-semibold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs sm:text-sm text-gray-500 md:hidden mt-1">
                                                Kategori: {{ $product->category->name }}
                                            </div>
                                            <div class="text-xs sm:text-sm text-gray-500 lg:hidden mt-1">
                                                Harga: Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs sm:text-sm lg:hidden mt-1">
                                                Status: 
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-gray-100 text-gray-800">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td class="hidden lg:table-cell px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium text-gray-800">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="hidden lg:table-cell px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium 
                                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="{{ $product->is_active ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                                            </svg>
                                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.produk.edit', $product->id) }}" 
                                               class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 border border-indigo-300 rounded-lg text-xs sm:text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 hover:border-indigo-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-0 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </a>
                                            
                                            <!-- Delete Button -->
                                            <button type="button" 
                                                    onclick="showDeleteConfirmation('{{ $product->id }}', '{{ $product->name }}')"
                                                    class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 border border-red-300 rounded-lg text-xs sm:text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-0 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span class="hidden sm:inline">Hapus</span>
                                            </button>
                                        </div>

                                        <!-- Hidden Delete Form -->
                                        <form id="delete-form-{{ $product->id }}" 
                                              action="{{ route('admin.produk.destroy', $product->id) }}" 
                                              method="POST" 
                                              class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 sm:px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 sm:w-16 h-12 sm:h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">Belum Ada Produk</h3>
                                            <p class="text-xs sm:text-sm text-gray-500 mb-4">Mulai dengan menambahkan produk pertama Anda</p>
                                            <a href="{{ route('admin.produk.create') }}" 
                                               class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-xs sm:text-sm text-white hover:bg-indigo-700 transition-colors duration-200">
                                                Tambah Produk Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links (Bottom) -->
                <div class="px-4 sm:px-6 py-4 bg-indigo-600 border border-transparent  hover:bg-indigo-700 transition-colors duration-200">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-4 sm:p-5 border w-80 sm:w-96 shadow-lg rounded-2xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-xs sm:text-sm text-gray-500 mb-4" id="deleteMessage"></p>
                <div class="flex justify-center space-x-2 sm:space-x-3">
                    <button id="cancelDelete" 
                            class="px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-300 text-gray-700 rounded-lg text-xs sm:text-sm hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </button>
                    <button id="confirmDelete" 
                            class="px-3 sm:px-4 py-1.5 sm:py-2 bg-red-600 text-white rounded-lg text-xs sm:text-sm hover:bg-red-700 transition-colors duration-200">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Custom pagination styles to match the theme */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.25rem;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .pagination a {
            background: linear-gradient(to right, #4f46e5, #a855f7);
            color: white;
            border: 1px solid transparent;
        }
        .pagination a:hover {
            background: linear-gradient(to right, #4338ca, #9333ea);
            transform: translateY(-1px);
        }
        .pagination .current, .pagination .disabled {
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
        .pagination .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
        @media (max-width: 640px) {
            .pagination a, .pagination span {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
        }
    </style>
    @endpush

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

        // Delete confirmation modal
        let deleteFormId = null;

        function showDeleteConfirmation(productId, productName) {
            deleteFormId = `delete-form-${productId}`;
            const modal = document.getElementById('deleteModal');
            const message = document.getElementById('deleteMessage');
            
            message.innerHTML = `Apakah Anda yakin ingin menghapus produk "<strong>${productName}</strong>"? Tindakan ini tidak dapat dibatalkan.`;
            document.getElementById('confirmDelete').style.display = 'inline-block';
            
            modal.classList.remove('hidden');
        }

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteFormId = null;
        });

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteFormId) {
                document.getElementById(deleteFormId).submit();
            }
        });

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                deleteFormId = null;
            }
        });
    </script>
    @endpush
</x-layout>