<x-app>
    @slot('title', 'Login')
    <div class="bg-auth overflow-x-hidden  ">
        <div class="container   py-3 py-lg-5 mt-lg-5">
            <div class="col-lg-6 col-xl-7 bg-white p-3 p-lg-5 mb-lg-5 rounded-4">

                <h1>Login</h1>
                <form method="POST" action="{{ route('auth.login') }}" autocomplete="off">
                    @csrf
                    <label class="d-block mb-3">
                        <input type="text"
                            class="border-primary form-control @error('document_number') is-invalid @enderror"
                            name="document_number" value="{{ old('document_number') }}" required
                            autocomplete="document_number" autofocus placeholder="{{ __('Numero de documento') }}">
                        @error('document_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="d-block mb-3">
                        <input type="password"
                            class="border-primary form-control @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}" required autocomplete="password" autofocus required
                            placeholder="{{ __('Contraseña') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>


                    <button type="submit" class="btn btn-primary me-3 mb-3">{{ __('Iniciar Sesión') }}</button>
                    {{-- <a href="{{ route('auth.register') }}"
                        class="btn btn-outline-primary mb-3">{{ __('Crear cuenta') }}</a> --}}

                </form>
            </div>
        </div>
    </div>

</x-app>
