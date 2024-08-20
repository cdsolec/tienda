<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-3 py-2 bg-cdsolec-green-dark border border-transparent rounded-md font-semibold text-center text-white uppercase tracking-wider hover:bg-cdsolec-green-light active:bg-cdsolec-green-dark focus:outline-none focus:border-cdsolec-green-dark focus:shadow-outline-blue disabled:opacity-25 transition']) }}>
  {{ $slot }}
</button>
