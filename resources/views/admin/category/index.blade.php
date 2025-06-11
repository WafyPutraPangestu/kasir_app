<x-layout>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-bold text-gray-800">Manajemen Kategori</h2>
              {{-- Tombol ini sekarang mengarah ke halaman create --}}
              <a href="{{ route('admin.category.create') }}"
                 class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none">
                  Tambah Kategori
              </a>
          </div>

          @if (session('success'))
              <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                  <p>{{ session('success') }}</p>
              </div>
          @endif
          @if (session('error'))
              <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                  <p>{{ session('error') }}</p>
              </div>
          @endif

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                          <tr>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                              <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @forelse ($categories as $category)
                              <tr>
                                  <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $category->name }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->slug }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->products_count }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                      {{-- Tombol Edit menjadi link biasa --}}
                                      <a href="{{ route('admin.category.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                      
                                      <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin ingin menghapus? Kategori yang memiliki produk tidak dapat dihapus.');">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                      </form>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada kategori.</td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</x-layout>