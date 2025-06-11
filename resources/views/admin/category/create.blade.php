<x-layout>
  <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-8 bg-white border-b border-gray-200">
                  <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Kategori Baru</h2>

                  <form method="POST" action="{{ route('admin.category.store') }}">
                      @csrf
                      <div>
                          <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                          <div class="mt-1">
                              <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                     class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                          </div>
                          @error('name')
                              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                          @enderror
                      </div>

                      <div class="mt-6 pt-5 border-t border-gray-200">
                          <div class="flex justify-end">
                              <a href="{{ route('admin.category.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                                  Batal
                              </a>
                              <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                  Simpan Kategori
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-layout>