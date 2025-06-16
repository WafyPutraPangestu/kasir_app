@props(['active' => false, 'href' => '#', 'icon' => '', 'class' => ''])

@php
$baseClasses = 'rounded-full transition-all duration-200 transform hover:scale-105 relative';
$activeClasses = $active 
    ? $baseClasses . ' bg-green-100 text-green-600' 
    : $baseClasses . ' hover:bg-gray-100 text-gray-400 hover:text-gray-600';
$finalClasses = $activeClasses . ' ' . $class;
@endphp

<a href="{{ $href }}" 
   class="{{ $finalClasses }}"
   x-data="{ tooltip: false }"
   @props(['active' => false, 'href' => '#', 'icon' => '', 'routeName' => ''])

@php
$classes = $active 
    ? 'p-3 rounded-full bg-green-100 text-green-600 transition-all duration-200 transform hover:scale-105' 
    : 'p-3 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-all duration-200 transform hover:scale-105';
@endphp

<a href="{{ $href }}" 
   class="{{ $classes }}"
   x-data="{ tooltip: false }"
   @mouseenter="tooltip = true"
   @mouseleave="tooltip = false">
    
    {{ $slot }}
    
    <!-- Tooltip -->
    <div x-show="tooltip" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded whitespace-nowrap">
        @switch($icon)
            @case('dashboard')
                Dashboard
                @break
            @case('category')
                Kategori
                @break
            @case('products')
                Produk
                @break
            @case('orders')
                Pesanan
                @break
            @default
                {{ ucfirst($icon) }}
        @endswitch
        
        <!-- Tooltip Arrow -->
        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-800"></div>
    </div>
</a>