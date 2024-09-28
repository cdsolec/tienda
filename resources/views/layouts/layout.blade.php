<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<title> @yield('title') | {{ config('app.name', 'Laravel') }}</title>
  <!-- Favicon -->
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}" />

	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />
	<link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}" />

	<!-- Styles -->
	<link rel="stylesheet" href="{{ mix('css/app.css') }}" />
	<link rel="stylesheet" href="{{ mix('css/cdsolec.css') }}" />
	<link rel="stylesheet" href="{{ mix('css/megamenu.css') }}" />

	<meta name="layout" content="layout">

	@livewireStyles

	@stack('styles')
</head>
<body class="antialiased">
	<!-- Menu -->
	@include('layouts.menu')

	<!-- Banner -->
	<div class="w-full h-52 banner" style="background-image: url(@yield('background'));"></div>
	
	<main class="py-14">
    @yield('content')

	<button class="btn btn-default" id="btnWhatsaap">

		<a target="_blank" href="{{'https://wa.me/'.intval($nroWhatsapp).'/?text=Quisiera%20mas%20informaci%C3%B3n'}}">
	
			<img src="{{ url('img/whatsapp.png')}}" alt="whatsapp">
	
		</a>
	</button>


	</main>

	<!-- Footer -->
	@include('layouts.footer')

	<!-- Scripts -->
	<script src="{{ mix('js/app.js') }}"></script>
	<script>
		// Tabs
		function tabsMegaMenu() {
			return {
				activeTab: 0,
				tabs: [
						"Categorías",
						// "Sectores de Interés",
				]
			};
		};
  </script>

	@livewireScripts

	<script
		src="https://code.jquery.com/jquery-3.7.1.js"
		integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
		crossorigin="anonymous"></script>

 

	@stack('scripts')
</body>
</html>
