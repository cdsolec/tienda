<x-dashboard-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
      <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div>
          <x-jet-application-logo class="block h-12 w-auto" />
        </div>

        <div class="mt-8 text-2xl">
          Bienvenido {{ Auth::user()->fullName }}
        </div>

        <div class="mt-6 text-gray-500">
          Número de Compras: {{ $orders }}
        </div>
      </div>
    </div>
  </div>
</x-dashboard-layout>