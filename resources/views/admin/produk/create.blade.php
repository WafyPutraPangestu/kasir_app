<x-layout>
    <div x-data="productForm()" x-init="init()">
        <!-- Toast Notification -->
        <div x-show="notification.show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-4 flex items-center space-x-3"
                 :class="notification.type === 'success' ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50'">
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <template x-if="notification.type === 'success'">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </template>
                    <template x-if="notification.type === 'error'">
                        <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </template>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium" :class="notification.type === 'success' ? 'text-green-800' : 'text-red-800'" x-text="notification.message"></p>
                </div>
                <button @click="hideNotification()" class="flex-shrink-0 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
  
        <!-- Loading Overlay -->
        <div x-show="loading" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-40" style="display: none;">
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">Menyimpan produk...</span>
                    </div>
                </div>
            </div>
        </div>
  
        <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Tambah Produk Baru</h1>
                            <p class="text-gray-600 mt-1">Lengkapi form di bawah untuk menambahkan produk baru ke toko Anda</p>
                        </div>
                    </div>
                    <!-- Breadcrumb -->
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-4">
                            <li><a href="{{ route('admin.produk.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">Produk</a></li>
                            <li><svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                            <li><span class="text-gray-500">Tambah Baru</span></li>
                        </ol>
                    </nav>
                </div>
  
                <!-- Main Form Card -->
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                    <div class="px-8 py-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Form Produk
                        </h2>
                    </div>
  
                    <form @submit.prevent="submitForm" enctype="multipart/form-data" class="p-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Left Column - Basic Info -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Product Name -->
                                <div class="group">
                                    <label for="name" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Nama Produk
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input id="name" 
                                           name="name" 
                                           type="text" 
                                           x-model="form.name"
                                           :class="errors.name ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                                           class="w-full px-4 py-3 rounded-xl border shadow-sm transition-all duration-200 focus:ring-2 focus:ring-opacity-20 group-hover:shadow-md"
                                           placeholder="Masukkan nama produk...">
                                    <p x-show="errors.name" x-text="errors.name" class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </p>
                                </div>
  
                                <!-- Category & Price Row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Category -->
                                    <div class="group">
                                        <label for="category_id" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            Kategori
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <select id="category_id" 
                                                name="category_id" 
                                                x-model="form.category_id"
                                                :class="errors.category_id ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                                                class="w-full px-4 py-3 rounded-xl border shadow-sm transition-all duration-200 focus:ring-2 focus:ring-opacity-20 group-hover:shadow-md">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <p x-show="errors.category_id" x-text="errors.category_id" class="text-red-500 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </p>
                                    </div>
  
                                    <!-- Price -->
                                    <div class="group">
                                        <label for="price" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            Harga
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                            <input id="price" 
                                                   name="price" 
                                                   type="number" 
                                                   x-model="form.price"
                                                   :class="errors.price ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                                                   class="w-full pl-12 pr-4 py-3 rounded-xl border shadow-sm transition-all duration-200 focus:ring-2 focus:ring-opacity-20 group-hover:shadow-md"
                                                   placeholder="0">
                                        </div>
                                        <p x-show="errors.price" x-text="errors.price" class="text-red-500 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </p>
                                    </div>
                                </div>
  
                                <!-- Description -->
                                <div class="group">
                                    <label for="description" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                        Deskripsi Produk
                                        <span class="text-gray-400 text-xs ml-2">(Opsional)</span>
                                    </label>
                                    <textarea id="description" 
                                              name="description" 
                                              rows="4" 
                                              x-model="form.description"
                                              class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-20 focus:border-indigo-500 group-hover:shadow-md resize-none"
                                              placeholder="Masukkan deskripsi produk (opsional)..."></textarea>
                                </div>
                            </div>
  
                            <!-- Right Column - Image & Settings -->
                            <div class="space-y-6">
                                <!-- Image Upload -->
                                <div class="bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-200 hover:border-indigo-300 transition-colors">
                                    <label class="block text-sm font-semibold text-gray-800 mb-4 flex items-center">
                                        <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Gambar Produk
                                    </label>
                                    
                                    <!-- Image Preview -->
                                    <template x-if="imagePreview">
                                        <div class="relative mb-4 group">
                                            <img :src="imagePreview" class="w-full h-48 object-cover rounded-xl shadow-lg">
                                            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                                <button @click="removeImage()" type="button" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
  
                                    <!-- Upload Area -->
                                    <div :class="{'hidden': imagePreview}" class="text-center">
                                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <div class="space-y-2">
                                            <label for="image" class="cursor-pointer">
                                                <span class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    Upload Gambar
                                                </span>
                                                <input @change="handleImageUpload($event)" id="image" name="image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB</p>
                                        </div>
                                    </div>
                                    <p x-show="errors.image" x-text="errors.image" class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </p>
                                </div>
  
                                <!-- Product Settings -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border border-blue-100">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Pengaturan Produk
                                    </h3>
                                    <div class="space-y-4">
                                        <!-- Available Toggle -->
                                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200 hover:shadow-sm transition-shadow">
                                            <div class="flex items-start space-x-3">
                                                <div class="mt-1">
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <label for="is_available" class="font-medium text-gray-700 cursor-pointer">Tersedia</label>
                                                    <p class="text-sm text-gray-500">Produk ini ready stock dan bisa dipesan</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input id="is_available" name="is_available" type="checkbox" x-model="form.is_available" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            </label>
                                        </div>
  
                                        <!-- Active Toggle -->
                                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200 hover:shadow-sm transition-shadow">
                                            <div class="flex items-start space-x-3">
                                                <div class="mt-1">
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <label for="is_active" class="font-medium text-gray-700 cursor-pointer">Aktif</label>
                                                    <p class="text-sm text-gray-500">Tampilkan produk ini di menu utama</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input id="is_active" name="is_active" type="checkbox" x-model="form.is_active" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
  
                        <!-- Action Buttons -->
                        <div class="mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('admin.produk.index') }}" 
                               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    :disabled="loading"
                                    :class="loading ? 'bg-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700'"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent rounded-xl text-sm font-medium text-white shadow-lg transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105">
                                <template x-if="!loading">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </template>
                                <template x-if="loading">
                                    <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <span x-text="loading ? 'Menyimpan...' : 'Simpan Produk'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <script>
        function productForm() {
            return {
                loading: false,
                imagePreview: null,
                form: {
                    name: '{{ old("name") }}',
                    category_id: '{{ old("category_id") }}',
                    price: '{{ old("price") }}',
                    description: '{{ old("description") }}',
                    is_available: {{ old('is_available', 'true') ? 'true' : 'false' }},
                    is_active: {{ old('is_active', 'true') ? 'true' : 'false' }}
                },
                errors: {},
                notification: {
                    show: false,
                    type: 'success',
                    message: ''
                },
  
                init() {
                    // Check for Laravel validation errors
                    @if($errors->any())
                        this.errors = {
                            @foreach($errors->all() as $field => $error)
                                '{{ $field }}': '{{ $error }}',
                            @endforeach
                        };
                        this.showNotification('error', 'Terdapat kesalahan dalam form. Silakan periksa kembali.');
                    @endif
  
                    // Check for success message
                    @if(session('success'))
                        this.showNotification('success', '{{ session("success") }}');
                    @endif
                },
  
                handleImageUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Validate file size (2MB)
                        if (file.size > 2048 * 1024) {
                            this.showNotification('error', 'Ukuran file terlalu besar. Maksimal 2MB.');
                            event.target.value = '';
                            return;
                        }
  
                        // Validate file type
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                        if (!allowedTypes.includes(file.type)) {
                            this.showNotification('error', 'Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.');
                            event.target.value = '';
                            return;
                        }
  
                        // Create preview
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
  
                removeImage() {
                    this.imagePreview = null;
                    document.getElementById('image').value = '';
                },
  
                async submitForm(event) {
                    this.loading = true;
                    this.errors = {};
  
                    try {
                        // Create FormData
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('input[name="_token"]').value);
                        formData.append('name', this.form.name);
                        formData.append('category_id', this.form.category_id);
                        formData.append('price', this.form.price);
                        formData.append('description', this.form.description);
                        formData.append('is_available', this.form.is_available ? '1' : '0');
                        formData.append('is_active', this.form.is_active ? '1' : '0');
  
                        // Add image if exists
                        const imageInput = document.getElementById('image');
                        if (imageInput.files[0]) {
                            formData.append('image', imageInput.files[0]);
                        }
  
                        // Submit form
                        const response = await fetch('{{ route("admin.produk.store") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
  
                        if (response.ok) {
                            this.showNotification('success', 'Produk berhasil ditambahkan!');
                            
                            // Redirect after short delay
                            setTimeout(() => {
                                window.location.href = '{{ route("admin.produk.index") }}';
                            }, 1500);
                        } else {
                            const errorData = await response.json();
                            if (errorData.errors) {
                                this.errors = errorData.errors;
                            }
                            this.showNotification('error', 'Terjadi kesalahan. Silakan periksa form kembali.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showNotification('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
                    } finally {
                        this.loading = false;
                    }
                },
  
                showNotification(type, message) {
                    this.notification = {
                        show: true,
                        type: type,
                        message: message
                    };
  
                    // Auto hide after 5 seconds
                    setTimeout(() => {
                        this.hideNotification();
                    }, 5000);
                },
  
                hideNotification() {
                    this.notification.show = false;
                }
            }
        }
    </script>
  </x-layout>