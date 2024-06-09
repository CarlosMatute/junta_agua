@extends('../layouts/' . $layout)

@section('subhead')
    <title>Ubicaciones</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        #map {
            height: 300px; /* Altura del mapa */
            width: 100%; /* Ancho del mapa */
            border: 1px solid #ccc; /* Borde opcional para el mapa */
            margin-top: 20px; /* Margen superior opcional */
        }
    </style>
@endsection

@section('subcontent')
<style>
    /* Estilos para el scroll horizontal */
    .table-scrollable {
        overflow-x: scroll;
        width: 100%;
    }

    #sdatatable {
        min-width: 120%;
    }
</style>
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box mt-5 px-5 pt-5">
            <div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
                <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
                   
                   
                            <x-base.lucide
                                class="h-40 w-40"
                                icon="Home"
                            />
                        
                
                    <div class="ml-5">
                        <div class="w-240 truncate text-lg font-medium sm:w-80 sm:whitespace-normal">
                            
                            <h1 class="text-5xl font-medium leading-none">UBICACIONES</h1>
                        </div>
                        <div class="text-slate-500">Pantalla de administración de ubicaciones.</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Profile Info -->
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box mt-5 p-5">
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y col-span-6 lg:col-span-6">
                <div class="p-5">
                    <h3 class="text-2xl font-medium leading-none">
                        <div class="flex items-center">
                            <i data-lucide="List" class="w-6 h-6 mr-1"></i>
                            <span class="text-white-700"> Lista De Ubicaciones</span>
                        </div>
                    </h3>
                </div>
            </div>
            <div class="intro-y col-span-6 lg:col-span-6 text-right">
                <div class="p-5">
                    <x-base.button
                        class="mb-2 mr-1"
                        variant="primary"
                        id="btn_nueva_ubicacion"
                    >
                        <i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                        Registrar Nueva Ubicación
                    </x-base.button>
                </div>
            </div>
        </div>
        <div class="scrollbar-hidden overflow-x-auto">
            <div class="table-scrollable">
            <table id="sdatatable" class="display datatable" style="width:100%">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>ID</th>
                        <th>Descripción Casa</th>
                        <th>Cliente Habita</th>
                        <th>Dirección</th>
                        <th>Foto</th>
                        <th>Ubicación</th>
                        <th>Coordenadas</th>
                        <th>Monto</th>
                        <th>Fecha Cobro</th>
                        <th>QR</th>
                        <th>Activo</th>
                        <th>Casa Propia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($ubicaciones as $row)
                    <tr>
                        <td>{{$row->id}}</td>
                        <td>{{$row->descripcion_casa}}</td>
                        <td class="text-center">
                            @if($row->cliente_habita)
                                <i data-lucide="Check" class="w-4 h-4 text-green-500" style="color: #10B981;"></i>
                            @else
                                <i data-lucide="X" class="w-4 h-4 text-red-500" style="color: #EF4444;"></i>
                            @endif
                        </td>
                        <td>{{$row->direccion}}</td>
                        <td>{{$row->foto}}</td>
                        <td>{{$row->ubicacion}}</td>
                        <td>{{$row->coordenadas}}</td>
                        <td>{{$row->monto}}</td>
                        <td>{{$row->fecha_cobro}}</td>
                        <td>{{$row->qr}}</td>
                        <td class="text-center">
                            @if($row->activo)
                                <i data-lucide="Check" class="w-4 h-4 text-green-500" style="color: #10B981;"></i>
                            @else
                                <i data-lucide="X" class="w-4 h-4 text-red-500" style="color: #EF4444;"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($row->casa_propia)
                                <i data-lucide="Check" class="w-4 h-4 text-green-500" style="color: #10B981;"></i>
                            @else
                                <i data-lucide="X" class="w-4 h-4 text-red-500" style="color: #EF4444;"></i>
                            @endif
                        </td>
                        <td>
                            <x-base.button
                                class="mb-2 mr-1 editar"
                                variant="warning"
                                size="sm"
                                data-id="{{$row->id}}" 
                                data-descripcion_casa="{{$row->descripcion_casa}}" 
                                data-cliente_habita="{{$row->cliente_habita ? '1' : '0'}}" 
                                data-direccion="{{$row->direccion}}" 
                                data-foto="{{$row->foto}}" 
                                data-pais="{{$row->id_pais}}"
                                data-departamento="{{$row->id_departamento}}"
                                data-municipio="{{$row->id_municipio}}"
                                data-coordenadas="{{$row->coordenadas}}"
                                data-monto="{{$row->monto}}"
                                data-fecha_cobro="{{$row->fecha_cobro}}"
                                data-qr="{{$row->qr}}"
                                data-activo="{{$row->activo ? '1' : '0'}}"
                                data-casa_propia="{{$row->casa_propia ? '1' : '0'}}"
                            >
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="Edit"
                                />
                            </x-base.button>
                            <x-base.button
                                class="mb-2 mr-1 eliminar"
                                variant="danger"
                                size="sm"
                                data-id="{{$row->id}}" 
                                data-descripcion_casa="{{$row->descripcion_casa}}" 
                                data-cliente_habita="{{$row->cliente_habita ? '1' : '0'}}" 
                                data-direccion="{{$row->direccion}}" 
                                data-foto="{{$row->foto}}" 
                                data-pais="{{$row->id_pais}}"
                                data-departamento="{{$row->id_departamento}}"
                                data-municipio="{{$row->id_municipio}}"
                                data-coordenadas="{{$row->coordenadas}}"
                                data-monto="{{$row->monto}}"
                                data-fecha_cobro="{{$row->fecha_cobro}}"
                                data-qr="{{$row->qr}}"
                                data-activo="{{$row->activo ? '1' : '0'}}"
                                data-casa_propia="{{$row->casa_propia ? '1' : '0'}}"
                            >
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="Trash"
                                />
                            </x-base.button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
   
        <!-- BEGIN: Modal Content -->
        <x-base.dialog id="modal_nuevo_cliente" size="xl">
            <x-base.dialog.panel>
                <x-base.dialog.title class="bg-primary">
                    <h2 class="mr-auto text-white font-medium">
                        <div class="flex items-center">
                            <i data-lucide="Home" class="w-4 h-4 mr-1"></i> <!-- Cambiado a un ícono de casa -->
                            <span class="text-white-700"> Registrar Nueva Ubicación</span> <!-- Cambiado el texto -->
                        </div>
                    </h2>
                </x-base.dialog.title>
                
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <!-- Campos para registrar una nueva ubicación -->
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_pais">
                            País
                        </x-base.form-label>
                        <x-base.form-select
                                class="sm:mt-2 sm:mr-2"
                                aria-label=".form-select-lg example"
                                id="modal_input_pais" 
                                class="w-full" 
                                data-placeholder="Selección de Género"
                            >
                            @foreach($paises as $row)
                            <option value="{{$row->id}}">{{$row->nombre}}</option>
                            @endforeach
                            </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_departamento">
                            Departamento
                        </x-base.form-label>
                        <x-base.form-select
                                class="sm:mt-2 sm:mr-2"
                                aria-label=".form-select-lg example"
                                id="modal_input_departamento" 
                                class="w-full" 
                                data-placeholder="Selección de Género"
                            >
                            @foreach($departamentos as $row)
                            <option value="{{$row->id}}">{{$row->nombre}}</option>
                            @endforeach
                            </x-base.form-select>
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_municipio">
                            Municipio
                        </x-base.form-label>
                        <x-base.form-select
                                class="sm:mt-2 sm:mr-2"
                                aria-label=".form-select-lg example"
                                id="modal_input_municipio" 
                                class="w-full" 
                                data-placeholder="Selección de Género"
                            >
                            <option id="opc"></option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_coordenadas">
                            Coordenadas
                        </x-base.form-label>
                        <x-base.form-input
                            id="modal_input_coordenadas"
                            type="text" 
                            placeholder="Escriba las coordenadas"
                        />
                    </div>
                    

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_descripcion_casa">
                            Descripción
                        </x-base.form-label>
                        <x-base.form-input id="modal_input_descripcion_casa" type="text" placeholder="Escriba una descripción de la casa" />
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_cliente_habita">
                            Cliente Habita En La Casa
                        </x-base.form-label>
                        <x-base.form-select 
                            id="modal_input_cliente_habita"
                            data-placeholder="Seleccione si el cliente habita en la casa"
                        >
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_casa_propia">
                            Casa Propia
                        </x-base.form-label>
                        <x-base.form-select 
                            id="modal_input_casa_propia"
                            data-placeholder="Seleccione si la casa es propia del cliente"
                        >
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_activo">
                            Activo
                        </x-base.form-label>
                        <x-base.form-select 
                            id="modal_input_activo"
                            data-placeholder=""
                        >
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_monto">
                            Monto
                        </x-base.form-label>
                        <x-base.form-input
                            id="modal_input_monto"
                            type="number"
                            step="0.01"
                            placeholder="Escriba el monto a pagar."
                        />
                    </div>

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_fecha_cobro">
                            Fecha de Cobro
                        </x-base.form-label>
                        <x-base.form-input
                            id="modal_input_fecha_cobro"
                            type="date"
                        />
                    </div>
                    

                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_direccion">
                            Dirección
                        </x-base.form-label>
                        <x-base.form-textarea rows="5" class="form-control" id="modal_input_direccion" name="comment" placeholder="Escriba la dirección exacta."></x-base.form-textarea>
                    </div>

                    <div class="col-span-12 md:col-span-12 lg:col-span-12">
                        <div id="map"></div>
                    </div>

                    

                    
                    
                    <!-- Agrega más campos según tu modelo de datos -->
                </x-base.dialog.description>
                
                <x-base.dialog.footer class="bg-dark">
                    <x-base.button size="sm" class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="danger">
                        Cancelar
                    </x-base.button>
                    <x-base.button size="sm" class="w-20" type="button" variant="primary" id="modal_btn_guardar_ubicaciones">
                        Guardar
                    </x-base.button>
                </x-base.dialog.footer>
                
            </x-base.dialog.panel>
        </x-base.dialog>
        <!-- END: Modal Content -->

     
                   
        <x-base.dialog id="modal_opciones">
            <x-base.dialog.panel>
                <x-base.dialog.title>
                    <h2 class="mr-auto text-base font-medium">
                        <strong>Opciones</strong>
                    </h2>
                </x-base.dialog.title>

                <x-base.tab.list class="flex-col justify-center sm:flex-row p-10 text-center" variant="boxed-tabs">
                    <x-base.tab id="btn_id_solicitud" :fullWidth="false">
                        <x-base.tab.button class="mb-2 w-full cursor-pointer px-0 py-2 text-center text-primary sm:mx-2 sm:mb-0 sm:w-20">
                            <x-base.lucide class="mx-auto mb-2 block h-6 w-6" icon="Printer" />
                            <strong>Imprimir</strong>
                        </x-base.tab.button>
                    </x-base.tab>
                    <x-base.tab :fullWidth="false">
                        <x-base.tab.button id="btn_editar"  href="" class="mb-2 w-full cursor-pointer px-0 py-2 text-center text-warning sm:mx-2 sm:mb-0 sm:w-20">
                            <x-base.lucide class="mx-auto mb-2 block h-6 w-6" icon="CheckSquare" />
                            <strong>Editar</strong>
                        </x-base.tab.button>
                    </x-base.tab>
                    <x-base.tab id="btn_modal_eliminar" :fullWidth="false">
                        <x-base.tab.button class="mb-2 w-full cursor-pointer px-0 py-2 text-center text-danger sm:mx-2 sm:mb-0 sm:w-20">
                            <x-base.lucide class="mx-auto mb-2 block h-6 w-6" icon="Trash" />
                            <strong>Eliminar</strong>
                        </x-base.tab.button>
                    </x-base.tab>
                </x-base.tab.list>
            </x-base.dialog.panel>
        </x-base.dialog>
    
    <!-- BEGIN: Modal Content -->
        <x-base.dialog id="modal_eliminar">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                    <div class="mt-5 text-3xl">¡Advertencia!</div>
                    <div class="mt-2 text-slate-500">
                        ¿Realmente desea eliminar esta Ubicación?<br />
                        <div id="id_registro"></div>
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                        Cancelar
                    </x-base.button>
                    <x-base.button class="w-24" type="button" variant="danger" id="btn_eliminar">
                        Eliminar
                    </x-base.button>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
        <!-- END: Modal Content -->

    </div>
        <!-- END: HTML Table Data -->
        <div class="text-center">
            <!-- BEGIN: Notification Content -->
            <div id="success-notification-content" class="py-5 pl-5 pr-14 bg-white border border-slate-200/60 rounded-lg shadow-xl dark:bg-darkmode-600 dark:text-slate-300 dark:border-darkmode-600 hidden flex flex flex">
                <i data-lucide="check-circle" width="24" height="24" class="stroke-1.5 text-success text-success"></i>
                <div id="success-notification" class="ml-4 mr-4">
                    
                </div>
            </div>

            <div id="danger-notification-content" class="py-5 pl-5 pr-14 bg-white border border-slate-200/60 rounded-lg shadow-xl dark:bg-darkmode-600 dark:text-slate-300 dark:border-darkmode-600 hidden flex flex flex">
                <i data-lucide="x-circle" width="24" height="24" class="stroke-1.5 text-danger text-danger"></i>
                <div id="danger-notification" class="ml-4 mr-4">
                    
                </div>
            </div>
            <!-- END: Notification Content -->
        </div>

