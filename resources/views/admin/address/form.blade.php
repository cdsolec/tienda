<div class="px-4 py-5 grid gap-3 grid-cols-1 md:grid-cols-1">
  <div class="relative w-full mb-3">
    <x-jet-label for="name" value="{{ __('* Titulo') }}" />
    <x-jet-input id="lastname" type="text" name="lastname" :value="old('lastname', $address->lastname)" placeholder="Titulo" required autofocus autocomplete="lastname" />
    <x-jet-input-error for="name" class="mt-2" />
  </div>

  <div class="relative w-full mb-3">
    <x-jet-label for="address" value="{{ __('* Direccion') }}" />
    <x-jet-input id="address" type="text"   name="address" :value="old('address', $address->address)" placeholder="Direccion" required />
    <x-jet-input-error for="address" class="mt-2" />
  </div>

  <div class="relative w-full mb-3">
    <x-jet-label for="town" value="{{ __('* Ciudad') }}" />
    <x-jet-input id="town" type="text"   name="town" :value="old('town', $address->town)" placeholder="Ciudad" required />
    <x-jet-input-error for="address" class="mt-2" />
  </div>

  <div class="relative w-full mb-3">
    <x-jet-label for="departament" value="{{ __('* Estado') }}" />
    <select name="departament" id="departament" class="block mt-1 w-full">
      <option value="">Seleccione </option>
      @foreach($departaments as $departament)
        <option @if($address->fk_departement==$departament->rowid) Selected @endif value="{{$departament->rowid}}">{{$departament->nom}}</option>
      @endforeach
    </select>
    
    <x-jet-input-error for="departament" class="mt-2" />
  </div>

  <div class="relative w-full mb-3">
    <x-jet-label for="phone" value="{{ __('* Telefono') }}" />
    <x-jet-input id="phone" type="text"   name="phone" :value="old('phone', $address->phone)" placeholder="Telefono" required />
    <x-jet-input-error for="phone" class="mt-2" />
  </div>

  


</div>

<div class="flex items-center justify-end px-4 py-3 bg-gray-100 text-right sm:px-6">
  <x-jet-button>{{ ($address->nom) ? __('Actualizar') : __('Guardar') }}</x-jet-button>
</div>