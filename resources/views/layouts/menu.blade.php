<nav x-data="{ open: false, openSide: true }" class="sticky top-0 z-20 bg-white border-b border-cdsolec-green-light shadow-md">
  <div class="block bg-cdsolec-green-light h-3 md:h-6"></div>
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 md:h-32">
      <!-- Logo -->
      <div class="flex flex-shrink-0 items-center justify-center mr-10">
        <a href="{{ route('welcome') }}">
          <img src="{{ asset('img/logos/CD-SOLEC_Horizontal.png') }}" alt="CD-SOLEC" title="CD-SOLEC" class=" block md:hidden h-14" />
          <img src="{{ asset('img/logos/CD-SOLEC_Lema.png') }}" alt="CD-SOLEC" title="CD-SOLEC" class="hidden md:block h-28" />
        </a>
      </div>
      <!-- Navigation -->
      <div class="hidden w-full md:block">
        <!-- Navigation Links Sessions -->
        <div class="h-16 space-x-4 flex flex-shrink-0 justify-end">
          <div class="flex-auto">
            <form method="GET" action="{{ route('products') }}">
              @csrf
              <label for="search" class="sr-only">Buscar</label>
              <div class="my-2 relative rounded-md shadow-sm">
                <input type="text" name="search" id="search" value="{{ request('search', '') }}" class="block w-full pl-2 pr-12 text-sm rounded-md border border-cdsolec-green-dark focus:ring-gray-300 focus:border-gray-300" placeholder="Buscar Productos" />
                <div class="absolute inset-y-0 right-0 flex items-center">
                  <button type="submit" class="px-3 py-2 bg-cdsolec-green-dark rounded-r-md text-center text-white font-semibold uppercase tracking-wider hover:bg-cdsolec-green-light">
                    <i class="fas fa-fw mr-1 fa-search"></i> Buscar
                  </button>
                </div>
              </div>
            </form>
          </div>
          @if (session()->has('basket'))
          <x-jet-nav-link href="{{ route('basket.index') }}" :active="request()->routeIs('cart')" class="relative">
            <i class="fas fa-fw mr-1 fa-shopping-basket"></i> Presupuesto
            <div class="absolute animate-bounce bg-cdsolec-green-dark rounded -right-5 lg:top-2 lg:-right-2">
              <span class="px-2 text-white text-xs">
                {{ (session()->has('basket')) ? count(session('basket')) : 0 }}
              </span>
            </div>
          </x-jet-nav-link>
          @endif
          <x-jet-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart')" class="relative">
            <i class="fas fa-fw mr-1 fa-shopping-cart"></i> Compra
            <div class="absolute animate-bounce bg-cdsolec-green-dark rounded -right-5 lg:top-2 lg:-right-2">
              <span class="px-2 text-white text-xs">
                {{ (session()->has('cart')) ? count(session('cart')) : 0 }}
              </span>
            </div>
          </x-jet-nav-link>
          @auth
            <x-jet-nav-link href="{{ route('dashboard') }}">
              <i class="fas fa-fw mr-1 fa-user"></i> {{ Auth::user()->fullName }}
            </x-jet-nav-link>
          @endauth
          @guest
            <x-jet-nav-link href="{{ route('register') }}">
              <i class="fas fa-fw mr-1 fa-user"></i> Registro
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('login') }}">
              <i class="fas fa-fw mr-1 fa-lock"></i> Login
            </x-jet-nav-link>
          @endguest
        </div>
        <!-- Navigation Links Menú -->
        <div class="h-16 space-x-4 flex flex-shrink-0">
          <div class="hoverable flex flex-shrink-0">
            <x-jet-nav-link href="{{ route('products') }}" :active="request()->routeIs('products')">
              Productos
            </x-jet-nav-link>
            <div class="p-6 mega-menu shadow-xl bg-white overflow-x-auto h-96">
              <div class="container mx-auto w-full">
                <div x-data="tabsMegaMenu()">
                  <ul class="flex justify-start items-center">
                    <template x-for="(tab, index) in tabs" :key="index">
                      <li class="cursor-pointer py-2 px-4 text-cdsolec-green-dark border-b-4 border-gray-400" :class="activeTab===index ? 'text-cdsolec-green-dark border-cdsolec-green-dark' : ''" @click="activeTab = index" x-text="tab"></li>
                    </template>
                  </ul>
                  <div class="pt-4 border-t border-gray-400">
                    <div x-show="activeTab===0">
                      <div class="flex flex-col flex-wrap h-64 overflow-x-auto">
                        @if ($categories->isNotEmpty())
                          @foreach($categories as $item)
                          <a href="{{ route('products').'?category='.$item->rowid }}" class="block px-2 hover:bg-cdsolec-green-light">
                            <span class="fas fa-angle-right mr-1"></span>
                            {{ $item->label }}
                          </a>
                          @endforeach
                        @endif
                      </div>
                    </div>
                    <!-- <div x-show="activeTab===1">
                      <div class="flex flex-col flex-wrap h-64 overflow-x-auto">
                        @if ($sectors->isNotEmpty())
                          @foreach($sectors as $item)
                          <a href="{{ route('products').'?sector='.$item->rowid }}" class="block px-2 hover:bg-cdsolec-green-light">
                            <span class="fas fa-angle-right mr-1"></span>
                            {{ $item->label }}
                          </a>
                          @endforeach
                        @endif
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <x-jet-nav-link href="{{ route('solutions') }}" :active="request()->routeIs('solutions')">
            Soluciones
          </x-jet-nav-link>
          <x-jet-nav-link href="{{ route('brands') }}" :active="request()->routeIs('brands')">
            Fabricantes
          </x-jet-nav-link>
          <x-jet-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">
            Nosotros
          </x-jet-nav-link>
          <x-jet-nav-link href="{{ route('comments.create') }}" :active="request()->routeIs('comments.create')">
            Contacto
          </x-jet-nav-link>
          <x-jet-nav-link href="https://www.youtube.com/channel/UCixT72Hh42vepJ6hFX-rDLw" target="_blank">
            YouTube
          </x-jet-nav-link>
          <x-jet-nav-link href="{{ route('quotation.index') }}" :active="request()->routeIs('quotation.index')">
            Cotizar
          </x-jet-nav-link>
        </div>
      </div>
      <!-- Hamburger -->
      <div class="-mr-2 flex items-center md:hidden">
        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md hover:bg-cdsolec-green-dark focus:outline-none focus:bg-cdsolec-green-dark transition">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Responsive Navigation Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-cdsolec-green-dark">
    <!-- Navigation Links Left -->
    <div class="border-b border-cdsolec-green-dark">
      <div class="hoverable">
        <x-jet-responsive-nav-link href="#" :active="request()->routeIs('products')">
          Productos
        </x-jet-responsive-nav-link>
        <div class="z-10 p-6 mega-menu shadow-xl bg-white overflow-auto h-96">
          <div class="container mx-auto w-full">
            <div x-data="tabsMegaMenu()">
              <ul class="flex justify-start items-center">
                <template x-for="(tab, index) in tabs" :key="index">
                  <li class="cursor-pointer py-2 px-4 text-cdsolec-green-dark border-b-4 border-gray-400" :class="activeTab===index ? 'text-cdsolec-green-dark border-cdsolec-green-dark' : ''" @click="activeTab = index" x-text="tab"></li>
                </template>
              </ul>

              <div class="pt-4 border-t border-gray-400">
                <div x-show="activeTab===0">
                  <div class="grid gap-1 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @if ($categories->isNotEmpty())
                      @foreach($categories as $item)
                        <a href="{{ route('products').'?category='.$item->rowid }}" class="block px-2 hover:bg-cdsolec-green-light">
                          <span class="fas fa-angle-right mr-1"></span>
                          {{ $item->label }}
                        </a>
                      @endforeach
                    @endif
                  </div>
                </div>
                <div x-show="activeTab===1">
                  <div class="grid gap-1 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @if ($sectors->isNotEmpty())
                      @foreach($sectors as $item)
                        <a href="{{ route('products').'?category='.$item->rowid }}" class="block px-2 hover:bg-cdsolec-green-light">
                          <span class="fas fa-angle-right mr-1"></span>
                          {{ $item->label }}
                        </a>
                      @endforeach
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-jet-responsive-nav-link href="#">
        Soluciones
      </x-jet-responsive-nav-link>
      <x-jet-responsive-nav-link href="{{ route('brands') }}" :active="request()->routeIs('brands')">
        Fabricantes
      </x-jet-responsive-nav-link>
      <x-jet-responsive-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">
        Nosotros
      </x-jet-responsive-nav-link>
      <x-jet-responsive-nav-link href="{{ route('comments.create') }}" :active="request()->routeIs('comments.create')">
        Contacto
      </x-jet-responsive-nav-link>
      <x-jet-responsive-nav-link href="https://www.youtube.com/channel/UCixT72Hh42vepJ6hFX-rDLw" target="_blank">
        YouTube
      </x-jet-responsive-nav-link>
      <x-jet-responsive-nav-link href="{{ route('quotation.index') }}" :active="request()->routeIs('quotation.index')">
        Cotizar
      </x-jet-responsive-nav-link>
    </div>

    <!-- Navigation Links Right -->
    <div class="border-b border-cdsolec-green-dark">
      @if (session()->has('basket'))
      <x-jet-responsive-nav-link href="{{ route('basket.index') }}" :active="request()->routeIs('basket')">
        <i class="fas fa-fw mr-1 fa-shopping-basket"></i>
        <span class="relative">Presupuesto
          <div class="absolute animate-bounce bg-cdsolec-green-dark rounded bottom-0 -right-8">
            <span class="px-2 text-white text-xs">{{ (session()->has('basket')) ? count(session('basket')) : 0 }}</span>
          </div>
        </span>
      </x-jet-responsive-nav-link>
      @endif
      <x-jet-responsive-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart')">
        <i class="fas fa-fw mr-1 fa-shopping-cart"></i>
        <span class="relative">Compra
          <div class="absolute animate-bounce bg-cdsolec-green-dark rounded bottom-0 -right-8">
            <span class="px-2 text-white text-xs">{{ (session()->has('cart')) ? count(session('cart')) : 0 }}</span>
          </div>
        </span>
      </x-jet-responsive-nav-link>
      @auth
        <x-jet-responsive-nav-link href="{{ route('dashboard') }}">
          <i class="fas fa-fw mr-1 fa-user"></i> {{ Auth::user()->fullName }}
        </x-jet-responsive-nav-link>
      @endauth
      @guest
        <x-jet-responsive-nav-link href="{{ route('register') }}">
          <i class="fas fa-fw mr-1 fa-user"></i> Registro
        </x-jet-responsive-nav-link>
        <x-jet-responsive-nav-link href="{{ route('login') }}">
          <i class="fas fa-fw mr-1 fa-lock"></i> Login
        </x-jet-responsive-nav-link>
      @endguest
    </div>
  </div>
</nav>