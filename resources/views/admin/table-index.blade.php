<x-layout>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-bold">Daftar Meja</h2>
              <a href="{{ route('admin.tables.create') }}"
                 class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Tambah Meja Baru
              </a>
          </div>

          {{-- Pesan Sukses --}}
          @if (session('success'))
              <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                  <span class="block sm:inline">{{ session('success') }}</span>
              </div>
          @endif

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                      @forelse ($tables as $table)
                          <div class="border rounded-lg p-4 flex flex-col items-center text-center">
                              <h3 class="text-lg font-semibold mb-2">{{ $table->name }}</h3>
                              <div class="mb-2">
                                  {{-- Generate QR Code di sini --}}
                                  {!! QrCode::size(150)->generate(route('customer.menu', $table->qr_token)) !!}
                              </div>
                              <p class="text-xs text-gray-500">Status: {{ ucfirst($table->status) }}</p>
                              {{-- Tambahkan tombol edit/delete di sini jika perlu --}}
                          </div>
                      @empty
                          <p class="col-span-full text-center text-gray-500">
                              Belum ada meja yang ditambahkan.
                          </p>
                      @endforelse
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-layout>