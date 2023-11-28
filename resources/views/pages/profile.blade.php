<x-app>
    @slot('title', 'Editar Perfil')
    <div class="container">
        <div class="fw-bold cross-center">

            <h1 class="fw-bolder my-5">Edita tu perfil</h1>
        </div>
        <div class="row justify-content-center mt-4">

            <div class="card row mb-4 mx-2">
                <div class="fw-bolder p-3">{{ __('Información Personal') }}

                    @if (session('message'))
                        <h6 class="text-success mt-3"> <i class="fa-solid fa-check"></i> {{ session('message') }}</h6>
                    @endif
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update-profile') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input value="@if (isset($user_information['name'])) {{ $user_information['name'] }} @endif"
                                    id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="last_name"
                                class="col-md-4 col-form-label text-md-end">{{ __('Apellido') }}</label>

                            <div class="col-md-6">
                                <input
                                    value="@if (isset($user_information['last_name'])) {{ $user_information['last_name'] }} @endif"
                                    id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ old('last_name') }}" required autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="document_number"
                                class="col-md-4 col-form-label text-md-end">{{ __('Nro de Documento') }}</label>

                            <div class="col-md-6">
                                <input
                                    value="@if (isset($user_information['document_number'])) {{ $user_information['document_number'] }} @endif"
                                    id="document_number" type="text"
                                    class="form-control @error('document_number') is-invalid @enderror"
                                    name="document_number" value="{{ old('document_number') }}"
                                    autocomplete="document_number">

                                @error('document_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>



</x-app>
