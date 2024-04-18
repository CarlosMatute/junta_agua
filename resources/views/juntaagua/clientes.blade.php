@extends('../layouts/' . $layout)

@section('subhead')
    <title>Clientes</title>
@endsection

@section('subcontent')

        <!-- BEGIN: Profile Info -->
        <div class="intro-y box mt-5 px-5 pt-5">
            <div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
                <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
                   
                   
                            <x-base.lucide
                                class="h-40 w-40"
                                icon="users"
                            />
                        
                
                    <div class="ml-5">
                        <div class="w-240 truncate text-lg font-medium sm:w-80 sm:whitespace-normal">
                            
                            <h1 class="text-5xl font-medium leading-none">CLIENTES</h1>
                        </div>
                        <div class="text-slate-500">Pantalla de administración de clientes.</div>
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
                    <h3 class="text-2xl font-medium leading-none"><div class="flex items-center">
                        <i data-lucide="List" class="w-6 h-6 mr-1"></i>
                            <span class="text-white-700"> Lista de Zonas</span>
                        </div></h3>
                </div>
            </div>
            <div class="intro-y col-span-6 lg:col-span-6 text-right">
                <div class="p-5">
                        <x-base.button
                            class="mb-2 mr-1"
                            variant="primary"
                            id="btn_nueva_zona"
                        ><i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                             Registrar Nuevo Cliente
                        </x-base.button>
                   
                </div>
            </div>
        </div>
        <div class="scrollbar-hidden overflow-x-auto">
            <table id="sdatatable" class="display datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Zona</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($clientes as $row)
                    <tr>
                        <td>{{$row->created_at}}</td>
                        <td>{{$row->created_at}}</td>
                        <td>{{$row->created_at}}</td>
                        <td>{{$row->created_at}}</td>
                        <!-- Aquí puedes agregar más columnas según tus necesidades -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
        <!-- BEGIN: Modal Content -->
        <x-base.dialog id="modal_nueva_zona" size="xl">
            <x-base.dialog.panel>
                <x-base.dialog.title class="bg-primary">
                    <h2 class="mr-auto text-white font-medium">
                        <div class="flex items-center">
                        <i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                            <span class="text-white-700"> Registrar Nuevo Cliente
                        </div>
                    </h2>
                </x-base.dialog.title>
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_primer_nombre">
                            Primer Nombre
                        </x-base.form-label>
                        <x-base.form-input id="modal_input_primer_nombre" type="text" placeholder="Escriba el Primer Nombre" />
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_segundo_nombre">
                            Segundo Nombre
                        </x-base.form-label>
                        <x-base.form-input id="modal_input_segundo_nombre" type="text" placeholder="Escriba el Segundo Nombre" />
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_primer_apellido">
                            Primer Apellido
                        </x-base.form-label>
                        <x-base.form-input id="modal_input_primer_apellido" type="text" placeholder="Escriba el Primer Apellido" />
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_segundo_apellido">
                            Segundo Apellido
                        </x-base.form-label>
                        <x-base.form-input id="modal_input_segundo_apellido" type="text" placeholder="Escriba el Segundo Apellido" />
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_genero">
                            Género
                        </x-base.form-label>
                        <x-base.tom-select id="modal_input_genero" class="w-full" data-placeholder="Selección de Género">
                            @foreach($generos as $row)
                            <option value="{{$row->id}}">{{$row->nombre}}</option>
                            @endforeach
                        </x-base.tom-select>
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_celular">
                            Celular
                        </x-base.form-label>
                        <x-base.form-input id="modal_input_celular" type="number" placeholder="Escriba el Celular" />
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_departamento">
                            Departamento
                        </x-base.form-label>
                        <x-base.tom-select id="modal_input_departamento" class="w-full" data-placeholder="Selección de Departamento">
                            @foreach($departamentos as $row)
                            <option value="{{$row->id}}">{{$row->nombre}}</option>
                            @endforeach
                        </x-base.tom-select>
                    </div>
                    <div class="col-span-12 md:col-span-12 lg:col-span-6">
                        <x-base.form-label class="font-extrabold" for="modal_input_municipio">
                            Municipio
                        </x-base.form-label>
                        <select id="modal_input_municipio" class="w-full" data-placeholder="Selección de Municipio">
                            <option id="opc"></option>
                        </select>
                    </div>
                </x-base.dialog.description>
                <x-base.dialog.footer class="bg-dark">
                    <x-base.button size="sm" class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="danger">
                        Cancelar
                    </x-base.button>
                    <x-base.button size="sm" class="w-20" type="button" variant="primary" id="modal_btn_guardar_zona">
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
                        ¿Realmente desea eliminar esta Zona?<br />
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
    @push('vendors')
        @vite('resources/js/vendor/tabulator/index.js')
        @vite('resources/js/vendor/lucide/index.js')
        @vite('resources/js/vendor/xlsx/index.js')
    @endpush
@endonce
@once

    @push('scripts')
        @vite('resources/js/pages/slideover/index.js')
        @vite('resources/js/pages/modal/index.js')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite('resources/js/pages/modal/index.js')
        @vite('resources/js/vendor/toastify/index.js')
        @vite('resources/js/pages/notification/index.js')
        <script type="module">
            var accion_guardar = false;
            var accion = null;
            var id = null;
            var nombre = null;
            var descripcion = null;
            var url_consultar_municipios = "{{url('/departamentos-municipios')}}";
            var tabulator_id_solicitud = null;
            var tabulator_id_viajeros = null;
            var tabulator_viajeros = null;
            var tabulator_editar = null;
            var enviar_correo = null;
            var tabulator = null;

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    
                });	 

                //$.fn.dataTable.isDataTable('#sdatatable')
                    // Inicializa el DataTable
                    $('#sdatatable').DataTable({
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
            });

            $("#btn_nueva_zona").on("click", function (event) {
                $("#modal_input_primer_nombre").val('');
                $("#modal_input_segundo_nombre").val('');
                accion = 1;
                const el = document.querySelector("#modal_nueva_zona");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.show();

            });

            $('#modal_input_departamento').change(function(){
                var id_departamento = $(this).val();
                consultar_municipios(id_departamento);
            });

            function consultar_municipios(id_departamento) {
                accion_guardar = true;
                $.ajax({
                    type: "POST",
                    url: url_consultar_municipios,
                    data: {
                        'id_departamento': id_departamento
                    },
                    success: function(data) {
                        var municipios = data.departamento_municipios;
                        for (let i = 0; i < municipios.length; i++) {
                            $('#opc').append('<option value="'+municipios[i].id_municipio+'">'+municipios[i].nombre+'</option>');
                           
                        console.log(municipios[i].id_municipio);
                        }
                        var $select = $('#modal_input_municipio');
                        var tomSelect = new TomSelect($select.get(0), {
                        placeholder: 'Selecciona un Municipio',
                        });
                        tomSelect.wrapper.classList.add('x-base', 'tom-select');
                    },
                });
            }

        </script>
    @endpush
@endonce