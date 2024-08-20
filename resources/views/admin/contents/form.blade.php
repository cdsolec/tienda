@csrf

<div class=" px-4 py-5 grid gap-3 grid-cols-1 md:grid-cols-2">
  <!-- Name -->
  <div class="w-full">
    <x-jet-label for="name" value="Nombre" />
    <x-jet-input type="text" id="name" name="name" :value="old('name', $content->name)" required />
    <x-jet-input-error for="name" class="mt-2" />
  </div>

  <!-- Description -->
  <div class="md:col-span-2">
    <x-jet-label for="description" value="Descripción " />
    <textarea name="description" id="description" cols="30" rows="4" class="tinymce w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow">{{ old('description', $content->description) }}</textarea>
    <x-jet-input-error for="description" class="mt-2" />
  </div>
</div>

@push('scripts')
  <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
  <script>
    tinymce.init({
      selector: 'textarea.tinymce',
      height: 400,
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor emoticons',
      plugins: 'lists advlist link emoticons'
    });
  </script>
@endpush