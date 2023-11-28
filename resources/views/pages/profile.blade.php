<x-app>
    @slot('title', 'Editar Perfil')
    <div class="container">
        <users :info={{ $user_information }}></users>
    </div>
</x-app>
