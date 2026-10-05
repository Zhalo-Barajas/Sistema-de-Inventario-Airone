<x-app-layout>
<body>

        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
              <div class="card" style="border-radius: 1rem;">
                    <div class="card-body p-4 p-lg-5 text-black">
                        <div class="d-flex justify-content-center mb-3 pb-1">
                            <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto" alt="garza">
                          {{-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> --}}
                          {{-- <span class="h1 fw-bold mb-0 ml-4">Sistema de Inventario <i style="background: #FFCA1B; background: linear-gradient(to right, #FFCA1B 0%, #F4800D 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Airone&nbsp;</i></span> --}}
                          <span class="h1 fw-bold mb-0 ml-4">Sistema de Inventario <i style="background: #F39200; background: linear-gradient(to left, #F39200 0%, #F8B688 50%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Airone&nbsp;</i></span>

                        </div>
      
                        <h2 class=" mb-4 pb-3 text-center" >Sistema Creado por Diego Ángel Barajas Pérez</h2>
                        <h3 class=" mb-1 pb-3 text-center" ><i class="fas fa-user"></i> Contacto:</h3>
                        <h3 class=" mb-1 pb-3 text-center" ><i class="fas fa-envelope"></i> Correo Electrónico: ba439879@uaeh.edu.mx</h3>
                        <h3 class=" mb-1 pb-3 text-center" ><i class="fa-regular fa-envelope"></i> Correo Alternativo: zhalobarajas@gmail.com</h3>
                        <h3 class=" mb-1 pb-3 text-center" ><i class="fas fa-phone"></i> Número telefónico: 771-168-48-04</h3>
                        <h3 class=" mb-1 pb-3 text-center" ><i class="fab fa-linkedin"></i> LinkedIn: <a class="text-danger" href="https://www.linkedin.com/in/diego-angel-barajas-pérez-2771532a7">Diego Ángel Barajas Pérez</a></h3>

      
                        {{-- <a class="small text-muted" href="#!">Forgot password?</a> --}}
                        <div class="mb-5 pb-lg-2"></div>
                        

                        <a href="{{route('landing.about')}}" class="small text-muted">Sistema creado por P.D.L.C.C. Diego Ángel Barajas Pérez.</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</body>
</x-app-layout>


