@extends('../layouts/' . $layout)
@section('subhead')
    <title>Contratos</title>
@endsection

@section('subcontent')
{{-- Mostrar Mensajes Flash --}}
        @if(session('msgSuccess'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('msgSuccess') }}
            </div>
        @endif

        @if(session('msgError'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('msgError') }}
            </div>
        @endif

        @if(session('msgWarning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ session('msgWarning') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
                <a class="bg-primary  text-white font-bold py-2 px-4 rounded" 
                href="{{ Route('crear_contrato') }}">
                    Agregar Nuevo Contrato
                </a>

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
                <tr>    
                    <td>{{$item->id}}</td>
                    <td>{{$item->servicio}}</td>
                    <td>{{$item->nombre_cliente}}</td>
                    <td>{{$item->descripcion_casa}}</td>
                    <td>{{$item->fecha_inicio}}</td>
                    <td>{{$item->fecha_fin}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                        <!-- Botón Editar -->
                        <a href="{{ route('editar_contrato', $item->id) }}" class="bg-warning hover:bg-yellow-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="Edit"
                            />
                        </a>

                        <!-- Formulario para Eliminar -->
                        <form action="{{ route('eliminar_contrato', $item->id) }}" method="GET" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-danger hover:bg-red-700 text-white font-bold h-10 w-10 rounded flex items-center justify-center">
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="Trash"
                                />
                            </button>
                        </form>
                    </td>
                </tr>
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
