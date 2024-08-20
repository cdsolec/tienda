<footer class="gradient">
  <svg class="wave-top" viewBox="0 0 1439 147" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
      <g transform="translate(-1.000000, -14.000000)" fill-rule="nonzero">
        <g class="wave" fill="#f8fafc">
          <path d="M1440,84 C1383.555,64.3 1342.555,51.3 1317,45 C1259.5,30.824 1206.707,25.526 1169,22 C1129.711,18.326 1044.426,18.475 980,22 C954.25,23.409 922.25,26.742 884,32 C845.122,37.787 818.455,42.121 804,45 C776.833,50.41 728.136,61.77 713,65 C660.023,76.309 621.544,87.729 584,94 C517.525,105.104 484.525,106.438 429,108 C379.49,106.484 342.823,104.484 319,102 C278.571,97.783 231.737,88.736 205,84 C154.629,75.076 86.296,57.743 0,32 L0,0 L1440,0 L1440,84 Z">
          </path>
        </g>
        <g transform="translate(1.000000, 15.000000)" fill="#FFFFFF">
          <g transform="translate(719.500000, 68.500000) rotate(-180.000000) translate(-719.500000, -68.500000) ">
            <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
            <path d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z" opacity="0.100000001"></path>
            <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" opacity="0.200000003"></path>
          </g>
        </g>
      </g>
    </g>
  </svg>
  <div class="container mx-auto px-4 py-2">
    <h1 class="w-full font-bold leading-tight text-4xl text-center text-white">
      Somos Soluciones en Electricidad y Comunicación
    </h1>
    <div class="w-full mb-4">
      <div class="h-1 mx-auto bg-white w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
    </div>
    <h3 class="leading-tight text-2xl text-center">
      Estamos aquí para servirte
    </h3>
    <div class="mt-4 grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
      <div>
        <div class="uppercase text-2xl border-l-8 border-white">
          <h3 class="ml-2">Acceso</h3>
        </div>
        <hr class="my-2">
        <div class="flex flex-wrap text-sm">
          <div class="w-1/2">
            <ul>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('welcome') }}">Inicio</a>
              </li>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('products') }}">Productos</a>
              </li>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('solutions') }}">Soluciones</a>
              </li>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('about') }}">Nosotros</a>
              </li>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('comments.create') }}">Contacto</a>
              </li>
            </ul>
          </div>
          <div class="w-1/2">
            <ul>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('cart.index') }}">Compra (0)</a>
              </li>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('conditions') }}">Condiciones de Ventas y Garantías</a>
              </li>
              <li>
                <i class="fas fa-angle-right mr-1"></i>
                <a href="{{ route('policy') }}">Política Comercial, Devoluciones y Delivery</a>
              </li>
              @guest
                <li>
                  <i class="fas fa-angle-right mr-1"></i>
                  <a href="{{ route('register') }}">Registro</a>
                </li>
                <li>
                  <i class="fas fa-angle-right mr-1"></i>
                  <a href="{{ route('login') }}">Login</a>
                </li>
              @endguest
            </ul>
          </div>
        </div>
      </div>
      <div>
        <div class="uppercase text-2xl border-l-8 border-white">
          <h3 class="ml-2">Síguenos</h3>
        </div>
        <hr class="my-2">
        <ul class="mt-2 flex flex-row list-none items-center">
          <li>
            <a href="https://wa.me/+584128915299" target="_blank" class="px-3 py-4 md:py-2 flex items-center text-3xl uppercase font-bold">
              <i class="fab fa-whatsapp leading-lg"></i>
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com/cdsolec/" target="_blank" class="px-3 py-4 md:py-2 flex items-center text-3xl uppercase font-bold">
              <i class="fab fa-instagram leading-lg"></i>
            </a>
          </li>
          <li>
            <a href="https://www.youtube.com/channel/UCixT72Hh42vepJ6hFX-rDLw" target="_blank" class="px-3 py-4 md:py-2 flex items-center text-3xl uppercase font-bold">
              <i class="fab fa-youtube leading-lg"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="md:col-span-2">
        <div class="uppercase text-2xl border-l-8 border-white">
          <h3 class="ml-2">Contáctanos</h3>
        </div>
        <hr class="my-2">
        <div class="grid gad-4 grid-cols-1 sm:grid-cols-2">
          <div class="text-sm">
            <p>
              <a href="tel:+584128915299" class="mr-4"><i class="fas fa-fw fa-phone mr-2"></i> (0412)-891.52.99</a> 
              <a href="tel:+584243158430">(0424)-315.84.30</a>
            </p>
            <p>
              <a href="https://wa.me/+584128915299" target="_blank" class="mr-4"><i class="fab fa-fw fa-whatsapp mr-2"></i> (0412)-891.52.99</a>
              <a href="https://wa.me/+584243158430" target="_blank">(0424)-315.84.30</a>
            </p>
            <p><a href="mailto:ventas@cd-solec.com"><i class="fas fa-fw fa-envelope mr-2"></i> ventas@cd-solec.com</a></p>
          </div>
          <div>
            <form method="GET" action="{{ route('comments.create') }}">
              @csrf
              <label for="email" class="sr-only">Email</label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                  <i class="fas fa-envelope"></i>
                </div>
                <input type="email" name="email" id="email" class="block w-full pl-9 pr-12 text-sm rounded-md border border-cdsolec-green-dark focus:ring-gray-300 focus:border-gray-300" placeholder="Email" />
                <div class="absolute inset-y-0 right-0 flex items-center">
                  <button type="submit" class="px-3 py-2 bg-cdsolec-green-dark rounded-r-md text-center text-white font-semibold uppercase tracking-wider hover:bg-cdsolec-green-light">Enviar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <p class="text-xs text-center">
      CD INVERSIONES TECNOLOGICAS, C.A. RIF: J504099929
    </p>
    <p class="text-xs text-center">
      Copyright © <span id="get-current-year">{{ config('app.name', 'Laravel') }} {{ date('Y') }}</span>
      Desarrollado por <a href="https://delfinbeta.tech/" target="_blank" class="italic">DelfinBeta</a>
    </p>
  </div>
</footer>
