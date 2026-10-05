
{{-- La directiva @props en un componente anonimo determina que atributos serán consideratos como datos.   --}}
@props(['element']) 
{{-- Recuperación de la variable element que fue enviada por <x-card-post :element="$element" /> en el archivo resources\views\elements\category.blade.php
     El código de este archivo trabajará como si estuviese en un unico archivo el contenido de category.blade.php y card-post.blade.php  --}}

        
        <article class="mb-8 bg-white shadow-lg rounded-lg overflow-hidden">
            {{-- LLamada a la imagen de relacionada al elemento seleccionado, (La labor se realiza con la llamada a la clase Storage a partir de una url,
             url la cual se genera a partir de la invocación de la relación polimorfica, llamamos a la instacia de $element, liego a image, de image se 
             recuperá la columna URL.  ) --}}
              <img class="w-full h-72 object-cover object-center" @if ($element->image) src="{{Storage::url($element->image->url)}}" @else src="https://cdn.pixabay.com/photo/2024/02/17/11/45/moon-8579189_1280.jpg" @endif >
              <div class="px-6 py-4">
                <h1 class="font-bold text-xl mb-2">
                    {{-- Si se hace click a este enlace re redirigirá a la pagina con detalles del elemento. en esta sedespliega el nombre del elemento. --}}
                    <a href="{{route('elements.show', $element)}}">{{$element->nameElement}}</a>
                </h1>
    
                <div class="text-gray-700 text-base">
                    {{$element->description}}
                </div>
                <div class="px-6 pt-4 pb-2">
                    @foreach ($element->tags as $tag)
                        <a href="{{route('elements.tag', $tag)}}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm text-gray-700 mr-2">{{$tag->nameTag}}</a>
                    @endforeach
    
                </div>
    
              </div>
            </article>
            <br>