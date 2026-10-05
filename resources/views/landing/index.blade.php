<x-app-layout>

    <body>

        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="/../logotipos/garza.png" alt="garza2" class="img-fluid my-auto"
                                    style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <img src="/../logotipos/garza2.png" width="50px" height="50px"
                                            class="my-auto" alt="garza">
                                        {{-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> --}}
                                        <span class="h2 fw-bold mb-0 ml-4">Sistema de Inventario <i
                                                style="background: #F39200; background: linear-gradient(to left, #F39200 0%, #F8B688 50%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Airone&nbsp;</i>
                                        </span>

                                    </div>
                                    <hr class="w-75 mb-4" style="border: 3px solid #ff7b00; border-radius: 6px ">
                                    <h3 class="fw-normal mb-0 pb-3">¡Bienvenido!, ¿Qué deseas realizar?</h3>
                                    <h5 class="fw-normal mb-0 pb-3">Usuario: {{ Auth::user()->name }}</h5>
                                    <h5 class="fw-normal mb-4 pb-3">Correo Electronico: {{ Auth::user()->email }}</h5>

                                    <div class="form-outline mb-4">
                                        <div class="d-flex justify-content-around mb-4">
                                            <a href="{{ route('profile.show') }}"
                                                class="btn btn-danger btn-lg btn-block mx-auto"> Configuración de Cuenta
                                            </a>
                                            {{-- <button class="btn btn-warning btn-lg btn-block mx-auto"> Dashboard</button> --}}
                                        </div>
                                        @can('admin.home')
                                            <div class="d-flex justify-content-around">
                                                {{-- <button class="btn btn-warning btn-lg btn-block mx-auto"> Configuración de Cuenta</button> --}}
                                                <a href="{{ route('admin.home') }}"
                                                    class="btn btn-danger btn-lg btn-block mx-auto"> Dashboard</a>
                                            </div>
                                        @endcan
                                    </div>

                                    {{-- <a class="small text-muted" href="#!">Forgot password?</a> --}}
                                    <div class="mb-5 pb-lg-2"></div>
                                    {{-- <a href="{{route('profile.show')}}" class="btn btn-warning btn-lg btn-block mx-auto"> Configuración de Cuenta</a> --}}

                                    <a href="{{ route('landing.about') }}" class="small text-muted">Sistema creado por
                                        P.D.L.C.C. Diego Ángel Barajas Pérez.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-app-layout>
