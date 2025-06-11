<x-layout>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-bold text-gray-800">Manajemen Produk</h2>
              <a href="{{ route('admin.produk.create') }}"
                 class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Tambah Produk
              </a>
          </div>

          @if (session('success'))
              <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                  <p>{{ session('success') }}</p>
              </div>
          @endif

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                          <tr>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                              <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @forelse ($products as $product)
                              <tr>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                      <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80' }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-md">
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $product->name }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category->name }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                          {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                      </span>
                                  </td>
                                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                      <a href="{{ route('admin.produk.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                      <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                      </form>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada produk.</td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</x-layout>