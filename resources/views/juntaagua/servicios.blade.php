@extends('../layouts/' . $layout)

@section('subhead')
    <title>Servicio</title>
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
                    
                    <h1 class="text-5xl font-medium leading-none">SERVICIO</h1>
                </div>
                <div class="text-slate-500">Pantalla de administración de servicio.</div>
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
                    <span class="text-white-700"> Lista de servicio</span>
                </div></h3>
        </div>
    </div>
    <div class="intro-y col-span-6 lg:col-span-6 text-right">
        <div class="p-5">
                <x-base.button
                    class="mb-2 mr-1"
                    variant="primary"
                    id="btn_nuevo_cliente"
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
                <th>Nombres</th>               
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tipo_servicio as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->nombre}} </td>                
                <td>
                    <x-base.button
                        class="mb-2 mr-1 editar"
                        variant="warning"
                        size="sm"
                        data-id="{{$row->id}}" 
                        data-nombre="{{$row->nombre}}"                         
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
                        data-nombre="{{$row->nombre}}"                        
                    >
                        <x-base.lucide
                            class="h-4 w-4"
                            icon="Trash"
                        />
                    </x-base.button>
                </td>
                <!-- Aquí puedes agregar más columnas según tus necesidades -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<!-- BEGIN: Modal Content -->
<x-base.dialog id="modal_nuevo_servicio" size="xl">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-primary">
            <h2 class="mr-auto text-white font-medium">
                <div class="flex items-center">
                <i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                    <span class="text-white-700"> Registrar Nuevo Servicio
                </div>
            </h2>
        </x-base.dialog.title>
        <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
            <div class="col-span-12 md:col-span-12 lg:col-span-6">
                <x-base.form-label class="font-extrabold" for="modal_input_nombre">
                    Tipo Servicio
                </x-base.form-label>
                <x-base.form-input id="modal_input_nombre" type="text" placeholder="Escriba el nombre del servicio" />
            </div>
            
        </x-base.dialog.description>
        <x-base.dialog.footer class="bg-dark">
            <x-base.button size="sm" class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="danger">
                Cancelar
            </x-base.button>
            <x-base.button size="sm" class="w-20" type="button" variant="primary" id="modal_btn_guardar_servicio">
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
                ¿Realmente desea eliminar este Servicio?<br />
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
            var nombre = null;           
            var url_guardar_servicios = "{{url('/servicio/guardar')}}";
            var onTomSelect = false;
            var tomSelect = null;
            var titleMsg = null;
            var textMsg = null;
            var typeMsg = null;
            var numerofila = null;
            var table = null;
            var rowNumber = null;
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

                   
                    //consultar_municipios(id_departamento);
            });

            $("#sdatatable tbody").on( "click", "tr", function () { 
                                     rowNumber=parseInt(table.row( this ).index()); 
                                     table.$('tr.selected').removeClass('selected'); 
                                     $(this).addClass('selected'); 
                                     localStorage.setItem("sdatatable_id_seleccionar",table.row( this ).data()[0]); 
                                     }); 

            $('#sdatatable tbody').on('click', '.editar', function() {
                accion = 2;
                id = $(this).data('id');
                nombre = $(this).data('nombre');               
            });

            function datos_inputs(){
                $("#modal_input_nombre").val(nombre);                
                const el = document.querySelector("#modal_nuevo_servicio");
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

            $("#btn_nuevo_cliente").on("click", function (event) {
                $("#modal_input_nombre").val('');                
                accion = 1;
                const el = document.querySelector("#modal_nuevo_servicio");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.show();
            });

            

            $("#modal_btn_guardar_servicio").on("click", function () {
                nombre = $("#modal_input_nombre").val();
                
                
                if(nombre == null || nombre == ''){
                    titleMsg = 'Valor Requerido'
                    textMsg = 'Debe especificar un valor para Servicio.';
                    typeMsg = 'error';
                    notificacion()
                    return false;
                }
                
                if(!accion_guardar){
                    guardar_servicios();
                }
            });

            $("#btn_eliminar").on("click", function () {
                guardar_servicios();
                const el = document.querySelector("#modal_eliminar");
                const modal = tailwind.Modal.getOrCreateInstance(el);
                modal.hide();
            });

            function guardar_servicios() {
                accion_guardar = true;
                $.ajax({
                    type: "POST",
                    url: url_guardar_servicios,
                    data: {
                        'accion' : accion,
                        'id' : id,
                        'nombre' : nombre
                        
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
                                var row = data.clientes_list;
                                var nuevoFila = [
                                    row.id, row.nombre,
                                    '<button class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-warning border-warning text-slate-900 dark:border-warning editar mb-2 mr-1 editar"'+
                                        'data-id="'+row.id+'"'+ 
                                        'data-nombre="'+row.nombre+'"'+
                                    '><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="edit" data-lucide="edit" class="lucide lucide-edit stroke-1.5 h-4 w-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">'+
                                    '</path></svg></button>'+
                                    '<button class="transition duration-200 border shadow-sm inline-flex items-center justify-center rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed text-xs py-1.5 px-2 bg-danger border-danger text-white dark:border-danger eliminar mb-2 mr-1 eliminar"'+
                                        'data-id="'+row.id+'"'+ 
                                        'data-nombre="'+row.nombre+'"'+ 
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
                        const el = document.querySelector("#modal_nuevo_servicio");
                        const modal = tailwind.Modal.getOrCreateInstance(el);
                        modal.hide();
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