<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}" />

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />
  <link rel="stylesheet" href="{{ mix('css/fontawesome.css') }}" />

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
	<link rel="stylesheet" href="{{ mix('css/dashboard.css') }}" />

  @livewireStyles

  @stack('styles')
</head>
<body id="page-top" class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 flex flex-wrap flex-col md:flex-row">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Page -->
    <div class="relative min-h-screen md:w-3/4 lg:w-4/5">
      @livewire('navigation-menu')

      <!-- Page Heading -->
      @if (isset($header))
        <header class="bg-white shadow">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
          </div>
        </header>
      @endif

      <!-- Page Content -->
      <main>
        {{ $slot }}
      </main>
    </div>
  </div>

  @stack('modals')

  <!-- Scroll to Top Button-->
  <a href="#page-top" id="btn-scroll" class="hidden fixed bottom-2 right-2 px-5 py-2 rounded-md bg-gray-800 text-white text-center hover:bg-gray-700 active:bg-gray-700 focus:outline-none focus:border-gray-900 shadow hover:shadow-lg focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
    <i class="fas fa-angle-up"></i>
  </a>

  @livewireScripts

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js"></script>

  <script>
    (function () {
      /*----------------------  Scroll Page  -----------------------*/
      window.addEventListener('scroll', function(e) {
        let btnScroll= document.getElementById('btn-scroll');

        if (window.scrollY > 20) {
          btnScroll.classList.remove("hidden");
        } else {
          btnScroll.classList.add("hidden");
        }
      });
      /*------------------------------------------------------------*/
    })();
  </script>

  @stack('scripts')
</body>
</html>
