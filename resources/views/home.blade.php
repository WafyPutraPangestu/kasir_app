<x-layout>
    <style>
        .parallax-container {
            position: relative;
            overflow: hidden;
        }
        
        .parallax-image {
            transition: transform 0.1s ease-out;
        }
        
        .parallax-text {
            transition: transform 0.1s ease-out;
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .products-section {
            height: 500vh;
            position: relative;
        }

        .product-sticky-container {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .product-slide.active {
            opacity: 1;
            transform: translateX(0);
        }

        .product-slide.prev {
            opacity: 0;
            transform: translateX(-100%);
        }

        .product-content {
            display: flex;
            align-items: center;
            gap: 4rem;
            max-width: 1200px;
            padding: 2rem;
        }

        .product-slide:nth-child(even) .product-content {
            flex-direction: row-reverse;
        }

        .product-image {
            flex: 1;
            max-width: 500px;
        }

        .product-image img {
            width: 100%;
            height: auto;
            transition: transform 0.5s ease;
        }

        .product-slide.active .product-image img {
            animation: zoomIn 0.8s ease-out;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .product-info {
            flex: 1;
            text-align: center;
        }

        .product-slide:nth-child(even) .product-info {
            text-align: center;
        }

        @media (max-width: 768px) {
            .product-content {
                flex-direction: column !important;
                gap: 2rem;
            }
            
            .product-info {
                text-align: center !important;
            }
        }
    </style>

    <div class="relative parallax-container" id="hero-section">
        <div class="parallax-bg"></div>
        
        <header class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 py-8 px-4">
            <div class="flex flex-col space-y-4 justify-center items-start md:pl-12 fade-in parallax-text">
                <h1 class="font-extrabold text-5xl">
                    Twinly <strong class="text-green-500">Studio</strong>
                </h1>
                <p class="text-lg text-gray-600">Your Perfect Coffee Partner</p>
            </div>
        
            <div class="flex justify-center items-center parallax-image">
                <img src="{{ asset('storage/asset/coffee-hero-section.png') }}" 
                     class="w-full max-w-sm md:max-w-md"
                     alt="Coffee Hero">
            </div>
        </header>
    </div>

    <div class="py-12 bg-white">
        <div class="fade-in mb-8">
            <h1 class="text-5xl font-bold text-center mb-4">
                Welcome to Twinly Studio<br>
                <strong class="text-green-500">Coffee Shop Products</strong>
            </h1>
            <p class="text-center text-gray-600 text-lg">Scroll to explore our menu</p>
        </div>
    </div>

    <div class="products-section bg-gradient-to-b from-white to-gray-50">
        <div class="product-sticky-container">
            <!-- Special Combo -->
            <div class="product-slide" data-index="0">
                <div class="product-content">
                    <div class="product-image">
                        <img src="{{ asset('storage/asset/special-combo.png') }}" alt="Special Combo">
                    </div>
                    <div class="product-info">
                        <h2 class="text-5xl font-bold text-gray-800 mb-4">Special Combo</h2>
                        <p class="text-2xl text-gray-600 mb-6">Coffee + Croissant + Cookies</p>
                        <p class="text-6xl font-bold text-green-500 mb-4">Rp 25.000</p>
                        <span class="inline-block bg-red-500 text-white px-6 py-3 rounded-full text-lg">Hot Deal!</span>
                    </div>
                </div>
            </div>

            <!-- Hot Beverages -->
            <div class="product-slide" data-index="1">
                <div class="product-content">
                    <div class="product-image">
                        <img src="{{ asset('storage/asset/hot-beverages.png') }}" alt="Hot Beverages">
                    </div>
                    <div class="product-info">
                        <h2 class="text-5xl font-bold text-gray-800 mb-4">Hot Beverages</h2>
                        <p class="text-2xl text-gray-600 mb-6">Espresso, Cappuccino, Latte</p>
                        <p class="text-6xl font-bold text-green-500 mb-4">Rp 18.000</p>
                        <span class="text-gray-500 text-lg">starting from</span>
                    </div>
                </div>
            </div>

            <!-- Desserts -->
            <div class="product-slide" data-index="2">
                <div class="product-content">
                    <div class="product-image">
                        <img src="{{ asset('storage/asset/desserts.png') }}" alt="Desserts">
                    </div>
                    <div class="product-info">
                        <h2 class="text-5xl font-bold text-gray-800 mb-4">Sweet Desserts</h2>
                        <p class="text-2xl text-gray-600 mb-6">Cakes, Brownies, Pastries</p>
                        <p class="text-6xl font-bold text-green-500 mb-4">Rp 22.000</p>
                        <span class="text-gray-500 text-lg">starting from</span>
                    </div>
                </div>
            </div>

            <!-- Burger & French Fries -->
            <div class="product-slide" data-index="3">
                <div class="product-content">
                    <div class="product-image">
                        <img src="{{ asset('storage/asset/burger-frenchfries.png') }}" alt="Burger & French Fries">
                    </div>
                    <div class="product-info">
                        <h2 class="text-5xl font-bold text-gray-800 mb-4">Burger & Fries</h2>
                        <p class="text-2xl text-gray-600 mb-6">Beef Burger with Crispy Fries</p>
                        <p class="text-6xl font-bold text-green-500 mb-4">Rp 35.000</p>
                        <span class="inline-block bg-orange-500 text-white px-6 py-3 rounded-full text-lg">Popular</span>
                    </div>
                </div>
            </div>

            <!-- Cold Beverages -->
            <div class="product-slide" data-index="4">
                <div class="product-content">
                    <div class="product-image">
                        <img src="{{ asset('storage/asset/cold-beverages.png') }}" alt="Cold Beverages">
                    </div>
                    <div class="product-info">
                        <h2 class="text-5xl font-bold text-gray-800 mb-4">Cold Beverages</h2>
                        <p class="text-2xl text-gray-600 mb-6">Iced Coffee, Frappe, Smoothies</p>
                        <p class="text-6xl font-bold text-green-500 mb-4">Rp 20.000</p>
                        <span class="text-gray-500 text-lg">starting from</span>
                    </div>
                </div>
            </div>

            <!-- Refreshment -->
            <div class="product-slide" data-index="5">
                <div class="product-content">
                    <div class="product-image">
                        <img src="{{ asset('storage/asset/refreshment.png') }}" alt="Refreshment">
                    </div>
                    <div class="product-info">
                        <h2 class="text-5xl font-bold text-gray-800 mb-4">Fresh Refreshments</h2>
                        <p class="text-2xl text-gray-600 mb-6">Fruit Juices, Lemonade, Tea</p>
                        <p class="text-6xl font-bold text-green-500 mb-4">Rp 15.000</p>
                        <span class="text-gray-500 text-lg">starting from</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-20 bg-gray-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800">About Me</h2>
            <p class="text-gray-600 mt-4">Experience the perfect blend of taste and ambiance</p>
        </div>
    </div>

    <script>
        // Parallax Effect on Hero Section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroSection = document.getElementById('hero-section');
            
            if (heroSection) {
                const parallaxBg = heroSection.querySelector('.parallax-bg');
                const parallaxImage = heroSection.querySelector('.parallax-image');
                const parallaxText = heroSection.querySelector('.parallax-text');
                
                if (parallaxBg) {
                    parallaxBg.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
                
                if (parallaxImage) {
                    parallaxImage.style.transform = `translateY(${scrolled * 0.3}px)`;
                }
                
                if (parallaxText) {
                    parallaxText.style.transform = `translateY(${scrolled * 0.3}px)`;
                }
            }
        });

        // Product Slides Scroll-triggered Animation
        const productsSection = document.querySelector('.products-section');
        const slides = document.querySelectorAll('.product-slide');
        const totalSlides = slides.length;

        window.addEventListener('scroll', () => {
            if (!productsSection) return;

            const sectionTop = productsSection.offsetTop;
            const sectionHeight = productsSection.offsetHeight;
            const scrollPos = window.pageYOffset;
            
            // Calculate which slide should be active
            const scrollInSection = scrollPos - sectionTop;
            const slideHeight = sectionHeight / totalSlides;
            let activeIndex = Math.floor(scrollInSection / slideHeight);
            
            // Clamp between 0 and totalSlides-1
            activeIndex = Math.max(0, Math.min(activeIndex, totalSlides - 1));

            // Update slides
            slides.forEach((slide, index) => {
                slide.classList.remove('active', 'prev');
                
                if (index === activeIndex) {
                    slide.classList.add('active');
                } else if (index < activeIndex) {
                    slide.classList.add('prev');
                }
            });
        });

        // Fade In Animation for other elements
        const fadeObserverOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, fadeObserverOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            fadeObserver.observe(el);
        });

        // Initialize first slide
        if (slides.length > 0) {
            slides[0].classList.add('active');
        }
    </script>
</x-layout>