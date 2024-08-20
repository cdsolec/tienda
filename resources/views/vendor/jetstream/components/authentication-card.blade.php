@props(['width' => null])

@php
  $classes = 'flex flex-col sm:justify-center items-center w-full m-6 p-8 bg-white bg-opacity-75';

  if ($width == 'small') {
    $classes = 'flex flex-col sm:justify-center items-center w-full m-6 p-8 bg-white bg-opacity-75 md:w-6/12 lg:w-4/12';
  }

  if ($width == 'big') {
    $classes = 'flex flex-col sm:justify-center items-center w-full m-6 p-8 bg-white bg-opacity-75 md:w-8/12 lg:w-6/12';
  }
@endphp

<div class="{{ $classes }}">
  <div class="bg-white w-full p-4">
    <div class="text-center">
      {{ $logo }}
    </div>

    <hr class="my-4" />
  
    {{ $slot }}
  </div>
</div>
