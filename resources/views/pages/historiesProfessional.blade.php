<x-app>
    @slot('title', 'Histories')
    <div class="container">
        <histories-professional :histories="{{ $histories }}"></histories-professional>
    </div>
    {{-- <div>
        <h2>hola soy histories blade</h2>
    </div> --}}

</x-app>
