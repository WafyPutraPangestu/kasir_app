<x-layout>
  <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-8 bg-white border-b border-gray-200">
                  <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Produk: {{ $product->name }}</h2>

                  <form method="POST" action="{{ route('admin.produk.update', $product->id) }}" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <!-- Kolom Kiri -->
                          <div class="space-y-6">
                              <div>
                                  <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                  <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                  @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                              </div>
                              <div>
                                  <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                  <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                      @foreach ($categories as $category)
                                          <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                      @endforeach
                                  </select>
                                  @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                              </div>
                              <div>
                                  <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                                  <input id="price" name="price" type="number" value="{{ old('price', $product->price) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                  @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                              </div>
                              <div>
                                  <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                  <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $product->description) }}</textarea>
                              </div>
                          </div>

                          <!-- Kolom Kanan -->
                          <div class="space-y-6">
                              <div>
                                  <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                                  @if ($product->image)
                                      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-4">
                                  @endif
                                  <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                  <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                                  @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                              </div>
                              <div class="space-y-4">
                                  <div class="flex items-start"><div class="flex items-center h-5"><input id="is_available" name="is_available" type="checkbox" {{ old('is_available', $product->is_available) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded"></div><div class="ml-3 text-sm"><label for="is_available" class="font-medium text-gray-700">Tersedia</label></div></div>
                                  <div class="flex items-start"><div class="flex items-center h-5"><input id="is_active" name="is_active" type="checkbox" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded"></div><div class="ml-3 text-sm"><label for="is_active" class="font-medium text-gray-700">Aktif</for></label></div></div>
                              </div>
                          </div>
                      </div>

                      <div class="mt-8 pt-5 border-t border-gray-200">
                          <div class="flex justify-end">
                              <a href="{{ route('admin.produk.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                              <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan Perubahan</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-layout>