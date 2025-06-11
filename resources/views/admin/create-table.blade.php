<x-layout>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <h2 class="text-2xl font-bold mb-6">Tambah Meja Baru</h2>

                  <form method="POST" action="{{ route('admin.store-table') }}">
                      @csrf

                      <!-- Nama Meja -->
                      <div>
                          <label for="name" class="block text-sm font-medium text-gray-700">
                              Nama Meja (Contoh: Meja 01, Pojok Kiri)
                          </label>
                          <div class="mt-1">
                              <input id="name" name="name" type="text" required autofocus
                                     class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                     value="{{ old('name') }}">
                          </div>
                          @error('name')
                              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                          @enderror
                      </div>

                      <!-- Tombol Submit -->
                      <div class="mt-6">
                          <button type="submit"
                                  class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                              Simpan Meja
                          </button>
                          <a href="{{ route('admin.tables.index') }}" class="ml-4 text-sm text-gray-600 hover:text-gray-900">
                              Batal
                          </a>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-layout>