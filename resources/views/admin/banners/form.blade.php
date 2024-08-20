@csrf

<div class="px-4 py-5 grid gap-3 grid-cols-1 md:grid-cols-3">
  <div class="flex items-center">
    <img src="{{ ($banner->image != '') ? asset($banner->url_image) : asset('img/favicon/apple-icon.png') }}" id="preview" alt="Preview" title="Preview" class="h-20 border border-cdsolec-green-dark rounded-md" />
  </div>
  <div class="col-span-2">
    <!-- Name -->
    <div class="w-full">
      <x-jet-label for="name" value="Nombre" />
      <x-jet-input type="text" id="name" name="name" :value="old('name', $banner->name)" required />
      <x-jet-input-error for="name" class="mt-2" />
    </div>

    <!-- Image -->
    <div class="w-full">
      <x-jet-label for="image" value="Imagen" />
      <x-jet-input type="file" id="image" name="image" :value="old('image', $banner->image)" required />
      <x-jet-input-error for="image" class="mt-2" />
    </div>
  </div>
</div>

@push('scripts')
  <script>
    (function() {
      'use strict';

      let image = document.getElementById("image");

      image.addEventListener("change", function() {
        document.getElementById("preview").src = URL.createObjectURL(this.files[0]);
      });
    })();
  </script>
@endpush