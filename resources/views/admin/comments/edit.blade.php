<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
            <i class="fas fa-comments"></i> Comentarios
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
        <nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
            <ol class="flex flex-wrap">
                <li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
                <li><span class="mx-2">/</span><a href="{{ route('comments.index') }}" class="text-cdsolec-green-dark">Comentarios</a></li>
                <li><span class="mx-2">/</span>Responder Comentario</li>
            </ol>
        </nav>

        <div class="flex flex-wrap justify-center">
            <div class="w-full lg:w-3/4 shadow rounded-md overflow-hidden bg-white">
                <div class="mx-4 mt-5 text-sm text-red-800 p-2 rounded bg-red-300 border border-red-800 {{ $errors->any() ? 'block' : 'hidden' }}">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <form id="form-comment" method="POST" action="{{ route('comments.update', $comment) }}" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    <div class="px-4 py-5 grid gap-3 grid-cols-1 md:grid-cols-2">
                        <!-- Name -->
                        <div class="relative w-full mb-3">
                            <x-jet-label for="name" class="font-bold" value="{{ __('Nombre:') }}" />
                            <div class="text-base w-full border-gray-300 text-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 ">
                                {{ $comment->name }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="relative w-full mb-3">
                            <x-jet-label for="phone" class="font-bold" value="{{ __('Télefono:') }}" />
                            <div class="text-base w-full border-gray-300 text-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 ">
                                {{ $comment->phone }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="relative w-full mb-3 col-span-2">
                            <x-jet-label for="email" class="font-bold" value="{{ __('Email:') }}" />
                            <div class="text-base w-full border-gray-300 text-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 ">
                                {{ $comment->email }}
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="relative w-full mb-3 col-span-2">
                            <x-jet-label for="message" class="font-bold" value="{{ __('Comentario:') }}" />
                            <div class="text-base w-full border-gray-300 text-gray-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 ">
                                {{ $comment->message }}
                            </div>
                        </div>

                        <!-- Answer -->
                        <div class="relative w-full mb-3 col-span-2">
                            <x-jet-label for="answer" value="{{ __('* Respuesta') }}" />
                            <textarea name="answer" id="answer" cols="30" rows="10" class="tinymce form-textarea w-full rounded-md shadow p-3 border-gray-300 text-gray-700 mt-2">{{ old('answer', $comment->answer) }}</textarea>
                            <x-jet-input-error for="answer" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-4 py-3 bg-gray-100 text-right sm:px-6">
                        <x-jet-button>{{ __('Responder') }}</x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/tinymce/tinymce.js') }}"></script>
        <script>
            (function() {
                'use strict';

                tinymce.init({
                    selector: 'textarea.tinymce',
                    height: 400,
                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor emoticons',
                    plugins: 'lists advlist link emoticons'
                });
            })();
        </script>
    @endpush
</x-dashboard-layout>
