<x-layout>
    <div class="min-h-screen bg-gray-50" x-data="companyProfile()">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-br from-red-500 via-red-600 to-red-700 text-white overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <div class="mb-8">
                        <div
                            class="w-24 h-24 bg-white/20 rounded-full mx-auto mb-4 flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Dom Social Hub</h1>
                        <p class="text-xl md:text-2xl text-red-100 mb-8">Your Futuristic Coffee Experience</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 max-w-4xl mx-auto">
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold" x-text="stats.customers"></div>
                            <div class="text-sm md:text-base text-red-100">Pelanggan Hari Ini</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold">4.8★</div>
                            <div class="text-sm md:text-base text-red-100">Rating Google</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold">2019</div>
                            <div class="text-sm md:text-base text-red-100">Berdiri Sejak</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold"
                                :class="isOpen ? 'text-green-300' : 'text-red-300'" x-text="isOpen ? 'BUKA' : 'TUTUP'">
                            </div>
                            <div class="text-sm md:text-base text-red-100">Status</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full translate-y-16 -translate-x-16">
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- About Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang Dom Social Hub</h2>
                    <div class="prose prose-lg text-gray-700 space-y-4">
                        <p>
                            Dom Social Hub adalah coffee shop dengan konsep futuristik yang unik di Tangerang.
                            Dengan bangunan berbentuk dome yang eye-catching dan dominasi warna putih-merah,
                            kami menghadirkan pengalaman ngopi yang berbeda dan instagramable.
                        </p>
                        <p>
                            Tempat yang sempurna untuk hangout, meeting, foto-foto, atau sekadar menikmati
                            secangkir kopi berkualitas dalam suasana yang nyaman dan modern.
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Lokasi Strategis</p>
                                    <p class="text-sm text-gray-600">Dekat Stasiun Tangerang</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                                    </path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Instagramable</p>
                                    <p class="text-sm text-gray-600">Perfect for Content</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-6">Jam Operasional</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-700">
                            <span class="text-gray-300">Senin</span>
                            <span class="font-semibold">08:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-700">
                            <span class="text-gray-300">Selasa</span>
                            <span class="font-semibold">08:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-700">
                            <span class="text-gray-300">Rabu</span>
                            <span class="font-semibold">08:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-700">
                            <span class="text-gray-300">Kamis</span>
                            <span class="font-semibold">08:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-700">
                            <span class="text-gray-300">Jumat</span>
                            <span class="font-semibold text-yellow-400">08:00 - 24:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-700">
                            <span class="text-gray-300">Sabtu</span>
                            <span class="font-semibold text-yellow-400">08:00 - 24:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-300">Minggu</span>
                            <span class="font-semibold text-yellow-400">08:00 - 24:00</span>
                        </div>
                    </div>

                    <div
                        class="mt-6 p-4 bg-gradient-to-r from-red-500/20 to-red-600/20 rounded-lg border border-red-500/30">
                        <p class="text-center">
                            Status Sekarang:
                            <span class="font-bold" :class="isOpen ? 'text-green-400' : 'text-red-400'"
                                x-text="isOpen ? '🟢 BUKA' : '🔴 TUTUP'"></span>
                        </p>
                        <p class="text-center text-sm text-gray-300 mt-1" x-text="currentTime"></p>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Fasilitas & Keunggulan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Bangunan Dome Futuristik</h3>
                        <p class="text-gray-600">Desain unik berbentuk dome dengan dominasi warna putih-merah yang
                            eye-catching dan instagramable.</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Free Wi-Fi & AC</h3>
                        <p class="text-gray-600">Internet cepat dan AC yang nyaman untuk mendukung aktivitas kerja atau
                            belajar Anda.</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Indoor & Outdoor Area</h3>
                        <p class="text-gray-600">Area luas dengan zona indoor ber-AC dan outdoor dengan tribun beratap
                            untuk berbagai aktivitas.</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Colokan & Charging Area</h3>
                        <p class="text-gray-600">Banyak colokan tersedia di setiap sudut untuk mendukung kebutuhan
                            gadget Anda.</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Fasilitas Lengkap</h3>
                        <p class="text-gray-600">Toilet bersih, mushola, parkir luas, ruang VIP, dan layanan
                            pesan-antar tersedia.</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Event & Komunitas</h3>
                        <p class="text-gray-600">Sering jadi venue event komunitas seperti Urban Miles Tangerang dan
                            Bangor Fest.</p>
                    </div>

                </div>
            </div>

            <!-- Location & Contact -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-8 md:p-12 text-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-3xl font-bold mb-6">Lokasi & Kontak</h2>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-400 mr-4 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold mb-1">Alamat</p>
                                    <p class="text-gray-300">
                                        Jl. Kanjeng Dalem No.4 (Pertigaan RT 003/RW 005)<br>
                                        Sukarasa, Kec. Tangerang, Kota Tangerang<br>
                                        Banten 15111
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-400 mr-4 mt-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold mb-1">Akses</p>
                                    <p class="text-gray-300">Hanya beberapa menit berjalan kaki dari Stasiun Tangerang
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-400 mr-4 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.017 11.215c-.3-.3-.714-.458-1.142-.458s-.842.158-1.142.458L6.25 14.698a.5.5 0 00.708.708L10 12.364l3.042 3.042a.5.5 0 00.708-.708l-3.483-3.483z" />
                                    <path
                                        d="M13.25 2.25H10.75c-.69 0-1.25.56-1.25 1.25v17c0 .69.56 1.25 1.25 1.25h2.5c.69 0 1.25-.56 1.25-1.25v-17c0-.69-.56-1.25-1.25-1.25zm-2.5 17v-1.5h2.5v1.5h-2.5zm0-3v-10.5h2.5V16.25h-2.5z" />
                                </svg>
                                <div>
                                    <p class="font-semibold mb-1">Social Media</p>
                                    <p class="text-gray-300">@domsocialhub</p>
                                    <p class="text-sm text-gray-400">Follow untuk info promo & event terkini</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/10 rounded-xl p-6 backdrop-blur-sm">
                        <h3 class="text-xl font-bold mb-4">Kenapa Pilih Dom Social Hub?</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Desain futuristik & instagramable</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Lokasi strategis dekat stasiun</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Fasilitas lengkap & nyaman</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Perfect untuk hangout & meeting</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Aktif untuk event komunitas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function companyProfile() {
            return {
                currentTime: '',
                isOpen: true,
                stats: {
                    customers: 0
                },

                init() {
                    this.updateTime();
                    this.animateCustomers();
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);

                    this.checkOpenStatus();
                },

                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },

                checkOpenStatus() {
                    const now = new Date();
                    const hour = now.getHours();
                    const day = now.getDay();

                    // Senin-Kamis (1-4): 08:00-23:00
                    // Jumat-Minggu (5,6,0): 08:00-24:00
                    if (day >= 1 && day <= 4) {
                        this.isOpen = hour >= 8 && hour < 23;
                    } else {
                        this.isOpen = hour >= 8;
                    }
                },

                animateCustomers() {
                    let count = 0;
                    const target = 127;
                    const increment = target / 50;

                    const timer = setInterval(() => {
                        count += increment;
                        this.stats.customers = Math.floor(count);

                        if (count >= target) {
                            this.stats.customers = target;
                            clearInterval(timer);
                        }
                    }, 30);
                }
            }
        }
    </script>
</x-layout>
