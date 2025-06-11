<x-layout>
  <div class="bg-white">
      <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="text-center">
              <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Menu Pilihan</h1>
              <p class="mt-4 max-w-xl mx-auto text-lg text-gray-500">
                  Pesanan untuk <span class="font-bold text-indigo-600">Meja {{ $table->name }}</span>
              </p>
          </div>

          @forelse ($categories as $category)
              @if ($category->products->isNotEmpty())
                  <div class="mt-12">
                      <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                      
                      <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                          
                          @foreach ($category->products as $product)
                              <div class="group relative flex flex-col">
                                  <div class="w-full min-h-60 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-60 lg:aspect-none">
                                      <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" 
                                           alt="{{ $product->name }}" 
                                           class="w-full h-full object-center object-cover">
                                  </div>
                                  <div class="mt-4 flex flex-col flex-grow">
                                      <div>
                                          <h3 class="text-sm text-gray-700">
                                              <a href="#">
                                                  <span aria-hidden="true" class="absolute inset-0"></span>
                                                  {{ $product->name }}
                                              </a>
                                          </h3>
                                          <p class="mt-1 text-sm text-gray-500">{{ $product->description ?? 'Deskripsi tidak tersedia.' }}</p>
                                      </div>
                                      <p class="text-lg font-medium text-gray-900 mt-2">
                                          Rp {{ number_format($product->price, 0, ',', '.') }}
                                      </p>
                                  </div>
                                  <div class="mt-4">
                                      <button type="button" 
                                              class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                          Pesan
                                      </button>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              @endif
          @empty
              <p class="mt-12 text-center text-gray-500">Menu belum tersedia saat ini.</p>
          @endforelse
      </div>
  </div>
</x-layout>