@endsection
@once

    @push('scripts')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite('resources/js/pages/modal/index.js')
        @vite('resources/js/vendor/toastify/index.js')
        @vite('resources/js/pages/notification/index.js')
        <script type="module">
            var accion_guardar = false;
            var accion = null;
            var id = null;
            var descripcion_casa = null;
            var direccion = null;
            var monto = null;
            var cliente_habita = null;
            var pais = null;
            var coordenadas = null;
            var casa_propia = null;
            var fecha_cobro = null;
            var departamento = null;
            var municipio = null;
            var activo = null;
            var id_departamento = null;
            var url_consultar_municipios = "{{url('/departamentos-municipios')}}";
            var url_guardar_ubicaciones = "{{url('/ubicaciones/guardar')}}";
            var onTomSelect = false;
            var tomSelect = null;
            var titleMsg = null;
            var textMsg = null;
            var typeMsg = null;
            var numerofila = null;
            var table = null;
            var rowNumber = null;
            var map = null;
            var marker = null;
            var ubicacion_casa = null;
            var id_seleccionar = localStorage.getItem("sdatatable_id_seleccionar");

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    
                });	 

                //$.fn.dataTable.isDataTable('#sdatatable')
                    // Inicializa el DataTable
                    table = $('#sdatatable').DataTable({
                        language: { 
                            "decimal": ",", 
                            "thousands": ".", 
                            "lengthMenu": "Mostrar _MENU_ registros", 
                            "zeroRecords": "No se encontraron resultados", 
                            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", 
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros", 
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)", 
                            "sSearch": "Buscar:", 
                            "oPaginate": { 
                                "sFirst": "Primero", 
                                "sLast":"Último", 
                                "sNext":"Siguiente", 
                                "sPrevious": "Anterior" 
                            }, 
            
                            "oAria": { 
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente", 
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente" 
                            }, 
            
                            "sProcessing":"Cargando..." 
                        },
                        "processing": true,
                        serverSide: false,
                    });

                    id_departamento = $("#modal_input_departamento").val();
                    
                    
            });

            document.addEventListener('DOMContentLoaded', function() {
                    // Inicializa el mapa
                    map = L.map('map').setView([15.199999, -86.241905], 6);

                    // Añade una capa de mapa (OpenStreetMap en este caso)
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                     // Establece la ruta de las imágenes de Leaflet
                    L.Icon.Default.imagePath = "/build/assets/";


                    // Añade un evento de clic al mapa
                    map.on('click', function(e) {
                        // Obtén las coordenadas del clic
                        var coords = e.latlng;
                        
                        // Si ya hay un marcador, actualiza su posición
                        if (marker) {
                            marker.setLatLng(coords);
                            //{"lat": 14.119429333513594,"lng": -87.18672752380373}
                        } else {
                            // Si no hay marcador, crea uno nuevo
                            marker = L.marker(coords).addTo(map);
                        }

                        ubicacion_casa = coords;
                        ubicacion_casa = '{"lat": '+ubicacion_casa.lat.toString() + ', "lng": ' + ubicacion_casa.lng.toString()+'}';
                        //console.log(ubicacion_casa);
                        // Actualiza el contenido del elemento span con las coordenadas
                        //document.getElementById('coords').textContent = `Lat: ${coords.lat}, Lng: ${coords.lng}`;
                    });
                });

            window.addEventListener('DOMContentLoaded', (event) => {
        const table = document.getElementById('sdatatable');
        if (table) {
            table.style.minWidth = '120%';
        }
    });

            $("#sdatatable tbody").on( "click", "tr", function () { 
                                     rowNumber=parseInt(table.row( this ).index()); 
                                     table.$('tr.selected').removeClass('selected'); 
                                     $(this).addClass('selected'); 
                                     localStorage.setItem("sdatatable_id_seleccionar",table.row( this ).data()[0]); 
                                     }); 

            $('#sdatatable tbody').on('click', '.editar', function() {
                map.setView([15.199999, -86.241905], 6);

                accion = 2;
                id = $(this).data('id');
                descripcion_casa = $(this).data('descripcion_casa');
                direccion = $(this).data('direccion');
                monto = $(this).data('monto');
                cliente_habita = $(this).data('cliente_habita');
                pais = $(this).data('pais');
                coordenadas = $(this).data('coordenadas');
                casa_propia = $(this).data('casa_propia');
                fecha_cobro = $(this).data('fecha_cobro');
                departamento = $(this).data('departamento');
                municipio = $(this).data('municipio');
                activo = $(this).data('activo');
                consultar_municipios(departamento);

                if (marker) {
                    marker.setLatLng(coordenadas);
                } else {
                    marker = L.marker(coordenadas).addTo(map);
                }
                ubicacion_casa = '{"lat": '+coordenadas.lat.toString() + ', "lng": ' + coordenadas.lng.toString()+'}';
                const el = document.querySelector("#modal_nuevo_cliente");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.show();

            });

            function datos_inputs(){
                $("#modal_input_descripcion_casa").val(descripcion_casa);
                $("#modal_input_direccion").val(direccion);
                $("#modal_input_monto").val(monto);
                $("#modal_input_cliente_habita").val(cliente_habita);
                $("#modal_input_pais").val(pais);
                $("#modal_input_coordenadas").val(coordenadas);
                $("#modal_input_casa_propia").val(casa_propia);
                $("#modal_input_fecha_cobro").val(fecha_cobro);
                $("#modal_input_departamento").val(departamento);
                $("#modal_input_municipio").val(municipio);
                $("#modal_input_activo").val(activo);
                const el = document.querySelector("#modal_nuevo_cliente");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.show();
            }

            $('#sdatatable tbody').on('click', '.eliminar', function() {
                var fila = $('#sdatatable').DataTable().row($(this).parents('tr'));
                var data = fila.data();
                accion = 3;
                numerofila = fila.index();
                id = data[0];
                const el = document.querySelector("#modal_eliminar");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.show(); 
            });

            $("#btn_nueva_ubicacion").on("click", function (event) {
                map.setView([15.199999, -86.241905], 6);
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }

                $("#modal_input_descripcion_casa").val('');
                $("#modal_input_direccion").val('');
                $("#modal_input_monto").val('');
                $("#modal_input_cliente_habita").val('');
                //$("#modal_input_pais").val('');
                $("#modal_input_coordenadas").val('');
                $("#modal_input_casa_propia").val('');
                $("#modal_input_fecha_cobro").val('');
                $("#modal_input_departamento").val(id_departamento);
                //$("#modal_input_municipio").val('');
                $("#modal_input_activo").val('');
                consultar_municipios(id_departamento);
                accion = 1;
                const el = document.querySelector("#modal_nuevo_cliente");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.show();
            });

            $('#modal_input_departamento').change(function(){
                id_departamento = $(this).val();
                consultar_municipios(id_departamento);
            });

            $("#modal_btn_guardar_ubicaciones").on("click", function () {
                descripcion_casa = $("#modal_input_descripcion_casa").val();
                direccion = $("#modal_input_direccion").val();
                monto = $("#modal_input_monto").val();
                cliente_habita = $("#modal_input_cliente_habita").val();
                pais = $("#modal_input_pais").val();
                coordenadas = $("#modal_input_coordenadas").val();
                casa_propia = $("#modal_input_casa_propia").val();
                fecha_cobro = $("#modal_input_fecha_cobro").val();
                departamento = $("#modal_input_departamento").val();
                municipio = $("#modal_input_municipio").val();
                activo = $("#modal_input_activo").val();
                
                if(pais == null || pais == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para pais.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(departamento == null || departamento == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para departamento.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(municipio == null || municipio == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para municipio.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(coordenadas == null || coordenadas == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para coordenadas.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(descripcion_casa == null || descripcion_casa == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para Descripcion.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(cliente_habita == null || cliente_habita == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para cliente habita en la casa.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(casa_propia == null || casa_propia == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para casa propia.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(activo == null || activo == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para activo.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(monto == null || monto == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para monto.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }


                if(fecha_cobro == null || fecha_cobro == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para fecha de cobro.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                if(direccion == null || direccion == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para direccion.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }

                
                
                if(!accion_guardar){
                    guardar_ubicaciones();
                }
            });

            $("#btn_eliminar").on("click", function () {
                guardar_ubicaciones();
                const el = document.querySelector("#modal_eliminar");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.hide();
            });

            function guardar_ubicaciones() {
                accion_guardar = true;
                $.ajax({
                    type: "POST",
                    url: url_guardar_ubicaciones,
                    data: {
                        'accion' : accion,
                        'id' : id,
                        'descripcion_casa' : descripcion_casa,
                        'direccion' : direccion,
                        'monto' : monto,
                        'cliente_habita' : cliente_habita,
                        'fecha_cobro' : fecha_cobro,
                        'pais' : pais,
                        'coordenadas' : coordenadas,
                        'casa_propia' : casa_propia,
                        'departamento' : departamento,
                        'municipio' : municipio,
                        'activo' : activo,
                        'ubicacion_casa':ubicacion_casa
                    },
                    success: function(data) {
                        if (data.msgError) {
                            titleMsg = "Error al Guardar";
                            textMsg = data.msgError;
                            typeMsg = "error";
                        } else {
                            titleMsg = "Datos Guardados";
                            textMsg = data.msgSuccess;
                            typeMsg = "success";
                            if(accion != 3){
                                var row = data.ubicaciones_list;
                                var cliente_habita_icono = null;
                                var casa_propia_icono = null;
                                var activo_icono = null;

                                if (row.foto == null || row.foto == '') {
                                    row.foto = "Prueba";
                                }

                                if (row.qr == null || row.qr == '') {
                                    row.foto = "Prueba";
                                }

                                if (row.cliente_habita) {
                                    cliente_habita_icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="Check" data-lucide="Check" class="lucide lucide-Check w-4 h-4 text-green-500" style="color: #10B981;"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                                    //cliente_habita_icono = 'SI';
                                }else{
                                    cliente_habita_icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="X" data-lucide="X" class="lucide lucide-X w-4 h-4 text-red-500" style="color: #EF4444;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                                    //cliente_habita_icono = 'NO';
                                }

                                if (row.activo) {
                                     activo_icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="Check" data-lucide="Check" class="lucide lucide-Check w-4 h-4 text-green-500" style="color: #10B981;"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                                     //activo_icono = 'SI';
                                }else{
                                    activo_icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="X" data-lucide="X" class="lucide lucide-X w-4 h-4 text-red-500" style="color: #EF4444;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                                    //activo_icono = 'NO';
                                }

                                if (row.casa_propia) {
                                    casa_propia_icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="Check" data-lucide="Check" class="lucide lucide-Check w-4 h-4 text-green-500" style="color: #10B981;"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                                    //casa_propia_icono = 'SI';
                                }else{
                                    casa_propia_icono = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="X" data-lucide="X" class="lucide lucide-X w-4 h-4 text-red-500" style="color: #EF4444;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                                    //casa_propia_icono = 'NO';
                                }

                                

                                var nuevoFila = [
                                    row.id, row.descripcion_casa,cliente_habita_icono ,row.direccion, row.foto, row.ubicacion, row.coordenadas,
                                     row.monto,row.fecha_cobro,row.qr, activo_icono , casa_propia_icono, 
                                    '<button class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-warning border-warning text-slate-900 dark:border-warning editar mb-2 mr-1 editar"'+
                                        'data-id="'+row.id+'"'+ 
                                        'data-descripcion_casa="'+row.descripcion_casa+'"'+ 
                                        'data-direccion="'+row.direccion+'"'+ 
                                        'data-monto="'+row.monto+'"'+ 
                                        'data-cliente_habita="'+row.cliente_habita+'"'+ 
                                        'data-fecha_cobro="'+row.fecha_cobro+'"'+
                                        'data-coordenadas="'+row.coordenadas+'"'+
                                        'data-casa_propia="'+row.casa_propia+'"'+
                                        'data-pais="'+row.id_pais+'"'+
                                        'data-departamento="'+row.id_departamento+'"'+
                                        'data-municipio="'+row.id_municipio+'"'+
                                        'data-activo="'+row.activo+'"'+
                                    '><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit stroke-1.5 h-4 w-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">'+
                                    '</path></svg></button>'+
                                    '<button class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-danger border-danger text-white dark:border-danger eliminar mb-2 mr-1 eliminar"'+
                                        'data-id="'+row.id+'"'+ 
                                        'data-descripcion_casa="'+row.descripcion_casa+'"'+ 
                                        'data-direccion="'+row.direccion+'"'+ 
                                        'data-monto="'+row.monto+'"'+ 
                                        'data-cliente_habita="'+row.cliente_habita+'"'+ 
                                        'data-fecha_cobro="'+row.fecha_cobro+'"'+
                                        'data-coordenadas="'+row.coordenadas+'"'+
                                        'data-casa_propia="'+row.casa_propia+'"'+
                                        'data-pais="'+row.id_pais+'"'+
                                        'data-departamento="'+row.id_departamento+'"'+
                                        'data-municipio="'+row.id_municipio+'"'+
                                        'data-activo="'+row.activo+'"'+
                                    '><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash" data-lucide="trash" class="lucide lucide-trash stroke-1.5 h-4 w-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg></button>'
                                ]; 
                            }
                            if (accion == 1) { 
                                $('#sdatatable').DataTable().row.add(nuevoFila).draw();
                            } else if (accion == 2) { 
                                $('#sdatatable').DataTable().row(rowNumber).data(nuevoFila);
                            } else if (accion == 3) {
                                $('#sdatatable').DataTable().row(rowNumber).remove().draw();
                            }
                            
                        }
                        notificacion(); 
                        accion_guardar = false;
                        const el = document.querySelector("#modal_nuevo_cliente");
                        const modal = tailwind.Modal.getOrCreateInstance(el);
                        modal.hide();
                    },
                });
            }

            function consultar_municipios(id_departamento) {
                // if (onTomSelect) {
                //     tomSelect.disable();
                // }
                $('#modal_input_municipio').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: url_consultar_municipios,
                    data: {
                        'id_departamento': id_departamento
                    },
                    success: function(data) {
                        var municipios = data.departamento_municipios;
                        
                        // if (onTomSelect) {
                        //     tomSelect.destroy();
                        //     onTomSelect = false;
                        // }

                        $('#modal_input_municipio').html('');

                        for (let i = 0; i < municipios.length; i++) {
                            $('#modal_input_municipio').append('<option value="'+municipios[i].id_municipio+'">'+municipios[i].nombre+'</option>');
                        }
                        $('#modal_input_municipio').prop('disabled', false);
                        if(accion == 2){
                            datos_inputs();
                        }
                        // var $select = $('#modal_input_municipio');
                        // if(!onTomSelect){
                        //     tomSelect = new TomSelect($select.get(0), {
                        //         placeholder: 'Selecciona un Municipio'
                        //     }); 
                        //     tomSelect.enable();
                        //     onTomSelect = true;
                        // }
                        // tomSelect.wrapper.classList.add('x-base', 'tom-select');
                        
                    },
                });
            }

            function notificacion() {
                var type = null;

                if (typeMsg == "success") {
                    type = "#success-notification-content";
                }
                if (typeMsg == "error") {
                    typeMsg = "danger";
                    type = "#danger-notification-content";
                }
                
                $("#"+typeMsg+"-notification").html('<div class="font-medium">' + titleMsg + "</div>" + '<div class="mt-1 text-slate-500">' + textMsg + "</div>");

                Toastify({
                    node: $(type).clone().removeClass("hidden")[0],
                    duration: 5000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                }).showToast();
            }

        </script>
    @endpush
@endonce