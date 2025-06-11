<x-layout>
  {{-- Kita akan menggunakan Alpine.js untuk image preview --}}
  <div x-data="{ imagePreview: null }">
      <div class="py-12">
          <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-8 bg-white border-b border-gray-200">
                      <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Produk Baru</h2>

                      <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                          @csrf
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10">
                              <div class="space-y-6">
                                  <div>
                                      <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                      <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                      @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                  </div>
                                  <div>
                                      <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                      <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                          <option value="">Pilih Kategori</option>
                                          @foreach ($categories as $category)
                                              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                          @endforeach
                                      </select>
                                      @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                  </div>
                                  <div>
                                      <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                                      <input id="price" name="price" type="number" value="{{ old('price') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                      @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                  </div>
                                  <div>
                                      <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                                      <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                  </div>
                              </div>

                              <div class="space-y-6">
                                  <div>
                                      <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                                      <template x-if="imagePreview">
                                          <div class="mt-2">
                                              <img :src="imagePreview" class="h-48 w-full object-cover rounded-md">
                                          </div>
                                      </template>
                                      <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                           :class="{'hidden': imagePreview}">
                                          <div class="space-y-1 text-center">
                                              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                              <div class="flex text-sm text-gray-600"><label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500"><span>Upload file</span><input @change="imagePreview = URL.createObjectURL($event.target.files[0])" id="image" name="image" type="file" class="sr-only"></label></div>
                                              <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                          </div>
                                      </div>
                                      @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                  </div>
                                  <div class="space-y-4">
                                      <div class="flex items-start"><div class="flex items-center h-5"><input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"></div><div class="ml-3 text-sm"><label for="is_available" class="font-medium text-gray-700">Tersedia</label><p class="text-gray-500">Tandai jika produk ini ready stock.</p></div></div>
                                      <div class="flex items-start"><div class="flex items-center h-5"><input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"></div><div class="ml-3 text-sm"><label for="is_active" class="font-medium text-gray-700">Aktif</label><p class="text-gray-500">Tandai untuk menampilkan produk ini di menu.</p></div></div> {{-- INI YANG DIPERBAIKI --}}
                                  </div>
                              </div>
                          </div>
                          <div class="mt-8 pt-5 border-t border-gray-200"><div class="flex justify-end"><a href="{{ route('admin.produk.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a><button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan Produk</button></div></div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-layout>