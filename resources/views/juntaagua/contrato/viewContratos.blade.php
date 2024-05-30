@extends('../layouts/' . $layout)
@section('subhead')
    <title>Contratos</title>
@endsection

@section('subcontent')
{{--Encabezado--}}
<div class="px-5 pt-5 mt-5 intro-y box">
    <div class="flex flex-col pb-5 -mx-5 border-b border-slate-200/60 dark:border-darkmode-400 lg:flex-row">
        <div class="flex items-center justify-center flex-1 px-5 lg:justify-start">


                    <x-base.lucide
                        class="w-40 h-40"
                        icon="FileText"
                    />


            <div class="ml-5">
                <div class="text-lg font-medium truncate w-240 sm:w-80 sm:whitespace-normal">

                    <h1 class="text-5xl font-medium leading-none">CONTRATOS</h1>
                </div>
                <div class="text-slate-500">Pantalla de administración de contratos.</div>
            </div>
        </div>
    </div>
</div>
{{--Data Table--}}
<div class="p-5 mt-5 intro-y box">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-6 intro-y lg:col-span-6">
            <div class="p-5">
                <h3 class="text-2xl font-medium leading-none"><div class="flex items-center">
                    <i data-lucide="List" class="w-6 h-6 mr-1"></i>
                        <span class="text-white-700"> Lista de Contratos</span>
                    </div></h3>
            </div>
        </div>
        <div class="col-span-6 text-right intro-y lg:col-span-6">
            <div class="p-5">
                    <x-base.button
                        class="mb-2 mr-1"
                        variant="primary"
                        id="btn_nuevo_contrato"
                    ><i data-lucide="Plus" class="w-4 h-4 mr-1"></i>
                         Registrar Nuevo Contrato
                    </x-base.button>

            </div>
        </div>
    </div>
    <div class="overflow-x-auto scrollbar-hidden">
        <table id="tablaContrato" class="display datatable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Servicio</th>
                    <th>Nombre Cliente</th>
                    <th>Descripcion Casa</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th>Creado</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listarContratos as $item)
                    <td>{{$item->id}}</td>
                    <td>{{$item->servicio}}</td>
                    <td>{{$item->nombre_cliente}}</td>
                    <td>{{$item->descripcion_casa}}</td>
                    <td>{{$item->fehca_inicio}}</td>
                    <td>{{$item->fecha_fin}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@once
    @push('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/js/pages/modal/index.js')
    @vite('resources/js/vendor/toastify/index.js')
    @vite('resources/js/pages/notification/index.js')

    <script type="module">
        var table = null;

        $(document).ready(function () {
            console.log('Loading');
            table = $('#tablaContrato').DataTable({
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
    </script>



    @endpush
@endonce
