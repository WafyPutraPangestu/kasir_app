<x-layout>
  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
          {{-- Ganti dengan logo Anda jika ada, atau biarkan ikon ini --}}
          <svg class="mx-auto h-12 w-auto text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.658-.463 1.243-1.119 1.243H5.502c-.656 0-1.189-.585-1.119-1.243l1.263-12A1.125 1.125 0 016.63 9.375h10.74c.54 0 1.023.326 1.186.833z" />
          </svg>

          <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
              Selamat Datang Kembali
          </h2>
          <p class="mt-2 text-center text-sm text-gray-600">
              Silakan masuk untuk melanjutkan
          </p>
      </div>

      <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
          <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
              <form class="space-y-6" action="{{ route('login') }}" method="POST">
                  @csrf
                  
                  <div>
                      <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                          Alamat Email
                      </label>
                      <div class="mt-2">
                          <input id="email" name="email" type="email" autocomplete="email" required
                                 class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      </div>
                  </div>

                  <div>
                      <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                          Password
                      </label>
                      <div class="mt-2">
                          <input id="password" name="password" type="password" autocomplete="current-password" required
                                 class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                      </div>
                  </div>

                  <div class="flex items-center justify-between">
                      <div class="flex items-center">
                          <input id="remember" name="remember" type="checkbox"
                                 class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                          <label for="remember" class="ml-2 block text-sm text-gray-900">
                              Ingat Saya
                          </label>
                      </div>

                      <div class="text-sm">
                          <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                              Lupa password?
                          </a>
                      </div>
                  </div>

                  <div>
                      <button type="submit"
                              class="flex w-full justify-center rounded-md bg-indigo-600 py-2 px-4 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                          Login
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</x-layout>