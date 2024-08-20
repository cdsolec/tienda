<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}" />

	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />
	<link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}" />

	<!-- Styles -->
	<link rel="stylesheet" href="{{ mix('css/app.css') }}" />
	<link rel="stylesheet" href="{{ mix('css/cdsolec.css') }}" />
	<link rel="stylesheet" href="{{ mix('css/slider.css') }}" />
	<link rel="stylesheet" href="{{ mix('css/megamenu.css') }}" />

	@livewireStyles

	@stack('styles')
</head>
<body class="antialiased">
	<!-- Menu -->
	@include('layouts.menu')

	<!-- Slider -->
	<section id="hero" class="relative">
		@if ($banners->isNotEmpty())
			<div class="-mb-5 md:-mb-12 lg:-mb-20">
				@foreach ($banners as $banner)
					<div class="mySlider hidden fade overflow-hidden">
						<div class="slider relative shadow-2xl" style="background-image: url(<?=$banner->url_image?>);"></div>
					</div>
				@endforeach
				<a onclick="plusSlides(-1)" class="control_prev absolute lg:block p-4 m-4 z-10 cursor-pointer text-white hover:text-auto-blue-light"data-nav="previous">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="32px">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
					</svg>
				</a>
				<a onclick="plusSlides(1)" class="control_next absolute lg:block p-4 m-4 z-10 cursor-pointer text-white hover:text-auto-blue-light" data-nav="next">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="32px">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
					</svg>
				</a>
			</div>
		@endif
		<div class="gradient">
			<svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg"
				xmlns:xlink="http://www.w3.org/1999/xlink">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
						<path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
						<path d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z" opacity="0.100000001"></path>
						<path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
					</g>
					<g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
						<path d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z">
						</path>
					</g>
				</g>
			</svg>
		</div>
	</section>
	
	<main>
		<section id="about">
			<div class="container mx-auto px-4 py-14">
				<div class="flex flex-col md:flex-row items-center">
					<div class="w-full md:w-4/5">
						<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800">
							Bienvenido a nuestro sitio web
						</h6>
						<h2 class="text-3xl leading-tight font-bold mt-4">{{ $about->name }}</h2>
						{!! $about->description !!}
					</div>
					<div class="md:w-1/5 text-center mx-4 pt-1">
						<img src="{{ asset('img/logos/CD-SOLEC_Lema.png') }}" alt="CD-SOLEC" title="CD-SOLEC" />
					</div>
				</div>
			</div>
		</section>

		<section id="brands" class="bg-gray-400">
			<div class="container mx-auto px-4 py-14">
				<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800 text-center">
					Distribuimos equipos y componentes de las mejores marcas
				</h6>
				<h2 class="text-3xl leading-tight font-bold mt-4 text-center">Fabricantes</h2>
				<div class="my-8 grid gap-4 grid-cols-3 md:grid-cols-5">
					@if ($brands->isNotEmpty())
						@foreach ($brands as $brand)
							@php
								if (app()->environment('production')) {
									$image = 'storage/societe/'.$brand->rowid.'/logos/'.$brand->logo;
								} else {
									$image = 'img/logos/CD-SOLEC-ICON.jpg';
								}
							@endphp
							<div class="brand border border-cdsolec-green-dark shadow-lg overflow-hidden sm:rounded-lg transition duration-1000 ease-out opacity-0 transform scale-50">
								<a href="{{ route('products').'?at1[]='.$brand->nom }}">
									<img src="{{ asset($image) }}" alt="{{ $brand->nom }}" title="{{ $brand->nom }}" />
								</a>
							</div>
						@endforeach
					@endif
				</div>
				<div class="text-right">
					<a href="{{ route('brands') }}" class="px-8 py-4 bg-cdsolec-green-light text-white rounded-md font-semibold text-lg hover:bg-cdsolec-green-dark">
						Ver Mas <i class="fas fa-long-arrow-alt-right"></i>
					</a>
			 </div>
			</div>
		</section>

		<section id="products">
			<div class="container mx-auto px-4 py-14">
				@if ($products->isNotEmpty())
					<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800 text-center">
						Soluciones a tu alcance
					</h6>
					<h2 class="text-3xl leading-tight font-bold mt-4 text-center">Productos Destacados</h2>
					<div class="splide" data-splide='{"gap": "1em", "type": "loop", "perPage": 2, "perMove": 1, "fixedWidth": "12rem", "focus": "center", "lazyLoad": true, "autoplay": true}'>
						<div class="splide__track">
							<ul class="splide__list">
								@foreach ($products as $product)
									@php
										if (app()->environment('production')) {
											$image = null;
											if ($product->documents->isNotEmpty()) {
												$documents = $product->documents;
												$total = count($product->documents);
												$i = 0;
												while (!$image && ($i < $total)) {
													if (!$image && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'jpg')) {
														$image = 'storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
													}
													$i++;
												}
											}

											if (!$image) { $image = 'img/favicon/apple-icon.png'; }
										} else {
											$image = 'img/favicon/apple-icon.png';
										}

										$price_original = $product->prices->where('price_level', 1)->first();
										$price_client = $product->prices->where('price_level', $price_level)->first();
										if ($price_client == null) {
											$price_client = $price_original;
										}
									@endphp
									<li class="splide__slide border border-gray-400 rounded-xl grid grid-cols-1 gap-2 content-between">
										<div class="p-2">
											<img data-splide-lazy="{{ asset($image) }}" alt="{{ $product->label }}" title="{{ $product->label }}" class="shadow-lg rounded-xl h-44" />
										</div>
										<div class="text-center">
											<h6 class="text-lg font-semibold">{{ $product->label }}</h6>
											<div class="text-base font-bold text-cdsolec-green-dark">
												<p class="line-through text-red-600">$USD {{ number_format($price_original->price_discount, 2, ',', '.') }}</p>
												<p>$USD {{ number_format($price_client->price_discount, 2, ',', '.') }}</p>
												<p>Bs {{ number_format(($price_client->price_discount * $tasa_usd), 2, ',', '.') }}</p>
											</div>
											<span class="bg-gray-500 text-white rounded-full py-0.5 px-2 text-sm w-min">
												Ref: {{ $product->ref }}
											</span>
										</div>
										<div class="border-t border-gray-400 text-center">
											<a href="{{ route('product', $product->ref) }}" class="py-2 inline-block w-full">
												Detalles <i class="fas fa-long-arrow-alt-right"></i>
											</a>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
			</div>
		</section>

		<!-- <livewire:welcome-modal /> -->
	</main>

	<!-- Footer -->
	@include('layouts.footer')

	<!-- Scripts -->
	<script src="{{ mix('js/app.js') }}"></script>
	<script src="{{ mix('js/welcome.js') }}"></script>
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

		// Slider
    const mySlider = document.querySelectorAll(".mySlider");
    let counter = 1;
    var timer = setInterval(autoslide, 4000);

    slideFun(counter);

    function autoslide() {
      counter += 1;
      slideFun(counter);
    }

    function resetTimer() {
      if (typeof timer !== "undefined") {
        clearInterval(timer);
      }
      timer = setInterval(autoslide, 4000);
    }

    function plusSlides(n) {
      counter += n;
      slideFun(counter);
      resetTimer();
    }

    function currentSlide(n) {
      counter = n;
      slideFun(counter);
      resetTimer();
    }

    function slideFun(n) {
      let i;
      for (i = 0; i < mySlider.length; i++) {
        mySlider[i].style.display = "none";
        mySlider[i].classList.add("hidden");
      }

      if (n > mySlider.length) {
        counter = 1;
      }

      if (n < 1) {
        counter = mySlider.length;
      }

      if (mySlider[counter - 1].style.removeProperty) {
        mySlider[counter - 1].style.removeProperty("display");
      } else {
        mySlider[counter - 1].style.removeAttribute("display");
      }
			
      mySlider[counter - 1].classList.remove("hidden");
    }
  </script>

	@livewireScripts

	@stack('scripts')
</body>
</html>
