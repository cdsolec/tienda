<nav class="bg-cdsolec-green-dark text-white shadow-xl z-10 md:w-1/4 lg:w-1/5">
  <!-- Logo -->
  <div class="hidden md:flex md:flex-shrink-0 md:justify-center bg-cdsolec-green-light py-3">
    <a href="{{ route('welcome') }}">
      <x-jet-application-mark class="block h-10 w-auto" />
    </a>
  </div>

  <div class="hidden md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded border border-white md:border-none px-4">
    <h6 class="md:min-w-full text-cdsolec-green-light text-xs uppercase font-bold block pt-1 pb-4 no-underline">
      Mis Compras
    </h6>
    <ul class="md:flex-col md:min-w-full flex flex-col list-none">
      <li class="items-center">
        <a href="{{ route('orders.index') }}" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2">
          <i class="fas fa-shopping-cart mr-2 text-sm"></i> Pedidos
        </a>
      </li>
      <li class="items-center">
        <a href="{{ route('budgets.index') }}" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2">
          <i class="fas fa-shopping-basket mr-2 text-sm"></i> Presupuestos
        </a>
      </li>
    </ul>
    <hr class="my-4 md:min-w-full" />
    @if (Auth::user()->admin)
      <h6 class="md:min-w-full text-cdsolec-green-light text-xs uppercase font-bold block pt-1 pb-4 no-underline">
        Plataforma
      </h6>
      <ul class="md:flex-col md:min-w-full flex flex-col list-none">
        <li class="items-center">
          <a href="{{ route('banners.index') }}" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2">
            <i class="fas fa-image mr-2 text-sm"></i> Banners
          </a>
        </li>
        <li class="items-center">
          <a href="{{ route('contents.index') }}" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2">
            <i class="fas fa-file mr-2 text-sm"></i> Contenido
          </a>
        </li>
        <li class="items-center">
          <a href="{{ route('comments.index') }}" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2">
            <i class="fas fa-envelope mr-2 text-sm"></i> Comentarios
          </a>
        </li>
      </ul>
      <hr class="my-4 md:min-w-full" />
    @endif

    @if (Auth::user()->admin)
      <h6 class="md:min-w-full text-cdsolec-green-light text-xs uppercase font-bold block pt-1 pb-4 no-underline">
        Configuración
      </h6>
      <ul class="md:flex-col md:min-w-full flex flex-col list-none">
        <li class="items-center">
          <a href="{{ route('settings.index') }}" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2">
            <i class="fas fa-cogs mr-2 text-sm"></i> Configuraciones
          </a>
        </li>
      </ul>
      <hr class="my-4 md:min-w-full" />
    @endif

    <h6 class="md:min-w-full text-cdsolec-green-light text-xs uppercase font-bold block pt-1 pb-4 no-underline">
      Cuenta de Usuario
    </h6>
    <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
      <li class="inline-flex">
        <a href="{{ route('profile.show') }}" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2">
          <i class="fas fa-user-circle mr-2 text-sm"></i> {{ __('session.Profile') }}
        </a>
      </li>
      <li class="inline-flex">
        <a href="#" class="w-full py-2 text-sm block no-underline font-semibold hover:bg-gray-300 hover:text-cdsolec-green-dark hover:pl-2" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2 text-sm"></i> {{ __('session.Logout') }}
        </a>
        <form id="sidebar-logout-form" method="POST" action="{{ route('logout') }}">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</nav>