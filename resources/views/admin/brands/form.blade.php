<div class="px-4 py-5 grid gap-3 grid-cols-1 md:grid-cols-2">
  <div class="relative w-full mb-3">
    <x-jet-label for="name" value="{{ __('* Nombre') }}" />
    <x-jet-input id="name" type="text" name="name" :value="old('name', $brand->name)" placeholder="Nombre" required autofocus autocomplete="name" />
    <x-jet-input-error for="name" class="mt-2" />
  </div>

  <div class="relative w-full mb-3">    
    <x-jet-label for="image" value="{{ __('* Imagen') }}" />
    <x-jet-input id="image" type="file" name="image" placeholder="Imagen" data-input="false" aria-describedby="imageHelp" />
    <x-jet-input-error for="image" class="mt-2" />

    <div class="flex-shrink-0 h-10 w-10 mr-4">
      <img class="h-10 w-10 rounded-full" src="{{ asset($brand->urlImage) }}" alt="{{ $brand->name }}" title="{{ $brand->name }}" id="preview">
    </div>
  </div>
</div>

<div class="flex items-center justify-end px-4 py-3 bg-gray-100 text-right sm:px-6">
  <x-jet-button>{{ ($brand->name) ? __('Actualizar') : __('Guardar') }}</x-jet-button>
</div>

@push('scripts')
  <script>

    let image = document.getElementById('image');
    let preview = document.getElementById('preview');
    image.addEventListener('change', function() {
      readURL(this);
    }, false);
    
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endpush