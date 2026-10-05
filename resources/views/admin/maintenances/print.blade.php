<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte_Elemento_{{$element->id}}</title>
    
    
    <style>
        .borders {
          border: 1px solid black;
          border-collapse: collapse;
        }
        .bordersTB {
          border: 1px solid black;
          border-collapse: collapse;
          margin-left: auto;
          margin-right: auto;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
        .content { 
            font-family: 'Arial Narrow', Arial, sans-serif; font-size:13px; 
        }
        .space1 { width: 40px; height: 40px; }

        .title{
          position: absolute;
          transform: translateY(50%),translateX(35%);
          text-align: center;
          margin-left: auto;
          margin-right: auto;
        }

        .text-wrap{
          overflow-wrap: break-word;
        }
    </style>
</head>
<body class="content">

  <div>
    <img src="{{ public_path('logotipos/logouaeh.png')}}" height="100px" width="80px" alt="logouaeh">
    <span class="title"><b>UNIVERSIDAD AUTÓNOMA DEL ESTADO DE HIDALGO <br>
      Pachuca, Hidalgo a {{date('d');}} de {{$month}} de {{date('Y');}}.</b></span>
  </div>

    <p style="text-align: center"> <b style="font-size: large">Registro de mantenimiento de Equipo.</b></p>
    <hr> {{-- Línea divisora --}}
 

    <p style="text-align: center"> <b style="font-size: medium">Descripción del elemento.</b></p>

    <table class="bordersTB" style='center'>
            <tbody>
              <tr>
                <th class="borders" width="210px" style="text-align: left">Elemento/Equipo:</th> <td width="500px" class="borders"><p class="text-wrap">{{$element->nameElement}}</p> </td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">Marca:</th> <td class="borders"> @if (isset($atributes->brand)) <p class="text-wrap">{{$atributes->brand}}</p> @else N/A @endif</td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">Modelo:</th> <td class="borders"> @if (isset($atributes->model)) <p class="text-wrap">{{$atributes->model}}</p> @else N/A @endif</td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">ID Elemento:</th> <td class="borders">{{$element->id}}</td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">Número de serie:</th> <td class="borders"> @if (isset($atributes->serialNumber)) <p class="text-wrap">{{$atributes->serialNumber}}</p> @else N/A @endif</td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">Número de inventario:</th> <td class="borders"> @if (isset($atributes->invNumber)) <p class="text-wrap">{{$atributes->invNumber}}</p> @else N/A @endif</td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">Área de adscripción:</th> 
                <td class="borders">
                  @switch($element->building_id)
                            @case(1)
                              {{$buildings[0]->nameBuilding}}
                                @break
                            @case(2)
                              {{$buildings[1]->nameBuilding}}
                                @break
                            @case(3)
                              {{$buildings[2]->nameBuilding}}
                                @break
                            @case(4)
                              {{$buildings[3]->nameBuilding}}
                                @break
                            @default
                                <td><p>N/A</p></td>
                        @endswitch,
                        @switch($element->ubication_id)
                        @case(1)
                            {{$ubications[0]->nameUbication}}
                            @break
                        @case(2)
                            {{$ubications[1]->nameUbication}}
                            @break
                        @case(3)
                            {{$ubications[2]->nameUbication}}
                            @break
                        @case(4)
                            {{$ubications[3]->nameUbication}}
                            @break
                        @case(5)
                            {{$ubications[4]->nameUbication}}
                            @break
                        @case(6)
                            {{$ubications[5]->nameUbication}}
                            @break
                        @case(7)
                            {{$ubications[6]->nameUbication}}
                            @break
                        @case(8)
                            {{$ubications[7]->nameUbication}}
                            @break
                        @case(9)
                            {{$ubications[8]->nameUbication}}
                            @break
                        @default
                            <p>N/A</p>
                    @endswitch
                </td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">Fecha de último mantenimiento: </th> <td class="borders">{{$maintenance->oldMaintenanceDate}}</td>
              </tr>
              <tr>
                <th class="borders" style="text-align: left">Fecha de mantenimiento: </th> <td class="borders">{{$maintenance->maintenanceDate}}</td>
              </tr>
              

            </tbody>
    </table>
    <br>
    <hr> {{-- Línea divisora --}}

    <div style="text-align:justify" >
      <p style="text-align: center"> <b style="font-size: large">Descripción del mantenimiento: <br> </b> </p>
      <div class="borders" style="padding: 10px;">
        <p class="text-wrap">{{$maintenance->maintenanceDescription}} </p>
      </div>
    </div>
    {{-- @isset($atributes)
        {{$atributes}} <br><br><br>
        {{$atributes}}
        @else
        Sin Atributos <br><br><br>
        @endisset

        {{$element}} <br><br><br>
        {{$maintenance}} <br><br><br>

        {{-- La directiva de blade se encarga de revisar que exista el atributo capacity en la variable $atributes con el uso conjunto de la función isset --}}
        {{-- @if (isset($atributes->capacity))
            {{$atributes->model}}
        @else
           N/A
        @endif --}}
        <br><br>
    <hr>
</body>


</html>