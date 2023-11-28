<x-app>
    @slot('title', 'Histories')
    <div class="container">
        <histories-patient :histories="{{ $histories }}"></histories-patient>
    </div>
    {{-- <div>
        <h2>hola soy histories blade</h2>
    </div> --}}

</x-app>
